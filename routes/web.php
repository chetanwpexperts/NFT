<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardUserController;
use Illuminate\Support\Facades\Auth;
use App\Models\Nfts;
use App\Models\Auctions;
use App\Models\User;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::fallback(function () {

    return view("errors/404");

});

Route::get('/', function () {
    $user = "";
    $allnfts = array();
    $nftarray = array();
    if(Auth::check())
    {
        $user = Auth::user();
    }
    // $recentNfts = Nfts::orderByDesc("id")->limit(12)->get();
    $recentNfts = Nfts::join('users', 'users.creator_id', '=', 'nfts.creator_id')
        ->where("nfts.type", "!=", "draft")
        ->where("nfts.status", '!=', "draft")
        ->orderByDesc("nfts.id")
        ->limit(20)->get();
    
    foreach($recentNfts as $recentNft)
    {
        $recentNft['creator_name'] = $recentNft->name;
        $recentNft['creator_badge'] = $recentNft->badges;
        $owner = User::where('creator_id', $recentNft->owner_id)->get();
        foreach($owner as $onwerinfo)
        {
            
            $recentNft['owner_name'] = $onwerinfo->name;
            $recentNft['owner_badges'] = $onwerinfo->badges;
        }
        $nftarray[] = $recentNft;
    }
    $recentNfts = $nftarray;

    $trending = array();
    $users = User::all();
    $likedNftsStatus = array();
    foreach($users as $allusers)
    {
        /**
        get nfts of users**/
        $nfts = Nfts::where('creator_id', $allusers->creator_id)->orderByDesc("nfts.id")->get();
        foreach( $nfts as $nft )
        {
            $nfts = DB::table('liked_nfts')->select('nftid','user_id')->where('nftid', $nft->nftid)->distinct()->get();

            foreach( $nfts as $nftt )
            {
                //DB::enableQueryLog();
                $islike = Nfts::where('nftid', $nftt->nftid)->get();
                //$query = DB::getQueryLog();
                //dd($query);
                $count = count($islike);

                if($count > 0)
                {
                    foreach($islike as $liked)
                    {
                        if(Auth::check() && $liked->nftid == $nftt->nftid)
                        {
                            $nftt->liked = "yes";
                        }else{
                            $nftt->liked = "no";
                        }
                        $likedNftsStatus[] = $nftt;
                    }
                }
            }

            $likedstatus = $likedNftsStatus;
            if( count($likedstatus) > 0)
            {
                foreach($likedstatus as $liked)
                {
                    if($liked->liked == "yes")
                    {
                        $nft['liked'] = $liked->liked;
                    }else{
                        $nft['liked'] = "no";
                    }
                }
            }
            $nft['creator_name'] = $allusers->name;
            $nft['creator_badge'] = $allusers->badges;
            $owner = User::where('creator_id', $nft->owner_id)->get();
            foreach($owner as $onwerinfo)
            {
                $nft['owner_name'] = $onwerinfo->name;
                $nft['owner_badges'] = $onwerinfo->badges;
            }
            $highestBid = Auctions::where("nftid", $nft->nftid)->max('bid_amount');
            $nft['heighest_bid'] = ($highestBid != "") ? $highestBid : 0;
            $waitingStatus = DB::table('final_auction')->where('nftid', $nft->nftid)->get();
            $checkiftobsold = count($waitingStatus);
            if($checkiftobsold > 0)
            {
                foreach($waitingStatus as $toBSold)
                {
                    if($toBSold->status == "waiting")
                    {
                        $nft['days_left'] = "2 Days Left";
                    }else{
                        $nft['days_left'] = "Live";
                    }
                }
            }
            if($highestBid != 0)
            {
            $trending[] = $nft;
            }
        }
    }
    
    return view('home', compact('user','recentNfts', 'trending'));
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('submit-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('useremailexists', [AuthController::class, 'checkIfEmailAlreadyRegistered'])->name('useremailexists');
Route::post('userphoneexists', [AuthController::class, 'checkIfPhoneAlreadyRegistered'])->name('userphoneexists');
Route::post('submit-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('forgotpassword', [AuthController::class, 'forgotpassword'])->name('forgotpassword');
Route::post('submit-forgotpassword', [AuthController::class, 'postforgotpassword'])->name('auth.forgotpassword');
Route::get('verifyotp', [AuthController::class, 'verifyOtp'])->name('auth.verifyotp');
Route::post('checkotp', [AuthController::class, 'checkOtp'])->name('auth.checkotp');
Route::get('setpassword', [AuthController::class, 'setPassword'])->name('auth.setpassword');
Route::post('updatepassword', [App\Http\Controllers\AuthController::class, 'submitSetPassword'])->name('auth.updatepassword');
Route::post('resendotp', [AuthController::class, 'resendOtp'])->name('auth.resendotp');
Route::get('otpresend', [AuthController::class, 'otpresend'])->name('auth.otpresend');
//Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::get('creator', [AuthController::class, 'creator'])->name('auth.creator');
Route::get('newuser', [AuthController::class, 'newUser'])->name('auth.newuser');
Route::post('updaterole', [AuthController::class, 'updateUserType'])->name('auth.updaterole');
Route::get('dashboard', [AuthController::class, 'vdashboard'])->name('auth.dashboard');
Route::post('storecreator', [AuthController::class, 'storeCreator'])->name('auth.storecreator');

Route::get('changepassword', [App\Http\Controllers\DashboardUserController::class, 'changePassword'])->name('dashboard.changepassword');
Route::post('changenewpassword', [App\Http\Controllers\DashboardUserController::class, 'updatePassword'])->name('dashboard.updatepassword');
Route::get('editprofile', [App\Http\Controllers\DashboardUserController::class, 'editProfile'])->name('dashboard.editprofile');
Route::post('updateprofile', [App\Http\Controllers\DashboardUserController::class, 'updateProfile'])->name('dashboard.updateprofile');
Route::get('editemailphone', [App\Http\Controllers\DashboardUserController::class, 'editEmailPhone'])->name('dashboard.editemailphone');
Route::post('checkuserotp', [App\Http\Controllers\DashboardUserController::class, 'checkUserOtp'])->name('dashboard.checkuserotp');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('nftlist', [App\Http\Controllers\NftsController::class, 'inauction'])->name('nft.auction');
Route::get('myfavourites', [App\Http\Controllers\NftsController::class, 'getFavouriteNfts'])->name('nft.favourites');
Route::get('indemand', [App\Http\Controllers\NftsController::class, 'indemand'])->name('nft.demand');
Route::get('draft', [App\Http\Controllers\NftsController::class, 'indraft'])->name('nft.draft');
Route::get('purchases', [App\Http\Controllers\NftsController::class, 'myPurchases'])->name('creator.purchases');
Route::get('soldbyme', [App\Http\Controllers\NftsController::class, 'soldByMe'])->name('creator.soldbyme');
Route::get('bids', [App\Http\Controllers\NftsController::class, 'bidMade'])->name('nft.bids');
Route::get('offers', [App\Http\Controllers\NftsController::class, 'offerMade'])->name('nft.offers');
Route::get('createnft', [App\Http\Controllers\NftsController::class, 'create'])->name('nft.create');
Route::post('storenft', [App\Http\Controllers\NftsController::class, 'store'])->name('nft.store');
Route::post('preview', [App\Http\Controllers\NftsController::class, 'preview'])->name('nft.preview');
Route::get('edit/{nftid}', [App\Http\Controllers\NftsController::class, 'edit'])->name('nft.edit');
Route::post('publish', [App\Http\Controllers\NftsController::class, 'publish'])->name('nft.publish');
Route::post('update', [App\Http\Controllers\NftsController::class, 'update'])->name('nft.update');
Route::get('view/{nftid}', [App\Http\Controllers\NftsController::class, 'show'])->name('nft.show');
Route::post('addfavourite', [App\Http\Controllers\NftsController::class, 'addFavourite'])->name('nft.addfavourite');
Route::get('viewnft/{nftid}', [App\Http\Controllers\NftsController::class, 'show'])->name('nft.view');
Route::get('nftdetail/{nftid}', [App\Http\Controllers\NftsController::class, 'details'])->name('nft.show');
Route::get('nftdemanddetail/{nftid}', [App\Http\Controllers\NftsController::class, 'detailsDemandSupply'])->name('nft.demanddetails');

Route::get('marketplace', [App\Http\Controllers\NftsController::class, 'marketPlace'])->name('nft.marketplace');
Route::post('addviews', [App\Http\Controllers\NftsController::class, 'countView'])->name('nft.addviews');

Route::get('money', [App\Http\Controllers\WalletsController::class, 'money'])->name('wallet.money');
Route::post('payment', [App\Http\Controllers\WalletsController::class,'create'])->name('wallet.addpayment');
Route::post('clearallnotification', [App\Http\Controllers\NftsController::class,'clearallnofifications'])->name('nft.clearnotifications');
Route::post('updatewallet', [App\Http\Controllers\WalletsController::class,'addMoneyToWallet'])->name('wallet.updatewallet');
Route::post('placebid', [App\Http\Controllers\AuctionController::class,'placeBid'])->name('auction.placebid');
Route::get('checklogs', [App\Http\Controllers\AuctionController::class,'checkLogs'])->name('auction.checklogs');
Route::get('countnotifications', [App\Http\Controllers\AuctionController::class,'countnotifications'])->name('auction.countnotifications');
Route::post('placeoffer', [App\Http\Controllers\AuctionController::class,'placeOffer'])->name('auction.placeoffer');
Route::post('acceptedrejected', [App\Http\Controllers\AuctionController::class,'acceptedRejected'])->name('offers.acceptedrejected');
Route::post('notificationststus', [App\Http\Controllers\AuctionController::class,'viewNotificationStatus'])->name('offers.notificationststus');
Route::get('checkpendings', [App\Http\Controllers\AuthController::class,'checkPendings'])->name('auth.pendingpayments');
Route::get('checkwinnerwallets', [App\Http\Controllers\AuctionController::class,'checkWinnerWallet'])->name('auction.checkwinnerwallets');
Route::get('doauctionpayment/{user_id}', [App\Http\Controllers\AuthController::class,'doAuctionPayment'])->name('auth.doauctionpayment');
Route::get('checkexpirednfts', [App\Http\Controllers\AuctionController::class,'checkIfAuctionExpired'])->name('auction.checkexpirednfts');
Route::get('alloffers/{nftid}', [App\Http\Controllers\NftsController::class, 'getOffers'])->name('nft.alloffers');
Route::get('actionpending', [App\Http\Controllers\NftsController::class, 'actionPending'])->name('nft.actionpending');
Route::post('makepayment', [App\Http\Controllers\AuctionController::class,'makePendingPayment'])->name('auction.makepayment');
Route::post('removefifteenminutesoldrecord', [App\Http\Controllers\AuctionController::class, 'removeOldOffers'])->name('nft.removefifteenminutesoldrecord');


Route::get('privacy-policy', [App\Http\Controllers\HomeController::class, 'ppolicy'])->name('nft.ppolicy');
Route::get('terms-conditions', [App\Http\Controllers\HomeController::class, 'terms'])->name('nft.terms');
Route::get('refund-cancelation-policy', [App\Http\Controllers\HomeController::class, 'refundCancelationPolicy'])->name('nft.refundcancelation');
Route::get('about', [App\Http\Controllers\HomeController::class, 'about'])->name('nft.about');
Route::get('contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('nft.contact');
Route::get('faq', [App\Http\Controllers\HomeController::class, 'faq'])->name('nft.faq');

Route::post('addcomment', [App\Http\Controllers\CommentsController::class,'store'])->name('comments.add');
Route::post('/loadmore/load_data', [App\Http\Controllers\CommentsController::class,'load_data'])->name('loadmore.load_data');
Route::get('viewall/{viewtype}', [App\Http\Controllers\NftsController::class,'viewAll'])->name('view.all');

Route::get('checklogics', [App\Http\Controllers\AuctionController::class, 'checkLogics'])->name('nft.testinglink');
Route::post('checksoldnft', [App\Http\Controllers\NftsController::class, 'checknftsold'])->name('nft.checksoldnft');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('search', [App\Http\Controllers\SearchController::class, 'index'])->name('nft.search');


Route::group(['prefix' => 'admin'], function () {
    Route::get('bids', [App\Http\Controllers\AuctionController::class, 'getallBids'])->name('bids.all');
    Voyager::routes();
    Route::get('escrow', [App\Http\Controllers\AuctionController::class, 'nfteEscrow'])->name('escrow.escrow');
    Route::get('earnings', [App\Http\Controllers\AuctionController::class, 'nftEarnings'])->name('wallet.earnings');
    Voyager::routes();
    //Route::get('users/{id}', [App\Http\Controllers\Admin\UsersController::class, 'viewUser'])->name('user.view');
    Route::post('verifyuser', [App\Http\Controllers\AuthController::class, 'verifyUser'])->name('auth.verify');
    Route::post('users/{id}', [App\Http\Controllers\AuthController::class, 'viewUser'])->name('user.view');
    //Route::post('users/delete/{id}', [App\Http\Controllers\AuthController::class, 'deleteUser'])->name('user.delete');
});
