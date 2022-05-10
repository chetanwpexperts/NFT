<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use App\Models\Wallets;
use Redirect;
use Carbon\Carbon;

class WalletsController extends Controller
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
        $user = Auth::user();
        $input = $request->all();

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $payment = $api->payment->fetch($request->razorpay_payment_id);
        $percentage = 10;
        $walletamount = $payment['amount'];
        $netamount = ($percentage / 100) * $walletamount;
        if(count($input)  && !empty($input['razorpay_payment_id'])) 
        {
            try {
                $payment->capture(array('amount'=>$payment['amount']));
            } catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }
        
        $payInfo = array();
        
        $payInfo['payment_id'] = $request->razorpay_payment_id;
        $payInfo['user_id'] = $user->creator_id;
        $payInfo['wallet_amount'] = $request->amount ;
        $payInfo['status'] = 'active';
        $rsult = DB::table('wallets')->insert($payInfo);
        //Wallets::insertGetId($payInfo);  
        if($rsult)
        {
            /* $bidInfo = array();
            $bidInfo['owner_id'] = $request->input('owner_id');
            $bidInfo['user_id'] = $request->input('user_id');
            $bidInfo['nftid'] = $request->input('nftid');
            $bidInfo['bid_amount'] = $request->amount;
            $bidInfo['type'] = $request->input('type');
			if($request->input('type') == "auction")
			{
				$bidInfo['status'] = "in auction";
			}else{
				$bidInfo['status'] = "not sold";
			}
            DB::table('auctions')->insert($bidInfo); */
            \Session::put('success', 'Amount Added Successfully.');
            return response()->json(['success' => 'Amount Added Successfully.']);
        }
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
    
    public function money()
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $walletamount = 0;
            /**
            check if wallet have money
            **/
            $myWallet = Wallets::where("user_id", $user->creator_id)->get();
            $myStatements = DB::table('statements')->where("user", $user->creator_id)->orderByDesc("id")->get();
            if($myWallet->isNotEmpty())
            {
                $walletamount = Wallets::where("user_id", $user->creator_id)->sum('wallet_amount');
            }
            return view('wallet.money', compact('user','walletamount','myStatements'));
        }
    }
    
    public function addMoneyToWallet(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $payment = $api->payment->fetch($request->razorpay_payment_id);
        if(count($input)  && !empty($input['razorpay_payment_id'])) 
        {
            try {
                $payment->capture(array('amount' => $payment['amount']));
            } catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }
        /**
        * if already have money into wallet **/
        $userWallet = Wallets::where('user_id', $user->creator_id)->sum('wallet_amount');
        $payInfo = array();
        if($userWallet != 0)
        {
            $payInfo['payment_id'] = $request->razorpay_payment_id;
            $payInfo['user_id'] = $user->creator_id;
            $payInfo['wallet_amount'] = $userWallet + $request->amount;
            $payInfo['status'] = 'active';
            $payInfo['paymentThrough'] = 'razorpay';
            $payInfo['paymentFrom'] = "self";
            $rsult = DB::table('wallets')->where('user_id', $user->creator_id)->update($payInfo);
            
            $statement = array(
                'user' => $user->creator_id,
                'amount' => $request->amount,
                'mode' => "credit",
                'tax' => "0"
            );
            
            DB::table('statements')->insert($statement);
        }else{
            $payInfo['payment_id'] = $request->razorpay_payment_id;
            $payInfo['user_id'] = $user->creator_id;
            $payInfo['wallet_amount'] = $request->amount ;
            $payInfo['status'] = 'active';
            $payInfo['paymentThrough'] = 'razorpay';
            $payInfo['paymentFrom'] = "self";
            $rsult = DB::table('wallets')->insert($payInfo);
            $statement = array(
                'user' => $user->creator_id,
                'amount' => $request->amount,
                'mode' => "credit",
                'tax' => "0"
            );
            
            DB::table('statements')->insert($statement);
        }
        if($rsult)
        {
            \Session::put('success', 'Amount Added Successfully.');
            return response()->json(['success' => 'Amount Added Successfully.']);
        }
    }
}
