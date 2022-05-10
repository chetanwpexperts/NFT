<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\Wallets;
use App\Models\Auctions;
use App\Models\Offers;
use App\Models\Nfts;
use Illuminate\Support\Facades\DB;
use Hash;
use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.register');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) 
        {
            /*if(Auth::user()->user_type == "")
            {
                return redirect()->intended('newuser')
                                    ->withSuccess('Please select what type of account you want to gp with?');
                
            }else{ */
                Session::put('user_id', Auth::user()->id);
                Session::put('email_id', Auth::user()->email);
                Session::put('user_type', Auth::user()->user_type);
                Session::put('creatorId', Auth::user()->creator_id);
                Session::put('dp', Auth::user()->dp);
                $request->session()->save();
                return redirect()->intended('dashboard')
                                    ->with('success','Logged in successfully.');
            /* } */
        }

        return redirect("login")->withSuccess('Sorry! You have entered invalid credentials');
    }
    
    public function newUser()
    {
         if(Auth::check()){
             $user_id = Auth::user()->id;
             return view('auth/newuser', compact('user_id'));
        }
    }
    
    public function updateUserType(Request $request)
    {
         $user_id = $request->input('id');
         $user_type = $request->input('user_type');

         $result = DB::table('users')
                    ->where('id', $user_id)
                    ->update(array('user_type' => $user_type));
         if($result)
         {
            echo $user_type;
         }else{
            echo 0;
         }

         die;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|min:10'
        ]);
        $unique_creator_id = random_int(10000000, 99999999);
        $phone = $request->input("phone");
        $otp = $this->generateNumericOTP(6);
        $otpEmail = $this->generateNumericOTP(6,true);
        $apiurl = "https://2factor.in/API/V1/1ce57915-b246-11eb-8089-0200cd936042/SMS/";
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $apiurl.$phone."/".$otp."/NFT-REGISTERATION",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
          die;
        } else {
            $inputdata = array(
                'name' => $request->input("name"),
                'email' => $request->input("email"),
                'phone' => $request->input("phone"),
                'otp' => $otp,
                'email_otp' => $otpEmail,
                'creator_id' => $unique_creator_id
            );

            if($request->hasfile('dp'))
            {
                $file = $request->file('dp');
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                $inputdata['dp'] = $filePath;
            }

            // $data = $request->all();
            $check = User::create($inputdata);
            if($check)
            {
                $arr = array(
                    "mail_id"=> 7,
                    "subject"=> "NFT's Registration OTP",
                    "body"=> "Your OTP is " . $otpEmail,
                    "to"=>array(
                            array(
                                "email"=> $request->input('email'),
                                "name" => $request->input('name')
                            )
                        )
                );

                $arr = json_encode($arr);

                $url = 'https://liveapps.face2friend.com/api/sendEmail';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);
                echo 1;
            }else{
                echo 2;
            }
        }
        die;
    }

    public function verifyOtp()
    {
        return view('auth.verifyotp');
    }
    
    public function otpresend()
    {
        return view('auth.resendotp');
    }

    public function checkOtp(Request $request) 
    {
        $otp = $request->input('phone_otp');
        $email_otp = $request->input('email_otp');
        $user = User::where("otp", '=', $otp)->where("email_otp", '=', $email_otp)->first();
        if ($user === null)
        {
            echo 0;
        }else{
            
            DB::table('users')
            ->where('id', $user->id)
            ->update(array('phone_verified' => 1, 'email_verified' => 1));
            Session::put('user_id', $user->id);
            $request->session()->save();
            echo $user->id;
        }
        die;
    }

    public function setPassword()
    {
        return view('auth.setpassword');
    }

    public function submitSetPassword(Request $request)
    {
        $uid = Session::get('user_id');
        $request->validate([
            'password' => 'required',
            'conf_pass' => 'required'
        ]);
        $password = $request->input("password");
        $cpassword = $request->input("conf_pass");

        if($password == $cpassword)
        {
            $pwd = Hash::make($password);
            if($request->input("reset_tokan") != null)
            {
                 DB::table('users')
                ->where('reset_tokan', $request->input("reset_tokan"))
                ->update(array('password' => $pwd));
            }else{
                DB::table('users')
                ->where('id', $uid)
                ->update(array('password' => $pwd));   
            }
            $request->session()->flush();
            echo 1;
        }else{
            echo 0;
        }
        die;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check())
        {   
            if(Auth::user()->user_type == "")
            {
                return view('auth/newuser');
            }else{
                $user = Auth::user();
                $creatorWallet = Wallets::where('user_id', $user->creator_id)->sum('wallet_amount');
                $totalSpent = DB::table('statements')->where('user', $user->creator_id)->where('mode', "=", "debit")->sum('amount');
                $totalEarning = DB::table('statements')->where('user', $user->creator_id)->where('mode', "=", "credit")->sum('amount');
                return view('dashboard/dashboard',compact('user','creatorWallet','totalSpent','totalEarning'));
            }
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => Hash::make($data['password'])
      ]);
    }


    public function forgotpassword()
    {
        return view('auth.forgotpassword');
    }

    public function randomPassword() 
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) 
        {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public function postforgotpassword(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);
        $email = $request->input("email");
        $userDetails = DB::table('users')
                    ->where('email', $email)
                    ->get();
        if(!empty($userDetails))
        {
            $link = route('auth.setpassword');
            $resettokan = $this->randomPassword();
            DB::table('users')
            ->where('email', $email)
            ->update(array('reset_tokan' => $resettokan));

            $arr = array(
                "mail_id"=> 7,
                "subject"=> "Reset Link to change password.",
                "body"=> "Please got to this link <a href='" . $link."?tokan=". $resettokan . "'>Set New Password</a> and change your password.",
                "to"=>array(
                        array(
                            "email"=> $request->input('email'),
                            "name" => $userDetails[0]->name
                        )
                    )
            );

            $arr = json_encode($arr);

            $url = 'https://liveapps.face2friend.com/api/sendEmail';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            echo 1;
        }else{
            echo 0;
        }
        die;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() 
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
    
    public function generateNumericOTP($n=6, $otp2=NULL) 
    {
        $generator = ($otp2 != NULL) ? "7902653814" : "1357902468";
        $result = "";
        for ($i = 1; $i <= $n; $i++) 
        {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }
        return $result;
    }
    
    public function creator()
    {
        if(Auth::check())
        {
            $user_id = Auth::user()->id;
            $unique_creator_id = Auth::user()->creator_id;
            $utype = Auth::user()->user_type;
            return view('auth/creator', compact('unique_creator_id', 'user_id','utype'));
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    public function storeCreator(Request $request)
    {
        $user_id = Auth::user()->id;
        $data = array();
        $socailaccounts = array();
        if($request->hasfile('vfile'))
        {
            $vfile = $request->file('vfile');
            $arrayFileName = explode(".", $vfile->getClientOriginalName());                           
            $filename = Auth::user()->creator_id ."_". $vfile->getClientOriginalName();
            $extension = $vfile->extension(); 
            $filePath = $vfile->storeAs('uploads/userMedia', $filename, 'public');
            $data['video'] = $filePath;
        }
        foreach($request->input("social_media_accounts") as $saccount)
        {
            if($saccount != "")
            {
                $socail_media_accounts[] = $saccount;
            }
        }
        $social_media_accounts = implode(",", $socail_media_accounts);
        $data['user_type'] = "creator";
        $data['social_media_accounts'] = rtrim($social_media_accounts,",");
        $result = DB::table('users')
            ->where('id', $user_id)
            ->update($data);
        if($result)
        {
            $check_if_creator_varified = DB::table('users')
                    ->where('id', $user_id)
                    ->first();
             if($check_if_creator_varified->user_type == "creator")
             {
                 echo 2;
             }else{
                 echo 1;
             }
        }else{
            echo 0;
        }
        die;
        
    }
    
    public function vdashboard()
    {
         if(Auth::check())
         {
            $user = Auth::user();
            $creatorWallet = Wallets::where('user_id', $user->creator_id)->sum('wallet_amount');
            $totalSpent = DB::table('statements')->where('user', $user->creator_id)->where('mode', "=", "debit")->sum('amount');
            $totalEarning = DB::table('statements')->where('user', $user->creator_id)->where('mode', "=", "credit")->sum('amount');
            return view('dashboard/dashboard', compact('user','creatorWallet','totalSpent','totalEarning'));
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    public function verifyUser(Request $request)
    {
        $status = "";
        $message = "";
        $success = "";
        if($request->input('status') == "")
        {
            $status = 0;
        }else{
            $status = 1;
        }
        
        $badges = $request->input('badges');
        
        DB::table('users')
            ->where('id', $request->input('id'))
            ->update(array('status' => $status, 'badges' => $badges));
        
        $verifiedUser = DB::table('users')
                    ->where('id', $request->input('id'))
                    ->get();
        
        if($status == 1)
        {
            $success = "User Verified Successfully";
            $message = "Hello " . ucfirst($verifiedUser[0]->name) . ", Now You are verified by the admin as " . ucfirst($verifiedUser[0]->user_type) . ". You can login and create your first NFT.";
        }else{
            $success = "User Unverified Successfully";
            $message = "Hello " . ucfirst($verifiedUser[0]->name) . ", We have found an issue in your account. Please try again to upload video and signatue and also please provide us your social account so we can verify easily its you.";
        }
        $arr = array(
            "mail_id"=> 7,
            "subject"=> "NFT Account Verification " . "(#" . $verifiedUser[0]->creator_id . ")",
            "body"=> $message,
            "to"=>array(
                    array(
                        "email"=> $verifiedUser[0]->email,
                        "name" => $request->input('name')
                    )
                )
        );

        $arr = json_encode($arr);

        $url = 'https://liveapps.face2friend.com/api/sendEmail';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return back()->with('success','Email Sent! '. $success);
    }
    
    public function userView($id)
    {
        return true;
    }
    
    public function deleteUser($id)
    {
         return true;
        //DB::table('users')->where('id', $id)->delete();
        //return back()->with('success','User Deleted Successfully'. $success);
    }
    
    public function refundbackifhighbid($nftid)
    {
        $success = "";
        $highestBid = DB::table('auctions')->where('nftid', $nftid)->max('bid_amount');
        $getHighestBidder = DB::table('auctions')->where('nftid', $nftid)->where('bid_amount', $highestBid)->first();
        if(!empty($highestBid))
        {
            $highestBidderId = $getHighestBidder->user_id;
            $highestBidderAmount = $highestBid;
            $allAuctions = Auctions::where('nftid', $nftid)->get();
            foreach($allAuctions as $auctions)
            {
                if($auctions->user_id != $highestBidderId)
                {
                    /**
                    * return paid amount to lowest amount bidders **/
                    $userWallet = Wallets::where('user_id', $auctions->user_id)->sum('wallet_amount');
                    
                    /** 
                    check if bidder hava amount in nftescrrow table **/
                    $userPaidAmount = DB::table('nftescrows')->where('creator_id', $auctions->user_id)->where('nftid', $nftid)->sum('amount_paid');
                    
                    $payInfo = array();
                    $payInfo['wallet_amount'] = $userWallet + $userPaidAmount;
                    $rsult = DB::table('wallets')->where('user_id', $auctions->user_id)->update($payInfo);
                    
                    if($rsult)
                    {
                        $statement = array(
                            'user' => $auctions->user_id,
                            'amount' => $userPaidAmount,
                            'mode' => "refund",
                            'tax' => "0"
                        );

                        DB::table('statements')->insert($statement);
                    }

                    $result = Auctions::where("user_id", '=', $auctions->user_id)
                        ->update(array('status' => 0));
                    
                    if($result)
                    {
                        //$result = DB::table('nftescrows')->where("creator_id", '=', $auctions->user_id)
                        //->update(array('payment_status' => "refund", 'amount_paid' => 0, 'amount_pending' => 0));
                        /**
                        bidder out form acution **/
                        $result = DB::table('nftescrows')->where('nftid', "=", $nftid)->where('creator_id', $auctions->user_id)->delete();
                        
                        if($result)
                        {
                            $success = "true";
                        }else{
                            $success = "false";
                        }
                    }
                }
            }
            
            if($success == true)
            {
                /**
                * notification for refund 10% amount if heighest bidder available **/
                $refundNotification = array();
                $refundNotification['nftid'] = $auctions->nftid;
                $refundNotification['user_id'] = $auctions->user_id;
                $refundNotification['nofication_from'] = "auction";
                $refundNotification['action'] = "You got your refund of ". number_format($userPaidAmount,2);
                $refundNotification['link'] = "";
                DB::table('notifications')->insert($refundNotification);
            }
        }
    }
    
    function getAutoPurchase($bidder_id, $owner_id, $nftid, $purchased_amount, $winnerWallet, $bidderPreviousPaidAmount)
    {
        /**
        * check if bidder escrow payment status paid **/
        $isAlreadyPaid = DB::table('nftescrows')->where('creator_id', $bidder_id)->where('nftid', $nftid)->where('payment_status', "!=", "paid")->first();
        if(!empty($isAlreadyPaid))
        {
            $commission = "";
            $gst = "";
            $adminSettings = DB::table('settings')->get();
            foreach($adminSettings as $settings)
            {
                if($settings->display_name == "Commission") 
                {
                    $commission = $settings->value;//5
                }
                if($settings->display_name == "GST") 
                {
                    $gst = $settings->value;//18
                }
            }

            /**
            update buyer wallet **/
            $bidderRestAmountInWallet = $winnerWallet - $purchased_amount;
            $checkresponse = Wallets::where("user_id", $bidder_id)->update(array('wallet_amount' => $bidderRestAmountInWallet));
            
            DB::table('nftescrows')->where('nftid', $nftid)->where("creator_id", $bidder_id)->update(array('payment_status' => "paid", "amount_pending" => 0, 'amount_paid' => $purchased_amount));
            
            $statement = array(
                'user' => $bidder_id,
                'amount' => $purchased_amount,
                'mode' => "debit",
                'tax' => "0"
            );

            $result = DB::table('statements')->insert($statement);

            if($checkresponse)
            {
                /**
                * calculations
                * gst and commission **/
                
                $baseCommission = ($purchased_amount+$bidderPreviousPaidAmount) * $commission / 100;
                $commission = $baseCommission * $gst / 100;
                $serviceCharges = $baseCommission + $commission;
                $total_payable_amount = ($purchased_amount + $bidderPreviousPaidAmount) - $serviceCharges;
                //$total_payable_amount = (($purchased_amount + $bidderPreviousPaidAmount) - ());

                /**
                * check if owner have money in his wallet **/
                $ownerWallet = Wallets::where('user_id', $owner_id)->sum('wallet_amount');
                /**
                * add money to sellar's' wallet **/
                $payInfo = array();
                $payInfo['payment_id'] = NULL;
                $payInfo['user_id'] = $owner_id;
                $payInfo['wallet_amount'] = $ownerWallet + $total_payable_amount;
                $payInfo['status'] = 'active';
                $payInfo['paymentThrough'] = "auction";
                $payInfo['paymentFrom'] = "NFT-X";
                $rsult = DB::table('wallets')->where('user_id', $owner_id)->update($payInfo);

                if($rsult)
                {
                    $statement = array(
                        'user' => $owner_id,
                        'amount' => $total_payable_amount,
                        'mode' => "credit",
                        'tax' => "0"
                    );

                    $result = DB::table('statements')->insert($statement);

                    $statement = array(
                        'user' => $owner_id,
                        'amount' => $serviceCharges,
                        'mode' => "service charges",
                        'tax' => "0"
                    );

                    $result = DB::table('statements')->insert($statement);

                    /**
                    * check if already have amount in nft wallet **/
                    $totalnftearnings = DB::table('nft_earnings')->sum('amount');
                    $nftPayments = array();
                    $nftPayments['nftid'] = $nftid;
                    $nftPayments['amount'] = $serviceCharges;
                    $nftPayments['amount_form'] = $owner_id;
                    $nftPayments['payment_type'] = "service charges from sellter after nft sold";
                    $rsult = DB::table('nft_earnings')->insert($nftPayments);

                    if($rsult)
                    {
                        return true;
                    }else{
                        return false;
                    }

                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
    }
    
    function checkAuctionEnds()
    {
        $respo = "";
        $now = Carbon::now();
        $expiredNfts = Nfts::where('auction_end_time', '<', $now)->orderByDesc("id")->get();
        if(!empty($expiredNfts))
        {
            foreach($expiredNfts as $nft)
            {
                if($nft->auction_status != "sold")
                {
                    $biddersOnNft = Auctions::where('nftid', '=', $nft->nftid)->select('user_id')->get();
                    if(!empty($biddersOnNft))
                    {
                        foreach($biddersOnNft as $bidder)
                        {
                            /**
                            * get winner from auctions when auction date ends **/
                            $maxBidAmount = $this->checkHighestBidPrice($nft->nftid);
                            $winner = Auctions::where('nftid', $nft->nftid)->where('bid_amount', $maxBidAmount)->first();
                            if(!empty($winner) && $winner->status != 3)
                            {
                                if($bidder->user_id == $winner->user_id)
                                {
                                    $bidderWallet = Wallets::where('user_id', $winner->user_id)->sum('wallet_amount');
                                    /**
                                    if bidder has bid amount in his wallet afetr auction end **/
                                    if( $bidderWallet >= $maxBidAmount )
                                    {
                                        /**
                                        * get total pais amount of biddder if he made bid twise or more on same nft **/
                                        $bidderPreviousPaidAmount = $this->getBidderPaidAmount($bidder->user_id, $nft->nftid);

                                        $bid_amount = $maxBidAmount;
                                        $paid_amount = $bidderPreviousPaidAmount;
                                        $total_pending_amount = $bid_amount - $bidderPreviousPaidAmount;

                                        /**
                                        * didcut money right away if buyer has money in his wallet **/
                                        $checkresponse = $this->getAutoPurchase($bidder->user_id, $nft->owner_id, $nft->nftid, $total_pending_amount, $bidderWallet, $bidderPreviousPaidAmount);
                                        if($checkresponse)
                                        {
                                            /**
                                            * stop script if winner found 
                                            * 2 = winner
                                            **/
                                            Auctions::where('nftid', $nft->nftid)->where('user_id', $bidder->user_id)->update( array('status' => 2));

                                            /**
                                            * update bidder id as owner id in nft table **/
                                            Nfts::where("nftid", $nft->nftid)
                                                ->update(array('auction_status' => "sold", 
                                                               'owner_id' => $bidder->user_id));

                                            /**
                                            * nft goes as sold item **/
                                            $sold = array();
                                            $sold['owner_id'] = $nft->creator_id;
                                            $sold['nftid'] = $nft->nftid;
                                            $sold['status'] = "sold";
                                            $rsult = DB::table('soldnfts')->insert($sold);

                                            /**
                                            * purcahse table entry **/
                                            $purchaseInfo = array();
                                            $purchaseInfo['nftid'] = $nft->nftid;
                                            $purchaseInfo['owner_id'] = $bidder->user_id;
                                            $purchaseInfo['creator_id'] = $nft->creator_id;
                                            $purchaseInfo['type'] = "auction";
                                            $chckreps = DB::table('purchases')->insert($purchaseInfo);
                                            if($chckreps)
                                            {
                                                $respo = 1;
                                            }
                                        }else{
                                            $respo = 2;
                                        }
                                    }else{
                                        $bidder_id = $winner->user_id;
                                        $now = Carbon::now();
                                        //$waitingtime = Carbon::now()->addHours(5);
                                        $waitingtime = Carbon::now()->addMinutes(2);
                                        $bidDate   = $now;
                                        $status = "waiting";

                                        $status = $this->checkIfNftSold($nft->nftid, $bidder);
                                        if($status == "false")
                                        {
                                            /**
                                            * get total pais amount of biddder if he made bid twise or more on same nft **/
                                            $bidderPreviousPaidAmount = $this->getBidderPaidAmount($bidder_id, $nft->nftid);

                                            $bid_amount = $maxBidAmount;
                                            $paid_amount = $bidderPreviousPaidAmount;
                                            $total_pending_amount = $bid_amount - $bidderPreviousPaidAmount;

                                            $checkIfalreadyInwaiting = DB::table('final_auction')->where('auction_id', $winner->id)->first();
                                            if(empty($checkIfalreadyInwaiting))
                                            {
                                                /**
                                                * give two days time to winner **/
                                                $finalAuction = array();
                                                $finalAuction['nftid'] = $nft->nftid;
                                                $finalAuction['bidder_id'] = $bidder_id;
                                                $finalAuction['auction_id'] = $winner->id;
                                                $finalAuction['biddate'] = $bidDate;
                                                $finalAuction['waiting_time'] = $waitingtime;
                                                $finalAuction['amount_pending'] = $total_pending_amount;
                                                $finalAuction['status'] = "waiting";
                                                DB::table('final_auction')->insert($finalAuction);
                                                /**
                                                * stop script if winner found 
                                                * status 3 means waiting for payment 
                                                **/
                                                Auctions::where('nftid', $nft->nftid)->where('user_id', $bidder_id)->update( array('status' => 3));
                                                $respo = 3;
                                            }
                                        }
                                    }
                                }
                            }else{
                                /**
                                * already waiting to do payment **/
                                $respe = 3;
                            }
                        }
                    }
                }
            }
        }
        
        echo $respo;
    }
    
    function getBidderPaidAmount($bidder_id, $nftid)
    {
        $paidamount = 0;
        $bidderFinalAuction = DB::table('nftescrows')->where('nftid', $nftid)->where('creator_id', $bidder_id)->get();
        foreach($bidderFinalAuction as $auction)
        {
            $paidamount = $auction->amount_paid+$paidamount;
        }
        return $paidamount;
    }
    
    function checkHighestBidPrice($nftId)
    {
        $maxBidAmount = Auctions::where("nftid", $nftId)->max('bid_amount');
        return $maxBidAmount;
    }
    /**
    * payment didcution main function run at backend
    * work in both conditoins if user loggin or not
    * commission and gst calculated included
    * auto method runs every one hour
    **/
    public function checkPendings(Request $request)
    {
        $status = $this->checkAuctionEnds();
        if($status)
        {
            echo 1;
        }else{
            echo 0;
        }
        die;
    }
    
    public function doAuctionPayment($user_id)
    {
        return true;
    }
    
    public function checknftsold($nftId)
    {
        $solNfts = Nfts::join('purchases', 'nfts.nftid', '=', 'purchases.nftid')
               ->where('purchases.nftid', $nftId)->get(['purchases.*', 'purchases.nftid']);
        
        $count = count((array)$solNfts);
        if($count > 0)
        {
            return "sold";
        }
    }
    
    function checkIfEmailAlreadyRegistered(Request $request)
    {
        $users = User::where('email', $request->email)->get();

        # check if email is more than 1
        if(sizeof($users) > 0){
            echo 1;
        }else{
            echo 0;
        }
        
        die;
    }
    
    function checkIfPhoneAlreadyRegistered(Request $request)
    {
        $users = User::where('phone', $request->phone)->get();

        # check if email is more than 1
        if(sizeof($users) > 0){
            echo 1;
        }else{
            echo 0;
        }
        
        die;
    }
    
    function checkIfNftSold($nftid)
    {
        $nft = DB::table("nftescrows")->where('nftid', $nftid)->where('payment_status', "paid")->get();
        if(!empty($nft))
        {
           
            foreach($nft as $soldItem)
            {
                $whereArray = array('bidder_id' => $soldItem->creator_id,'nftid' => $soldItem->nftid);

                $query = DB::table('final_auction');
                foreach($whereArray as $field => $value) 
                {
                    $query->where($field, $value);
                }
                $query->delete();
                
                Auctions::where('nftid', $soldItem->nftid)->update(array("status" => 2));
            }
            
            return "false";
        }else{
            return "true";
        }
    }
}
