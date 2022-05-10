<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use App\Models\Wallets;
use App\Models\Auctions;
use App\Models\Offers;
use App\Models\Nfts;
use App\Models\User;
use Session;
use Redirect;
use Carbon\Carbon;
use URL;

class AuctionController extends Controller
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
    public function create(Request $request)
    {
        
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function addStatement($user_id, $amount, $paymentType, $tax=null)
    {
        $statement = array(
            'user' => $user_id,
            'amount' => $amount,
            'mode' => $paymentType,
            'tax' => $tax
        );

        $result = DB::table('statements')->insert($statement);
        if($result)
        {
            return "true";
        }else{
            return "false";
        }
    }
    
    public function sendNotification($user_id, $nftid, $nofication_from, $action, $link)
    {
        $notification = array();
        $notification['nftid'] = $nftid;
        $notification['user_id'] = $user_id;
        $notification['nofication_from'] = $nofication_from;
        $notification['action'] = $action;
        $notification['link'] = $link;
        $result = DB::table('notifications')->insert($notification);
        if($result)
        {
            return "true";
        }else{
            return "false";
        }
    }
    public function sendEmail($user_id, $nftid, $action, $waitingStatus=null)
    {
        $subject = "";
        $message = "";
        $user = User::where('creator_id',$user_id)->first();
        $email = $user->email;
        $name = $user->name;
        $nft = Nfts::where('nftid',$nftid)->first();
        switch($action)
        {
            case "newbid":
                $subject = "New Bid NFT - ( ". $nft->title .")";
                $message = "<p>Hi ". ucfirst($name) .". Congratulations, you got a heighest bid on your NFT. We will keep updating you.</p> <br /><p> Regards, <r />NFT-X Team.</p>";
                break;
            case "refund":
                $subject = "Money Refund NFT - ( ". $nft->title .")";
                $message = "<p>Hi ". ucfirst($name) .". Sorry, heighest bidder available. You can up try to make bid with heigh amount</p> <br /><p> Regards, <r />NFT-X Team.</p>";
                break;
            case "win":
                $subject = "NFT Win NFT - ( ". $nft->title .")";
                $message = "<p>Hi ". ucfirst($name) .". Congratulations, you have win this auction. Check your purchases after login on your NFT dashboard <br /><p> Regards, <r />NFT-X Team.</p>";
                break;
            case "newoffer":
                $subject = "New Offer NFT - ( ". $nft->title .")";
                $message = "<p>Hi ". ucfirst($name) .". Congratulations, you got an offer on your NFT. We will keep updating you.</p> <br /><p> Regards, <r />NFT-X Team.</p>";
                break;
            case "offeraccepted":
                $waitingMessage = "";
                if($waitingStatus != null)
                {
                    $waitingMessage = "As Offer Accepted but still you are not owner of this NFT. make sure you have pending amount in your wallet before 5 hours end Because you got 5 hours time make this your. " . $waitingMessage;
                }
                $subject = "offer Accepted NFT - ( ". $nft->title .")";
                $message = "<p>Hi ". ucfirst($name) .". Congratulations, your offer accepted. Hope you got your NFT in your purchase list. Check now to login.</p> <br /><p> Regards, <r />NFT-X Team.</p>";
                break;
            case "secondthirdbidderchance":
                $subject = "You are selected for NFT - ( ". $nft->title .")";
                $message = "<p>Hi ". ucfirst($name) .". Congratulations, You get a chance to win. As you were not a heighest bidder but now you are and you have only five horus to get this nft. Please update your wallet within five hours. .</p> <br /><p> Regards, <r />NFT-X Team.</p>";
                break;
            case "offerejected":
                $subject = "offer Rejected NFT - ( ". $nft->title .")";
                $message = "<p>Hi ". ucfirst($name) .". Sorry, your offer rejected. Hope you got your refund soon in your wallet. Check now to login.</p> <br /><p> Regards, <r />NFT-X Team.</p>";
                break;
            case "offerrepealed":
                $subject = "Offer Repealed NFT - ( ". $nft->title .")";
                $message = "<p>Hi ". ucfirst($name) .". You repelaed your offer successfully. You will get your refund soon. Check now to login.</p> <br /><p> Regards, <r />NFT-X Team.</p>";
                break;
            case "notifytoownerrepealedoffer":
                $subject = "Offer Repealed NFT - ( ". $nft->title .")";
                $message = "<p>Hi ". ucfirst($name) .". Offer repealed by the user.</p> <br /><p> Regards, <r />NFT-X Team.</p>";
                break;
            case "paymentfail":
                $subject = "Payment Fail NFT - ( ". $nft->title .")";
                $message = "<p>Hi ". ucfirst($name) .". You lost nft and token money as well. Because you did not make full payment for the NFT that you auctioned. we are sorry.</p> <br /><p> Regards, <r />NFT-X Team.</p>";
                break;
            case "ownerfees":
                $subject = "Auction Expired NFT - ( ". $nft->title .")";
                $message = "<p>Hi ". ucfirst($name) .". Sorry, auction expired that you stated for your own nft. You might be got a 25% payment form bidder's token mondy if any bidder available and he did not made payemnt on time. Login to your account for more updates. You can found your nft in your drafts and you can again publish your nft for demand and supply or auction.</p> <br /><p> Regards, <r />NFT-X Team.</p>";
                break;
        }
        
        $arr = array(
            "mail_id"=> 7,
            "subject"=> $subject,
            "body" => $message,
            "to"=>array(
                    array(
                        "email"=> $email,
                        "name" => $name
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
        
        return true;
    }
    
    public function inEscrow($auction_id, $nftid, $bidder_id, $owner_id, $offerPrice, $tokenmoneypaid,$type)
    {
        $newBid = array();
        $newBid['nftid'] = $nftid;
        $newBid['creator_id'] = $bidder_id;
        $newBid['auction_id'] = $auction_id;
        $newBid['amount_paid'] = $tokenmoneypaid;
        $newBid['amount_pending'] = $offerPrice - $tokenmoneypaid; // not recieved yet just display
        $newBid['owner_id'] = $owner_id;
        $newBid['payment_status'] = "pending";
        $newBid['type'] = $type;
        $rsult = DB::table('nftescrows')->insert($newBid);
        if($rsult)
        {
            return "true";
        }else{
            return "false";
        }
    }
    
    public function inAuction($nftid, $bidder_id, $owner_id, $offerPrice)
    {
        $bidInfo = array();
        $bidInfo['owner_id'] = $owner_id;
        $bidInfo['user_id'] = $bidder_id;
        $bidInfo['nftid'] = $nftid;
        $bidInfo['bid_amount'] = $offerPrice;
        $response = DB::table('auctions')->insert($bidInfo);
        if($response)
        {
            $auction_id = DB::table('auctions')->latest('id')->first();
            return array("status" => "true", "auction_id" => $auction_id);
        }else{
            return "false";
        }
    }
    
    public function inOffer($nftid, $bidder_id, $owner_id, $offerPrice)
    {
        $offer = array();
        $offer['owner_id'] = $owner_id;
        $offer['user_id'] = $bidder_id;
        $offer['nftid'] = $nftid;
        $offer['offer_amount'] = $offerPrice;
        $response = DB::table('offers')->insert($offer);
        if($response)
        {
            $offer_id = DB::table('offers')->latest('id')->first();
            return array("status" => "true", "offer_id" => $offer_id);
        }else{
            return "false";
        }
    }
    
    public function inWaiting($nftid, $bidder_id, $now, $waitingtime, $pendingAmount, $status, $auction_id)
    {
        $checkIfalreadyInwaiting = DB::table('final_auction')->where('auction_id', $auction_id)->first();
        if(empty($checkIfalreadyInwaiting))
        {
            /**
            * give time to winner for pay pending amount **/
            $finalAuction = array();    
            $finalAuction['nftid'] = $nftid;
            $finalAuction['bidder_id'] = $bidder_id;
            $finalAuction['auction_id'] = ($auction_id != "") ? $auction_id : "";
            $finalAuction['biddate'] = $now;
            $finalAuction['waiting_time'] = $waitingtime;
            $finalAuction['amount_pending'] = $pendingAmount;
            $finalAuction['status'] = $status;
            $result = DB::table('final_auction')->insert($finalAuction);
            if($result)
            {
                return "true";
            }else{
                return "false";
            }
        }else if(!empty($checkIfalreadyInwaiting) && $checkIfalreadyInwaiting->status == "waiting"){
            return "in waiting";
        }else if(!empty($checkIfalreadyInwaiting) && $checkIfalreadyInwaiting->status == "paid"){
            return "payment done";
        }else{
            return "not applicable";
        }
    }
    
    function refundOnlyBuyers($nftid,$selectedBidder)
    {
        $return = "";
        $nft = Nfts::where('nftid',"=", $nftid)->first();
        $iftrue = 0;
        $rejectedoffers = DB::table('offers')->where('nftid', $nftid)->where("status", "=", "1")->get();
        foreach($rejectedoffers as $offer)
        {
            if($offer->user_id != $selectedBidder)
            {
                $respo = Offers::where("id", $offer->id)->where('nftid', $nftid)->update(array('status' => 4));
                /**
                * return paid amount to lowest amount bidders **/
                $bidderWallet = Wallets::where('user_id', $offer->user_id)->sum('wallet_amount');

                $bidder = User::where('creator_id',$offer->user_id)->first();
                $paid_amount = DB::table('nftescrows')->where('creator_id', $offer->user_id)->where('nftid', $nftid)->sum('amount_paid');
                /**
                * return money to buyer wallet if offer not accepted **/
                $returnMoney = $paid_amount; // full paid return money to user wallet

                /**
                * return money to buyers's' wallet  **/
                $payInfo = array();
                $payInfo['payment_id'] = NULL;
                $payInfo['user_id'] = $bidder->creator_id;
                $payInfo['wallet_amount'] = $bidderWallet + $returnMoney;
                $payInfo['status'] = 'active';
                $payInfo['paymentThrough'] = "offer";
                $payInfo['paymentFrom'] = "NFT-X";
                $rsult = DB::table('wallets')->where('user_id', $bidder->creator_id)->update($payInfo);

                $otherpayInfo = array();
                $otherpayInfo['amount_paid'] = 0;
                $otherpayInfo['amount_pending'] = 0;
                $rsult = DB::table('nftescrows')->where('creator_id', $bidder->creator_id)->update($otherpayInfo);

                $statement = array(
                    'user' => $bidder->creator_id,
                    'amount' => $returnMoney,
                    'mode' => "refund",
                    'tax' => "0"
                );

                DB::table('statements')->insert($statement);
                /**
                * notification for refund money **/
                $moneyreturned = array();
                $moneyreturned['nftid'] = $nftid;
                $moneyreturned['user_id'] = $bidder->creator_id;
                $moneyreturned['nofication_from'] = "offer";
                $moneyreturned['action'] = "You got refund because your offer rejected.";
                $moneyreturned['link'] = NULL;
                DB::table('notifications')->insert($moneyreturned);

                $email = $bidder->email;
                $name = $bidder->name;
                $arr = array(
                    "mail_id"=> 7,
                    "subject"=> "Sadly, Your offer rejected for the NFT (".$nft->title.")",
                    "body" => "Hi ". ucfirst($bidder->name) .". Your offer has been rejected by the owner. Keep bidding on. Available much more nfts for you. Regards, NFT-X team.",
                    "to"=>array(
                            array(
                                "email"=> $email,
                                "name" => $name
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

                DB::table('nftescrows')->where('amount_paid', "=", 0)->where('amount_pending', "=", 0)->where('nftid', "=", $nftid)->where('creator_id', $bidder->creator_id)->delete();
                $return = "true";
            }else{
                $return = "false";
            }
        }
        
        return $return;
    }
    
    function returnMoneyotherbidderifOfferAccepted($nftid,$selectedBidder=null)
    {
        $nft = Nfts::where('nftid',"=", $nftid)->first();
        $iftrue = 0;
        $rejectedoffers = DB::table('offers')->where('nftid', $nftid)->where("status", "=", "1")->get();
        foreach($rejectedoffers as $offer)
        {
            $selectedBidder = ($selectedBidder != null && $selectedBidder == $offer->user_id) ? $selectedBidder : "dorefund";
            if($selectedBidder == "dorefund")
            {
                if($offer->status != 2)
                {
                    $result = Offers::where("id", $offer->id)->where('nftid', $nftid)->update(array('status' => 4));
                    /**
                    * return paid amount to lowest amount bidders **/
                    $bidderWallet = Wallets::where('user_id', $offer->user_id)->sum('wallet_amount');

                    $bidder = User::where('creator_id',$offer->user_id)->first();
                    $paid_amount = DB::table('nftescrows')->where('creator_id', $offer->user_id)->where('nftid', $nftid)->sum('amount_paid');
                    /**
                    * return money to buyer wallet if offer not accepted **/
                    $returnMoney = $paid_amount; // full paid return money to user wallet

                    /**
                    * return money to buyers's' wallet  **/
                    $payInfo = array();
                    $payInfo['payment_id'] = NULL;
                    $payInfo['user_id'] = $bidder->creator_id;
                    $payInfo['wallet_amount'] = $bidderWallet + $returnMoney;
                    $payInfo['status'] = 'active';
                    $payInfo['paymentThrough'] = "offer";
                    $payInfo['paymentFrom'] = "NFT-X";
                    $rsult = DB::table('wallets')->where('user_id', $bidder->creator_id)->update($payInfo);

                    $otherpayInfo = array();
                    $otherpayInfo['amount_paid'] = 0;
                    $otherpayInfo['amount_pending'] = 0;
                    $rsult = DB::table('nftescrows')->where('creator_id', $bidder->creator_id)->update($otherpayInfo);

                    $statement = array(
                        'user' => $bidder->creator_id,
                        'amount' => $returnMoney,
                        'mode' => "refund",
                        'tax' => "0"
                    );

                    DB::table('statements')->insert($statement);
                    /**
                    * notification for refund money **/
                    $moneyreturned = array();
                    $moneyreturned['nftid'] = $nftid;
                    $moneyreturned['user_id'] = $bidder->creator_id;
                    $moneyreturned['nofication_from'] = "offer";
                    $moneyreturned['action'] = "You got refund because your offer rejected.";
                    $moneyreturned['link'] = NULL;
                    DB::table('notifications')->insert($moneyreturned);

                    $email = $bidder->email;
                    $name = $bidder->name;
                    $arr = array(
                        "mail_id"=> 7,
                        "subject"=> "Sadly, Your offer rejected for the NFT (".$nft->title.")",
                        "body" => "Hi ". ucfirst($bidder->name) .". Your offer has been rejected by the owner. Keep bidding on. Available much more nfts for you. Regards, NFT-X team.",
                        "to"=>array(
                                array(
                                    "email"=> $email,
                                    "name" => $name
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

                    DB::table('nftescrows')->where('amount_paid', "=", 0)->where('amount_pending', "=", 0)->where('nftid', "=", $nftid)->where('creator_id', $bidder->creator_id)->delete();
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        
        return true;
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
                        ->update(array('status' => 4));
                    
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
    
    public function addNftCharges($nftid, $amount, $paymentFrom, $paymentType)
    {
        $nftPayments = array();
        $nftPayments['nftid'] = $nftid;
        $nftPayments['amount'] = $amount;
        $nftPayments['amount_form'] = $paymentFrom;
        $nftPayments['payment_type'] = $paymentType;
        $rsult = DB::table('nft_earnings')->insert($nftPayments);
        
        if($rsult)
        {
            return "true";
        }else{
            return "false";
        }
    }
    
    function getPurchase($bidder_id, $owner_id, $nftid, $purchased_amount, $winnerWallet, $bidderPreviousPaidAmount,$auction_id)
    {
        /**
        * check if bidder escrow payment status paid **/
        $isAlreadyPaid = DB::table('nftescrows')
            ->where('auction_id', $auction_id)
            ->where('nftid', $nftid)
            ->where('creator_id', $bidder_id)
            ->first();
        if($isAlreadyPaid->payment_status != "paid")
        {
            $commission = "";
            $gst = "";
            $adminSettings = DB::table('settings')->get();
            foreach($adminSettings as $settings)
            {
                if($settings->display_name == "Commission")
                {
                    $commission = $settings->value;
                }
                if($settings->display_name == "GST")
                {
                    $gst = $settings->value;
                }
            }
            
            /**
            update buyer wallet **/
            $bidderRestAmountInWallet = $winnerWallet - $purchased_amount;
            $checkresponse = Wallets::where("user_id", $bidder_id)->update(array('wallet_amount' => $bidderRestAmountInWallet));
            
            $this->addStatement($bidder_id, $purchased_amount, "debit", 0);

            $baseCommission = ($purchased_amount+$bidderPreviousPaidAmount) * $commission / 100;
            $commission = $baseCommission * $gst / 100;
            $serviceCharges = $baseCommission + $commission;
            $total_payable_amount = ($purchased_amount + $bidderPreviousPaidAmount) - $serviceCharges;
            /**
            * check if owner have money in his wallet **/
            $ownerWallet = Wallets::where('user_id', $owner_id)->sum('wallet_amount');
            
            if($ownerWallet == 0)
            {
                /**
                * add money to sellar's' wallet 
                * update if already have money in wallet **/
                $payInfo = array();
                $payInfo['payment_id'] = NULL;
                $payInfo['user_id'] = $owner_id;
                $payInfo['wallet_amount'] = $total_payable_amount;
                $payInfo['status'] = 'active';
                $payInfo['paymentThrough'] = "auction";
                $payInfo['paymentFrom'] = "NFT-X";
                $rsult = DB::table('wallets')->insert($payInfo);
            }else{
                /**
                * add money to sellar's' wallet 
                * update if already have money in wallet **/
                $payInfo = array();
                $payInfo['payment_id'] = NULL;
                $payInfo['user_id'] = $owner_id;
                $payInfo['wallet_amount'] = $ownerWallet + $total_payable_amount;
                $payInfo['status'] = 'active';
                $payInfo['paymentThrough'] = "auction";
                $payInfo['paymentFrom'] = "NFT-X";
                $rsult = DB::table('wallets')->where('user_id', $owner_id)->update($payInfo);
            }
            $result = $this->addStatement($owner_id, $total_payable_amount, "debit", 0);

            if($result == "true")
            {
                
                $this->addStatement($owner_id, $serviceCharges, "service charges", 0);
                
                $this->addNftCharges($nftid, $serviceCharges, $owner_id, "service charges from seller after sold nft");
                
                DB::table('nftescrows')
                ->where('nftid', $nftid)
                ->where('creator_id', $bidder_id)
                ->update(array("amount_pending" => 0, "amount_paid" => $total_payable_amount, "payment_status" => "paid"));

                if($rsult)
                {
                    return "true";
                }else{
                    return "false";
                }
            }else{
                return "false";
            }
        }else{
            return "amounpaid";
        }
    }
    
    public function bidderIsOwner($nftid, $bidder_id)
    {
        return Nfts::where("nftid", $nftid)->update(array('auction_status' => "sold", 
                                                       'owner_id' => $bidder_id));
    }
    
    public function deletepreviousbids($nftid, $bidder_id)
    {
        $result = Auctions::where('nftid', "=", $nftid)
            ->where('user_id', $bidder_id)
            ->delete();
        
        if($result)
        {
            $this->deleteNftFromEscrow($nftid, $bidder_id);
            return true;
        }else{
            return false;
        }
    }
    
    public function updateOfferStatus($rowId, $status)
    {
        $data = array(
            'status' => $status
        );
        $result = Offers::where("id", $rowId)->update($data);
        if($result)
        {
            return "true";
        }else{
            return "false";
        }

    }
    
    public function addPurchaseNft($nftid, $bidder_id, $owner_id, $type)
    {
        /**
        * purcahse table entry **/
        $purchaseInfo = array();
        $purchaseInfo['nftid'] = $nftid;
        $purchaseInfo['owner_id'] = $bidder_id;
        $purchaseInfo['creator_id'] = $owner_id;
        $purchaseInfo['type'] = $type;
        $rsult = DB::table('purchases')->insert($purchaseInfo);
        if($rsult)
        {
            return "true";
        }else{
            return "false";
        }
    }
    
    public function addSoldNft($nftid, $owner_id, $action)
    {
        $soldnft = array();
        $soldnft['nftid'] = $nftid;
        $soldnft['owner_id'] = $owner_id;
        $soldnft['status'] = $action;
        $rsult = DB::table('soldnfts')->insert($soldnft);
        if($rsult)
        {
            return "true";
        }else{
            return "false";
        }
    }
    
    /**
    * udpate user wallet **/
    public function walletUpdate($user_id, $amount, $type, $from)
    {
        /**
        * update user wallet **/
        $updatedAmount = $amount;
        $payInfo = array();
        $payInfo['wallet_amount'] = $updatedAmount;
        $payInfo['paymentThrough'] = $type;
        $payInfo['paymentFrom'] = $from;
        DB::table('wallets')->where('user_id', $user_id)->update($payInfo);
        
        return "true";
    }
    
    public function getUserWallet($userId)
    {
        return Wallets::where('user_id', $userId)->sum('wallet_amount');
    }
    
    public function getNftDetails($nftid)
    {
        return Nfts::where('nftid', $nftid)->first();
    }
    
    public function getOffer($nftid, $offerId)
    {
        return DB::table('offers')->where('nftid', $nftid)->where("id", $offerId)->first();
    }
    
    public function getHeighestBid($nftid)
    {
        return DB::table('auctions')->where('nftid', $nftid)->max('bid_amount');  
    }
    
    public function deleteNftFromEscrow($nftid, $bidderId)
    {
        $result = DB::table('nftescrows')->where('nftid', "=", $nftid)->where('creator_id', $bidderId)->delete();
        
        if($result)
        {
            return "true";
        }else{
            return "false";
        }
    }
    
    public function validateNft($coditions = array())
    {
        $error = "";
        $currentTime = isset($coditions['currenttime']) ? $coditions['currenttime'] : "";
        $auctionendtime = isset($coditions['auctionendtime']) ? $coditions['auctionendtime'] : "";
        $heighestBidPrice = isset($coditions['heighestBidPrice']) ? $coditions['heighestBidPrice'] : "";
        if($currentTime > $auctionendtime)
        {
            $error = "Time has been expired!";
        }

        if($coditions['auctionStatus'] == "sold")
        {
            $error = "Oops, already sold out!.";
        }

        if($coditions['loggedinuser'] == $coditions['nftOwner'])
        {
            $error = "You can not bid or send offer on your own Nft.";
        }
        
        if($coditions['amount'] < $coditions['nftPrice'])
        {
            $error = "Amount should be greater then " . $coditions['nftPrice'];
        }

        if($coditions['amount'] == $heighestBidPrice)
        {
            $error = "Amount should be greater then " . $heighestBidPrice;
        }

        if($coditions['amount'] < $heighestBidPrice)
        {
            $error = "Current bid or offer is for " . $heighestBidPrice . ". Place your bid with heigher then the current amount.";
        }
        
        if($coditions['tokenMoney'] > $coditions['bidderWallet'])
        {
            $error = "You don't have enough balance in your wallet or 0 balance. Please add more money in your wallet to bid or send offers!";
            
        }
        
        return $error;
    }
    
    public function placeBid(Request $request)
    {
        $walletRestAmount = "";
        $nftid = $request->input('nftid');
        $amount = $request->input('amount');
        if(Auth::check())
        {
            $user = Auth::user();
            $nfts = $this->getNftDetails($nftid);
            $now = strtotime('now');
            $auctionendtime = strtotime($nfts->auction_end_time);
            $nftrealprice = $nfts->price;
            $owner_id = $nfts->owner_id;
            $bidder_id = $user->creator_id;
            $highestBid = $this->getHeighestBid($nftid);
            $tokenMoney = (10 / 100) * $amount; // 10% of nft amount that shuld be diduct on the time of place bid

            /** 
            * check wallet have money or not **/
            $buyerWalletAmount = $this->getUserWallet($bidder_id);
            
            /**
            * validation conditions **/
            $arguments = array(
                'nftid' => $nftid,
                'loggedinuser' => $user->creator_id,
                'nftOwner' => $nfts->owner_id,
                'currenttime' => $now,
                'auctionendtime' => $auctionendtime,
                'amount' => $amount,
                'auctionStatus' => $nfts->auction_status,
                'nftPrice' => $nfts->price,
                'heighestBidPrice' => $highestBid,
                'bidderWallet' => $buyerWalletAmount,
                'tokenMoney' => $tokenMoney
            );
            $errors = $this->validateNft($arguments);
            if($errors != "")
            {
                echo $errors;
                die();
            }
            
            /**
            * delete previous bids **/
            //$this->deletepreviousbids($nftid, $bidder_id);
            
            /**
            * calculate bid amount accordingly if already paid for same auction  
            * check if bidder have paid amount in auction table for same **/
            $userPaidAmount = $this->getPreviusPaidAmount($bidder_id, $nftid);
            
            if($userPaidAmount != "" || $userPaidAmount != 0)
            {
                $tokenMoney = $tokenMoney - $userPaidAmount;
            }

            if($tokenMoney < $buyerWalletAmount)
            {
                /**
                diduct 10% money form user wallet **/
                $walletRestAmount = $buyerWalletAmount - $tokenMoney;
                
                /**
                update buyer wallet **/
                $result = $this->walletUpdate($bidder_id, $walletRestAmount, "auction", "NFT-X");
                if($result == "true")
                {
                    $this->addStatement($bidder_id, $tokenMoney, "EMD charges", 0);

                    /** add bid to auction  **/
                    $response = $this->inAuction($nftid, $bidder_id, $owner_id, $amount);
                    if($response['status'] == "true")
                    {
                        /**
                        add amount in nft escrow wallet **/
                        $rsult = $this->inEscrow($response['auction_id']->id, $nftid, $bidder_id, $owner_id, $amount, $tokenMoney, "auction");
                        if($rsult == "true")
                        {
                            /**
                            * notification for got bid on his nft **/
                            $message = "Wow, you got a bid on your nft. check now!";
                            $link = "nftdetail/".$nftid;
                            $this->sendNotification($owner_id, $nftid, "auction", $message, $link);
                            
                            /* 
                            * send emails regarding bidding **/
                            $this->sendEmail($owner_id, $nftid, "newbid");
                            
                            /**
                            * refund paid amount ti lower biddrs **/
                            $this->refundbackifhighbid($nftid);
                            echo 'Bid placed succesfully.';
                            die();
                        }
                    }else{
                        echo 'Bid Not Placed. Something went wrong! Please contact with administrator.';
                        die();
                    }
                }
            }else{
                echo "You don't have enough balance in your wallet or 0 balance. Please add more money in your wallet to make this bid complete!";
                die();
            }
        }else{
            echo '99';
            die();
        }
    }
    
    public function placeOffer(Request $request)
    {
        $walletRestAmount = "";
        $nftid = $request->input('nftid');
        $amount = $request->input('amount');
        if(Auth::check())
        {
            $user = Auth::user();
            $nfts = $this->getNftDetails($nftid); // get nft details
            $nftrealprice = $nfts->price;
            $owner_id = $nfts->owner_id;
            $bidder_id = $user->creator_id;
            $tokenMoney = (10 / 100) * $amount; // 10% of nft amount that shuld be diduct on the time of place bid
            
            /** 
            check if bidder have paid amount in auction table for same offer **/
            $userPaidAmount = $this->getPreviusPaidAmount($bidder_id, $nftid);
            
            /** 
            * check wallet have money or not **/
            $buyerWalletAmount = $this->getUserWallet($bidder_id); 
            
            /**
            * validation conditions **/
            $arguments = array(
                'nftid' => $nftid,
                'loggedinuser' => $user->creator_id,
                'nftOwner' => $nfts->owner_id,
                'amount' => $amount,
                'auctionStatus' => $nfts->auction_status,
                'nftPrice' => $nfts->price,
                'bidderWallet' => $buyerWalletAmount,
                'tokenMoney' => $tokenMoney
            );
            $errors = $this->validateNft($arguments);
            if($errors != "")
            {
                echo $errors;
                die();
            }
            $tokenMoney = $tokenMoney - $userPaidAmount; //calculate token money if already have in escarow
            if($tokenMoney <= $buyerWalletAmount)
            {
                /**
                diduct money form user wallet **/
                $walletRestAmount = $buyerWalletAmount - $tokenMoney;
                $this->addStatement($bidder_id, $tokenMoney, "EMD charges", 0);
                
                /**
                update buyer wallet **/
                $this->walletUpdate($bidder_id, $walletRestAmount, "offer", "NFT-X");
                $response = $this->inOffer($nftid, $bidder_id, $owner_id, $amount);
                if($response["status"] == "true")
                {
                    /**
                    add amount in nft escrow wallet **/
                    $rsult = $this->inEscrow($response["offer_id"]->id, $nftid, $bidder_id, $owner_id, $amount, $tokenMoney, "offer");
                    if($rsult == "true")
                    {
                        /**
                        * notification for refund 10% amount if heighest bidder available **/
                        $message = "Wow, you got an offer on your NFT. check now!";
                        $link = "nftdemanddetail/".$nftid;
                        $this->sendNotification($owner_id, $nftid, "offer", $message, $link);

                        /* 
                        * send emails regarding bidding **/
                        $this->sendEmail($owner_id, $nftid, "newoffer");
                        echo 'Offer sent succesfully.';
                        die();
                    }
                }
            }else{
                echo "You don't have enough balance in your wallet or less balance. Please add money in your wallet to send offers!";
                die();
            }
        }else{
             echo '99';
             die();
        }
    }
    
    public function acceptedRejected(Request $request)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $nftid = $request->input('nftid');
            $offer_id = $request->input('offerid');
            $status = $request->input('status');
            $amount = $request->input('amount');
            if($status == "accept")
            {
                $winner = DB::table('offers')->where('id', $offer_id)->first();
                if(!empty($winner))
                {
                    $owner_id = $winner->owner_id;
                    $bidder_id = $winner->user_id;
                    $amount = $winner->offer_amount;
                    
                    $bidderWallet = Wallets::where('user_id', $bidder_id)->sum('wallet_amount');

                    /**
                    if bidder has bid amount in his wallet afetr auction end **/
                    if( $bidderWallet >= $amount )
                    {
                        /**
                        * get total paid amount any bidder made bid twise or more on same nft **/
                        $bidderPreviousPaidAmount = $this->getPreviusPaidAmount($bidder_id, $nftid); 
                        $offer_amount = $amount;
                        $paid_amount = $bidderPreviousPaidAmount;
                        $total_pending_amount = (integer)$offer_amount - (integer)$paid_amount;
                        
                        /**
                        * getPurchase method used to calculations and diductions **/
                        $response = $this->getPurchase($bidder_id, $owner_id, $nftid, $total_pending_amount, $bidderWallet, $bidderPreviousPaidAmount,$offer_id);
                        if($response == "true")
                        {
                            /** 
                            * status 2 == purchased **/
                            $status = $this->updateOfferStatus($offer_id, "2");
                            if($status == "true")
                            {
                                /**
                                * updated purchase list of bidder **/
                                $result = $this->addPurchaseNft($nftid, $bidder_id, $owner_id, "demand");
                                if($result == "true")
                                {
                                    /**
                                    * update sold list of the owner of NFT **/
                                    $this->addSoldNft($nftid, $owner_id, "sold");
                                    
                                    /**
                                    * update bidder id as owner id in nft table **/
                                    $this->bidderIsOwner($nftid, $bidder_id);

                                    /**
                                    * refund amount back to other buyers wallet **/
                                    $this->returnMoneyotherbidderifOfferAccepted($nftid,null);
                                    
                                    /**
                                    * notification for offer accepted from bidder **/
                                    $message = "Congratulations, your offer accepted.";
                                    $link = "purchases/";
                                    $this->sendNotification($bidder_id, $nftid, "offer", $message, $link);

                                    /* 
                                    * send emails regarding bidding **/
                                    $this->sendEmail($bidder_id, $nftid, "offeraccepted");
                                    
                                    /**
                                    delete in resale case **/
                                    DB::table('purchases')->where('nftid', $nftid)->where('owner_id', $owner_id)->delete();
                                    
                                    echo "accepted";
                                }else{
                                    echo "Error in walltet oprations";
                                    die();
                                }
                            }else{
                                echo "Nft sold status not updated";
                                die();
                            }
                        }else if($response == "amounpaid"){
                            echo "accepted";
                            die();
                        }else{
                            echo "Error in purchase";
                            die();
                        }
                    }else{
                        /** 
                        * status 3 == offer accepted but owner waiting for payment **/
                        $status = $this->updateOfferStatus($offer_id, "3");
                        $now = Carbon::now();
                        //$waitingtime = Carbon::now()->addHours(5);
                        $waitingtime = Carbon::now()->addMinutes(15);
                        $status = "waiting";

                        /**
                        * get total paid amount of biddder if he made bid twise or more on same nft **/
                        $bidderPreviousPaidAmount = $this->getPreviusPaidAmount($bidder_id, $nftid);

                        $offer_amount = $amount;
                        $paid_amount = $bidderPreviousPaidAmount;
                        $total_pending_amount = $offer_amount - $bidderPreviousPaidAmount;
                        
                        /**
                        * give 5 hours time to winner **/
                        $response = $this->inWaiting($nftid, $bidder_id, $now, $waitingtime, $total_pending_amount, $status, $offer_id);
                        if($response == "true")
                        {
                            /**
                            * refund amount back to buyer's wallet **/
                            $refundResult = $this->refundOnlyBuyers($nftid,$winner->user_id);
                            
                            if($refundResult == "true")
                            {
                                /**
                                * notification for offer accepted from bidder **/
                                $message = "You have only 5 hours form now.Please do payment before 5 hours.";
                                $link = "null";
                                $this->sendNotification($bidder_id, $nftid, "offer", $message, $link);

                                /* 
                                * send emails regarding bidding **/
                                $this->sendEmail($bidder_id, $nftid, "offeraccepted",1);
                                echo "nofunds";
                                die();
                            }
                        }else if($response == "in waiting")
                        {
                            echo "waiting";
                            die();
                        }
                    }
                }else{
                    echo "no offers available";
                    die();
                }
            }else{
                $nft = Nfts::where('nftid', $nftid)->first();
                $offer = DB::table('offers')->where('nftid', $nftid)->where("id", $offer_id)->first();
                $owner_id = $user->creator_id;
                $bidder_id = $offer->user_id;
                $bidder = User::where('creator_id',$bidder_id)->first();
                
                $paid_amount = DB::table('nftescrows')->where('creator_id', $bidder_id)->where('nftid', $nftid)->sum('amount_paid');
                /**
                * return money to buyer waalet if offer not accepted **/
                $returnMoney = $paid_amount; // full paid return money to user wallet

                /**
                * return money to buyers's' wallet **/
                
                $userWallet = Wallets::where('user_id', $bidder->creator_id)->sum('wallet_amount');
                
                $payInfo = array();
                $payInfo['payment_id'] = NULL;
                $payInfo['user_id'] = $bidder->creator_id;
                $payInfo['wallet_amount'] = $userWallet + $returnMoney;
                $payInfo['status'] = 'active';
                $payInfo['paymentThrough'] = "offer";
                $payInfo['paymentFrom'] = "NFT-X";
                $rsult = DB::table('wallets')->where('user_id', $bidder->creator_id)->update($payInfo);
                
                $payInfo = array();
                $payInfo['amount_paid'] = 0;
                $payInfo['amount_pending'] = 0;
                $rsult = DB::table('nftescrows')->where('creator_id', $bidder->creator_id)->update($payInfo);

                if($rsult)
                {
                    $statement = array(
                        'user' => $bidder->creator_id,
                        'amount' => $returnMoney,
                        'mode' => "refund",
                        'tax' => "0"
                    );

                    DB::table('statements')->insert($statement);
                }

                /**
                * notification for refund money **/
                $moneyreturned = array();
                $moneyreturned['nftid'] = $nftid;
                $moneyreturned['user_id'] = $bidder_id;
                $moneyreturned['nofication_from'] = "offer";
                $moneyreturned['action'] = "Your offer rejected. your money has been refunded.";
                $moneyreturned['link'] = NULL;
                DB::table('notifications')->insert($moneyreturned);
                
                /**
                change offer status rejected **/
                Offers::where("nftid", $nftid)->where('id', $offer_id)->update(array('status' => "4"));
                
                DB::table('offers')->where('status', "=", 4)->where('nftid', "=", $nftid)->where('user_id', $bidder_id)->delete();
                
                DB::table('nftescrows')->where('amount_paid', "=", 0)->where('amount_pending', "=", 0)->where('nftid', "=", $nftid)->where('creator_id', $bidder_id)->delete();

                $email = $bidder->email;
                $name = $bidder->name;
                $arr = array(
                    "mail_id"=> 7,
                    "subject"=> "Your offer rejected for the NFT (".$nft->title.")",
                    "body" => "Hi ". ucfirst($bidder->name) .". Your offer has been rejected by the owner. Keep bidding on. available much more nfts for you. Regards NFT-X team.",
                    "to"=>array(
                            array(
                                "email"=> $email,
                                "name" => $name
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

                echo "rejected";
            }
        }else{
             echo 'guest';
             die();
        }
    }
    
    public function makePendingPayment(Request $request)
    {
        $payment_id = $request->input('paymentId');
        $bidder_id = $request->input('bidder_id');
        $nftid = $request->input('nftid');
        $amount = $request->input('amount');
        $getOwner = Nfts::where('nftid', "=", $nftid)->first();  
        $owner_id = $getOwner->owner_id;
        $exist = DB::table('final_auction')->where('id', $payment_id)->get();
        if(!empty($exist))
        {     
            $bidderWallet = Wallets::where('user_id', $bidder_id)->sum('wallet_amount');
            /**
            if bidder has bid amount in his wallet afetr auction end **/
            if( $bidderWallet >= $amount )
            {
                $payableAmount = (integer)$offer_amount - (integer)$amount;
                $response2 = $this->getPurchase($bidder_id, $owner_id, $nftid, $payableAmount, $bidderWallet, 0);
                if($response2)
                {
                    Offers::where("nftid", $nftid)->where('user_id', $bidder_id)->update(array('status' => "2"));
                    /**
                    * purcahse table entry **/
                    $purchaseInfo = array();
                    $purchaseInfo['nftid'] = $nftid;
                    $purchaseInfo['owner_id'] = $bidder_id;
                    $purchaseInfo['creator_id'] = $owner_id;
                    $purchaseInfo['type'] = "demand";
                    $rsult = DB::table('purchases')->insert($purchaseInfo);


                    $soldnft = array();
                    $soldnft['nftid'] = $nftid;
                    $soldnft['owner_id'] = $owner_id;
                    $soldnft['status'] = "sold";
                    $rsult = DB::table('soldnfts')->insert($soldnft);

                    if($rsult)
                    {
                        $bidder = User::where('creator_id',$bidder_id)->first();
                        $email = $getOwner->email;
                        $name = $getOwner->name;
                        $arr = array(
                            "mail_id"=> 7,
                            "subject"=> "Congratulations, Your offer accepted for the NFT (".$getOwner->title.")",
                            "body" => "Hi ". ucfirst($bidder->name) .". Thanks for the payment, now you are the owner of this NFT.",
                            "to"=>array(
                                    array(
                                        "email"=> $email,
                                        "name" => $name
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

                        /**
                        * notification for offer accepted **/
                        $offeraccepted = array();
                        $offeraccepted['nftid'] = $nftid;
                        $offeraccepted['user_id'] = $bidder_id;
                        $offeraccepted['owner_id'] = $owner_id;
                        $offeraccepted['nofication_from'] = "offer";
                        $offeraccepted['action'] = "offer accepted";
                        $offeraccepted['link'] = "nftdemanddetail/".$nftid;
                        DB::table('notifications')->insert($offeraccepted);
                    }
                }
                
                echo 1;
            }else{
            
                $whereArray = array('bidder_id' => $bidder_id,'nftid' => $nftid);

                $query = DB::table('final_auction');
                foreach($whereArray as $field => $value) 
                {
                    $query->where($field, $value);
                }
                $query->delete();

                $bidderPreviousPaidAmount = DB::table('nftescrows')->where('creator_id', $bidder_id)->where('nftid', $nftid)->where("payment_status","!=","paid")->sum('amount_paid');
                $cancelationCharges = (75/100) * $bidderPreviousPaidAmount;
                $ownerFees = $bidderPreviousPaidAmount - $cancelationCharges; // 25 percenbt return money to uyer wallet

                /**
                * add 75% cancelation charges to nft wallet **/
                $totalnftearnings = DB::table('nft_earnings')->sum('amount');
                $nftPayments = array();
                $nftPayments['nftid'] = $nftid;
                $nftPayments['amount'] = $cancelationCharges;
                $rsult = DB::table('nft_earnings')->insert($nftPayments);
                

                /**
                * add 25% money to sellers's' wallet **/
                $payInfo = array();
                $payInfo['payment_id'] = NULL;
                $payInfo['user_id'] = $getOwner->owner_id;
                $payInfo['wallet_amount'] = $ownerFees;
                $payInfo['status'] = 'active';
                $payInfo['paymentThrough'] = 'auction';
                $payInfo['paymentFrom'] = "NFT-X";
                $rsult = DB::table('wallets')->where('user_id', $getOwner->owner_id)->update($payInfo);

                $statement = array(
                    'user' => $owner_id,
                    'amount' => $ownerFees,
                    'mode' => "credit",
                    'tax' => "0"
                );

                $result = DB::table('statements')->insert($statement);
                
                /**
                * delete bidder form auction and move to next
                **/
                $whereArray = array('owner_id' => $owner_id,'nftid' => $nftid);

                $query = DB::table('offers');
                foreach($whereArray as $field => $value) {
                    $query->where($field, $value);
                }
                $query->delete();
                echo 0;
            }
        }
        
        die;
    }
    
    function checkIfAuctionExpired()
    {
        return true;
    }
    
    public function checkWinnerWallet()
    {
        $ajaxcallresponse = "";
        $rr = array();
        $commission = "";
        $gst = "";
        $adminSettings = DB::table('settings')->get();
        foreach($adminSettings as $settings)
        {
            if($settings->display_name == "Commission")
            {
                $commission = $settings->value;
            }
            if($settings->display_name == "GST")
            {
                $gst = $settings->value;
            }
        }
        $allusers = User::all();
        foreach($allusers as $users)
        {
            /**
            * get winner **/
            if($users->creator_id != "")
            {
                $winner = DB::table('final_auction')->where('bidder_id', $users->creator_id)->where('status','=', 'waiting')->get();
                if(!empty($winner))
                {
                    foreach($winner as $winr)
                    {
                        $auction_id = $winr->auction_id;
                        $nftid = $winr->nftid;
                        $rr['nftid'] = $winr->nftid;
                        $rr['waiting_time'] = $winr->waiting_time;
                        $rr['bidder_id'] = $winr->bidder_id;

                        $nftid = $rr['nftid'];
                        $nftDetails = Nfts::where('nftid', $nftid)->first();
                        if(!empty($nftDetails))
                        {
                            /**
                            * check if waiting time cross **/
                            if(strtotime('now') > strtotime($rr['waiting_time']) && $winr->status == "waiting")
                            {
                                if($nftDetails->type == "auction")
                                {
                                    /**
                                    * get winner wallet **/
                                    $winnerWallet = Wallets::where('user_id', $rr['bidder_id'])->sum('wallet_amount');
                                    $pendingAmount = $winr->amount_pending;

                                    if($winnerWallet >= $pendingAmount)
                                    {
                                        /**
                                        * get total pais amount of biddder if he made bid twise or more on same nft **/
                                        $bidderPreviousPaidAmount = $this->getPreviusPaidAmount($rr['bidder_id'], $nftid);

                                        $purchased_amount = $pendingAmount;
                                        $paid_amount = $bidderPreviousPaidAmount;
                                        $total_pending_amount = $purchased_amount - $bidderPreviousPaidAmount;

                                        /**
                                        * didcut money form wallet **/
                                        $response = $this->getPurchase($rr['bidder_id'], $nftDetails->owner_id, $winr->nftid, $total_pending_amount,$winnerWallet,  $bidderPreviousPaidAmount,$auction_id);

                                        if($response)
                                        {
                                            /**
                                            * stop script if winner found 
                                            * status 2 is purchased
                                            **/
                                            Auctions::where('nftid', $nftid)->where('user_id', $rr['bidder_id'])->update( array('status' => 2));

                                            /**
                                            * nft sold out **/
                                            DB::table('final_auction')->where('bidder_id', $rr['bidder_id'])->where('nftid', $nftid)->update(array('status' => 'paid'));
                                            
                                            /**
                                            * update bidder id as owner id in nft table **/
                                            Nfts::where("nftid", $nftid)
                                                ->update(array('auction_status' => "sold", 
                                                               'owner_id' => $rr['bidder_id']));

                                            /**
                                            * nft goes as sold item **/
                                            $sold = array();
                                            $sold['owner_id'] = $nftDetails->owner_id;
                                            $sold['nftid'] = $nftid;
                                            $sold['status'] = "sold";
                                            $rsult = DB::table('soldnfts')->insert($sold);
                                            if($rsult)
                                            {
                                                /**
                                                * purcahse table entry **/
                                                $purchaseInfo = array();
                                                $purchaseInfo['nftid'] = $nftid;
                                                $purchaseInfo['owner_id'] = $rr['bidder_id'];
                                                $purchaseInfo['creator_id'] = $nftDetails->owner_id;
                                                $purchaseInfo['type'] = "auction";
                                                $chckreps = DB::table('purchases')->insert($purchaseInfo);
                                                if($chckreps)
                                                {
                                                    $ajaxcallresponse = "nft purchased";
                                                }
                                            }
                                        }
                                    }else{
                                        /**
                                        * delete bidder form auction and move to next
                                        **/
                                        $whereArray = array('bidder_id' => $rr['bidder_id'],'nftid' => $nftDetails->nftid);

                                        $query = DB::table('final_auction');
                                        foreach($whereArray as $field => $value) {
                                            $query->where($field, $value);
                                        }
                                        $query->delete();

                                        $bidderPreviousPaidAmount = $this->getPreviusPaidAmount($rr['bidder_id'], $nftid);

                                        $cancelationCharges = (75/100) * $bidderPreviousPaidAmount;
                                        $ownerFees = $bidderPreviousPaidAmount - $cancelationCharges; // 25 percenbt return money to uyer wallet
                                        
                                        /**
                                        * add 75% cancelation charges to nft wallet **/
                                        $st = $this->addNftCharges($nftDetails->nftid, $cancelationCharges, $rr['bidder_id'], "cancelation charges form bidder on no payment");
                                        if($st == "true")
                                        {
                                            $sellerWallet = Wallets::where('user_id', $nftDetails->owner_id)->sum('wallet_amount');

                                            /**
                                            * add 25% money to sellers's' wallet **/
                                            $updatedAmount = $sellerWallet + $ownerFees;
                                            $result = $this->walletUpdate($nftDetails->owner_id, $updatedAmount, "auction", "NFT-X"); 
                                            if($result == "true")
                                            {
                                                $re = $this->addStatement($nftDetails->owner_id, $ownerFees, "credit", 0);
                                                Auctions::where('nftid', $nftid)->where('user_id', $rr['bidder_id'])->update( array('status' => "4", 'chance_to_win' => "0", 'bidder_no' => "1"));

                                                Nfts::where('nftid', $nftid)->update(array("status" => "draft", "type" => "draft"));
                                                
                                                DB::table('nftescrows')->where('auction_id', $auction_id)->update(array("payment_status" => "loss"));

                                                /**
                                                move to next bidder **/
                                                //$this->giveChanceToBidder($nftid);

                                                $ajaxcallresponse = "Payment failed";
                                            }
                                        }else{
                                            $ajaxcallresponse = "Error in earnigns";
                                        }
                                    }
                                }else{
                                    /**
                                    * demand and supply autoacndition step 1: get winner wallet **/
                                    $winnerWallet = Wallets::where('user_id', $rr['bidder_id'])->sum('wallet_amount');
                                    $pendingAmount = $winr->amount_pending;

                                    if($winnerWallet >= $pendingAmount)
                                    {
                                        /**
                                        * get total pais amount of biddder if he made bid twise or more on same nft **/
                                        $bidderPreviousPaidAmount = DB::table('nftescrows')->where('creator_id', $rr['bidder_id'])->where('nftid', $winr->nftid)->sum('amount_paid');

                                        $purchased_amount = $pendingAmount;

                                        $total_pending_amount = $purchased_amount;
                                        
                                        /**
                                        * didcut money form wallet **/
                                        $response = $this->getPurchase($rr['bidder_id'], $nftDetails->owner_id, $winr->nftid, $total_pending_amount,$winnerWallet,  $bidderPreviousPaidAmount,$auction_id);

                                        if($response)
                                        {
                                            /**
                                            * stop script if winner found 
                                            * status 2 is purchased
                                            **/
                                            Offers::where('nftid', $nftid)->where('user_id', $rr['bidder_id'])->update( array('status' => 2));

                                            /**
                                            * update bidder id as owner id in nft table **/
                                            Nfts::where("nftid", $nftid)
                                                ->update(array('auction_status' => "sold", 
                                                               'owner_id' => $rr['bidder_id']));

                                            /**
                                            * nft sold out **/
                                            DB::table('final_auction')->where('bidder_id', $rr['bidder_id'])->where('nftid', $nftid)->update(array('status' => 'paid'));
                                            /**
                                            * nft goes as sold item **/
                                            $sold = array();
                                            $sold['owner_id'] = $nftDetails->owner_id;
                                            $sold['nftid'] = $nftid;
                                            $sold['status'] = "sold";
                                            $rsult = DB::table('soldnfts')->insert($sold);
                                            if($rsult)
                                            {
                                                /**
                                                * purcahse table entry **/
                                                $purchaseInfo = array();
                                                $purchaseInfo['nftid'] = $nftid;
                                                $purchaseInfo['owner_id'] = $rr['bidder_id'];
                                                $purchaseInfo['creator_id'] = $nftDetails->owner_id;
                                                $purchaseInfo['type'] = "auction";
                                                $chckreps = DB::table('purchases')->insert($purchaseInfo);
                                                if($chckreps)
                                                {
                                                    $ajaxcallresponse = "nft purchased";
                                                }
                                            }
                                        }
                                    }else{
                                        
                                        /**
                                        * delete bidder form auction and move to next **/
                                        $whereArray = array('bidder_id' => $rr['bidder_id'],'nftid' => $nftid);

                                        $query = DB::table('final_auction');
                                        foreach($whereArray as $field => $value) {
                                            $query->where($field, $value);
                                        }
                                        $query->delete();
                                        
                                        $respo = Offers::where("owner_id", $nftDetails->owner_id)->where('nftid', $nftid)->update(array('status' => 4));
                                        
                                        Nfts::where('nftid', $nftid)->update(array("status" => "draft", "type" => "draft"));

                                        $bidderPreviousPaidAmount = $this->getPreviusPaidAmount($rr['bidder_id'], $nftid);

                                        $cancelationCharges = (75/100) * $bidderPreviousPaidAmount;
                                        $ownerFees = $bidderPreviousPaidAmount - $cancelationCharges;

                                        /**
                                        * add 75% cancelation charges to nft wallet **/
                                        $this->addNftCharges($nftDetails->nftid, $cancelationCharges, $rr['bidder_id'], "cancelation charges form bidder on no payment");
                                        

                                        $sellerWallet = Wallets::where('user_id', $nftDetails->owner_id)->sum('wallet_amount');
                                        
                                        /**
                                        * add 25% money to sellers's' wallet **/
                                        $payInfo = array();
                                        $payInfo['payment_id'] = NULL;
                                        $payInfo['user_id'] = $nftDetails->owner_id;
                                        $payInfo['wallet_amount'] = $sellerWallet + $ownerFees;
                                        $payInfo['status'] = 'active';
                                        $payInfo['paymentThrough'] = 'auction';
                                        $payInfo['paymentFrom'] = "NFT-X";
                                        $rsult = DB::table('wallets')->where('user_id', $nftDetails->owner_id)->update($payInfo);

                                        $statement = array(
                                            'user' => $nftDetails->owner_id,
                                            'amount' => $ownerFees,
                                            'mode' => "credit",
                                            'tax' => "0"
                                        );

                                        $result = DB::table('statements')->insert($statement);
                                        
                                        /**
                                        * delete bidder form auction and move to next **/
                                        $whereArray = array('owner_id' => $nftDetails->owner_id,'nftid' => $nftid);

                                        $query = DB::table('offers');
                                        foreach($whereArray as $field => $value) {
                                            $query->where($field, $value);
                                        }
                                        $query->delete();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        echo $ajaxcallresponse;
    }
    
    function getPreviusPaidAmount($bidder_id, $nftid)
    {
        $paidamount = 0;
        $bidderFinalAuction = DB::table('nftescrows')->where('nftid', $nftid)->where('creator_id', $bidder_id)->where('payment_status', "!=", "paid")->get();
        foreach($bidderFinalAuction as $auction)
        {
            $paidamount = $auction->amount_paid+$paidamount;
        }
        return $paidamount;
    }
    
    public function getallBids()
    {
        return view('vendor/voyager/bids/browse');
    }
    
    public function nfteEscrow()
    {
        $userData = array();
        $escrow = DB::table('nftescrows')->get();
        foreach($escrow as $list)
        {
            $bidder = DB::table("users")->where('creator_id', $list->creator_id)->first();
            $owner = DB::table("users")->where('creator_id', $list->owner_id)->first();
            $list->bidder = $bidder->creator_id . "_" . $bidder->name;
            $list->owner = $owner->creator_id . "_" . $owner->name;
            $userData[] = $list;
        }
        $escrow = $userData;
        return view('vendor/voyager/wallet/browse', compact('escrow'));
    }
    
    public function nftEarnings()
    {
        $earnigns = DB::table('nft_earnings')->sum('amount');
        return view('vendor/voyager/wallet/earnings', compact('earnigns'));
    }
    
    public function checkLogics()
    {
        $highestBid = Auctions::where("nftid", "32d6744de5")->max('bid_amount');
                    $heighestBidder = Auctions::where('nftid', "32d6744de5")->where('bid_amount', $highestBid)->first();
                    echo $bidder_id = $heighestBidder->user_id;
                    $waitingtime = date('Y-m-d H:i:s', strtotime($heighestBidder->created_at .'+2 days'));
                    //echo $bid_date = $waitingtime;
         $q = "select * from (select nftid,price from nfts order by price DESC limit 3) nfts order by price";
                                
         $result = DB::select($q);
        
        //echo date('Y-m-d H:i:s', strtotime("+2 day"));
         //debug($result,true);
        die;
    }
    
    public function checkLogs()
    {
        $join = "";
        if(Auth::check())
        {
            $user = Auth::user();
            $notifications = DB::table('notifications')->where('user_id', $user->creator_id)->orWhere('user_id', $user->creator_id)->orderBy('id','DESC')->get();
            $totalNotfications = count($notifications);
            if($totalNotfications > 0)
            {
                $join .='<div class="notification" style="padding:1rem;font-size:12.5px;">
                        <a href="javascript:void(0);" data-user="'.$user->creator_id.'" id="clearall" class="dropdown-item">
                            <span class="text-muted text-sm clearall"> Clear All</span>
                      </a>';
                foreach($notifications as $notification)
                {
                    $join .='<div class="notification" style="padding:1rem;font-size:12.5px;">
                        
                      <a href="'.URL::to('/'.$notification->link).'" class="dropdown-item notif" data-id="'.$notification->nftid.'">
                        <span class="text-muted text-sm"><b>From: '.ucfirst($notification->nofication_from).' -</b> '.ucfirst($notification->action).'</span>
                      </a>
                      <div class="dropdown-divider"></div>
                    </div>';
                }
            }else{
                $join .='<div class="notification" style="padding:1rem;font-size:12.5px;">
                      No Notificatoin Available.
                      <div class="dropdown-divider"></div>
                    </div>';
            }
            echo $join;
        }
    }
    
    function countnotifications()
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $notifications = DB::table('notifications')->where('status','=','0')->where('user_id', $user->creator_id)->count();
            
            echo $notifications;
            die;
        }
    }
    
    public function viewNotificationStatus(Request $request)
    {
        $notificationId = $request->input('nid');
        $result = DB::table('notifications')->where("nftid", $notificationId)->update(array('status' => "1"));
        if($result)
        {
            echo 1;
        }else{
            echo 0;
        }
        
        die;
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
    
    public function giveChanceToBidder($nftid)
    {
        $status = $this->checkSoldItems($nftid);
        if($status == "true")
        {
            $newBidder = Auctions::where('nftid', $nftid)->where('chance_to_win', 1)->orderByDesc("id")->first();
            if($newBidder->status == 0 || $newBidder->status == 4)
            {
                $bidder_no = $newBidder->bidder_no + 1;
                /**
                * put in waiting to second bidder after payment failed of first bidder **/
                Auctions::where('id', $newBidder->id)->update(array('bidder_no' => $bidder_no));

                if($newBidder->bidder_no > 3)
                {
                    Nfts::where('nftid', $nftid)->update(array("status" => "draft", "type" => "draft"));
                    return false;
                }else{
                    /**
                    * give five hours to second bidder **/
                    $exist = DB::table('final_auction')->where('bidder_id', $newBidder->user_id)->where('nftid', $nftid)->get();
                    if(empty($exist))
                    {
                        $now = Carbon::now();
                        //$waitingtime = Carbon::now()->addHours(5);
                        $waitingtime = Carbon::now()->addMinutes(15);
                        
                        /**
                        * give five hours time to winner **/
                        $response = $this->inWaiting($nftid, $newBidder->user_id, $now, $waitingtime, $newBidder->bid_amount, $status, $newBidder->id);
                        if($response =="true")
                        {
                            $nftData = Nfts::where('nftid', $nftid)->first();
                            $owner_id = $nftData->owner_id;

                            /**
                            * notification for got bid on his nft **/
                            $message = "Congratulations. You still have chance to win this auction for NFT (" .$nftData->title. "). Please keep update your wallet.";
                            $link = "NULL";
                            $this->sendNotification($newBidder->user_id, $nftid, "offer", $message, $link);

                            /* 
                            * send emails regarding bidding **/
                            $this->sendEmail($newBidder->user_id, $nftid, "secondthirdbidderchance");
                            return "true";
                        }
                    }
                }
            }
        }
    }
    
    function checkSoldItems($nftid)
    {
        $nft = DB::table("nftescrows")->where('nftid', $nftid)->where('payment_status', "paid")->get();
        if(!empty($nft))
        {
            foreach($nft as $soldItem)
            {
                $whereArray = array('bidder_id' => $soldItem->creator_id,'nftid' => $nftid);

                $query = DB::table('final_auction');
                foreach($whereArray as $field => $value) 
                {
                    $query->where($field, $value);
                }
                $query->delete();
                
                Auctions::where('nftid', $nftid)->update(array("status" => 2));
            }
            
            return "false";
        }else{
            return "true";
        }
    }
    
    public function removeOldOffers(Request $request)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $nftid = $request->input('nftid');
            $offer_id = $request->input('offerid');
            $nft = Nfts::where('nftid', $nftid)->first();
            $offer = DB::table('offers')->where('nftid', $nftid)->where("id", $offer_id)->first();
            $owner_id = $nft->creator_id;
            $bidder_id = $user->creator_id;
            $paid_amount = DB::table('nftescrows')->where('creator_id', $bidder_id)->where('nftid', $nftid)->sum('amount_paid');

            /**
            * return money to buyers's wallet **/
            $userWallet = Wallets::where('user_id', $bidder_id)->sum('wallet_amount');
            $updatedAmount = $userWallet + $paid_amount;
            $result = $this->walletUpdate($bidder_id, $updatedAmount, "offer", "NFT-X");
            if($result == "true")
            {
                /**
                * send statment to bidder about refund **/
                $this->addStatement($bidder_id, $paid_amount, "refund", 0);
                DB::delete('DELETE FROM offers WHERE nftid = ? AND user_id = ?', [$nftid, $bidder_id]);  
                DB::delete('DELETE FROM nftescrows WHERE nftid = ? AND creator_id = ?', [$nftid, $bidder_id]);

                /**
                * notification for got bid on his nft **/
                $message = "You repealed offer successfully. You will get your refund soon.";
                $link = "NULL";
                $this->sendNotification($bidder_id, $nftid, "offer", $message, $link);
                $message2 = "Offer Repealed";
                $this->sendNotification($owner_id, $nftid, "offer", $message2, $link);

                /* 
                * send emails regarding repealed offer **/
                $this->sendEmail($bidder_id, $nftid, "offerrepealed");
                $this->sendEmail($owner_id, $nftid, "notifytoownerrepealedoffer");
                echo "rejected";
            }
        }
    }
}
