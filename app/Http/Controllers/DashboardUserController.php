<?php

namespace App\Http\Controllers;

use App\Models\Nfts;
use App\Models\User;
use App\Models\Wallets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\DB;
use Hash;

class DashboardUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nfts  $nfts
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nfts  $nfts
     * @return \Illuminate\Http\Response
     */
    public function edit(Nfts $nfts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nfts  $nfts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nfts  $nfts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function changePassword(Request $request)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            return view('dashboard.changepassword', compact('user'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    public function updatePassword(Request $request)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $uid = $user->id;

            $password = $request->input("password");
            $cpassword = $request->input("conf_pass");
            $current_pass = $request->input("current_pass");
            if( $password == $current_pass)
            {
                return redirect("changepassword")->with('error','Opps! It seems you are using old password. Please try with new password!');
            }else{
                if($password == $cpassword)
                {
                    $pwd = Hash::make($password);
                    $result = DB::table('users')
                    ->where('id', $uid)
                    ->update(array('password' => $pwd));   
                    if($result)
                    {
                        return redirect("changepassword")->with('success','Your password successfully changed!. Please logion with new password.');
                    }else{
                        return redirect("changepassword")->with('error','Oops, Something wrong! Please contatc with administrator.');
                    }
                }else{
                    return redirect("changepassword")->with('error','Opps! Password not matched! Please check password and confirm passowrd should be same.');
                }
            }
        }
    }
    
    public function editProfile()
    {
        if(Auth::check())
        {
            $user = Auth::user();
            return view('dashboard.editprofile', compact('user'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    public function updateProfile(Request $request)
    {
        $inputdata = array();
        if(Auth::check())
        {
            $user = Auth::user();
            $uid = $user->id;

            if($request->hasfile('dp'))
            {
                $file = $request->file('dp');
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                $inputdata['dp'] = $filePath;
            }
            
            $phone = $request->input("phone");
            $inputdata['phone'] = $phone;
            $otp = $this->generateNumericOTP(6);
            $otpEmail = $this->generateNumericOTP(6,true);
            $inputdata['otp'] = $otp;
            $inputdata['email_otp'] = $otpEmail;
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
            
            $result = DB::table('users')
                    ->where('id', $uid)
                    ->update($inputdata); 
            
            if($result)
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
                return redirect("editprofile")->with('success','OTP Sent Successfully.');
            }else{
                return redirect("editprofile")->with('error','Something went wrong!');
            }
        }
    }
    
    public function editEmailPhone()
    {
        if(Auth::check())
        {
            $user = Auth::user();
            return view('dashboard.editemailphone', compact('user'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    
    public function checkUserOtp(Request $request)
    {
        $user = DB::table('users')
        ->where('otp', '=', $request->input('phone_otp'))
        ->orWhere('email_otp', '=', $request->input('email_otp'))
        ->first();
        if ($user === null)
        {
            echo 0;
        }else{
            $result = DB::table('users')
            ->where('id', $user->id)
            ->update(array('phone_verified' => 1, 'email_verified' => 1));
            if($result)
            {
                echo 1;
            }else{
                echo 0;
            }
        }
        die;
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
}
