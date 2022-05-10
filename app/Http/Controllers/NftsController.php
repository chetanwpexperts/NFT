<?php

namespace App\Http\Controllers;

use App\Models\Nfts;
use App\Models\User;
use App\Models\Auctions;
use App\Models\Offers;
use App\Models\Purchases;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\DB;
use Hash;
use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class NftsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $nfts = Nfts::where("creator_id", $user->creator_id)->where("type", "auction")->get();
            return view('nfts.index', compact('user', 'nfts'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    public function inauction()
    {
		$row = array();
        if(Auth::check())
        {
            $user = Auth::user();
            $nfts = Nfts::where("creator_id", $user->creator_id)->where("type", "auction")->orderByDesc("created_at")->get();
			foreach($nfts as $nft)
			{
                if($nft->auction_status == "sold")
                {
                    $nft['is_sold'] = "yes";
                }
                $auctionData = Auctions::where('nftid','=',$nft->nftid)->first();
                $nft['bidcount'] = Auctions::where('nftid','=',$nft->nftid)->count();
                $highestBid = Auctions::where('nftid','=',$nft->nftid)->max('bid_amount');
                $nft['highestBid'] = (!empty($highestBid)) ? $highestBid : 0;
                $nft['auction_status'] = (!empty($auctionData)) ? $auctionData->status : "";
                $nft['auction_end_time'] = $nft->auction_end_time;
                $nftstatus = DB::table('soldnfts')->where("nftid", $nft->nftid)->first();
                $nft['sold_status'] = (!empty($nftstatus)) ? $nftstatus->status : "";
				$row[] = $nft;
			}
			$nfts = $row;
            return view('nfts.auction', compact('user', 'nfts'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    public function indemand()
    {
        $row = array();
        if(Auth::check())
        {
            $user = Auth::user();
            $nfts = Nfts::where('creator_id', "=", $user->creator_id)->where("type", "demand")->orderByDesc("created_at")->get();
            foreach($nfts as $nft)
			{
                if($nft->auction_status == "sold")
                {
                    $nft['is_sold'] = "yes";
                }
				$nft['offercount'] = Offers::where('nftid','=',$nft->nftid)->count();
                $highestOffer = Offers::where('nftid','=',$nft->nftid)->max('offer_amount');
                $nft['highestOffer'] = $highestOffer;
                $nftstatus = DB::table('soldnfts')->where("nftid", $nft->nftid)->first();
                $nft['sold_status'] = (!empty($nftstatus)) ? $nftstatus->status : "";
				$row[] = $nft;
			}
			$nfts = $row;
            return view('nfts.demandsupply', compact('user', 'nfts'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    public function indraft()
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $nfts = Nfts::where("owner_id", $user->creator_id)->where("status", "draft")->orderByDesc("created_at")->get();
            return view('nfts.drafts', compact('user', 'nfts'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    public function myPurchases()
    {
        $row = array();
        $user = Auth::user();
        $row = array();
        $creator_id = (!empty($user)) ? $user->creator_id : "";
        $purchases = Purchases::where("owner_id", $creator_id)->orderByDesc("created_at")->get();
        
        if(!empty($purchases))
        {
            foreach($purchases as $purchase)
            {
                $purchasedNft = Nfts::where('nftid', $purchase->nftid)->first();
                if(!empty($purchasedNft))
                {
                    $purchase['file'] = $purchasedNft->file;
                    $purchase['title'] = $purchasedNft->title;
                    $purchase['owner'] = $purchasedNft->owner_id;
                    $purchase['sold_status'] = $purchasedNft->auction_status;
                    $purchase['is_resale'] = $purchase->resale_status;
                    $purchase['nft_resale'] = $purchasedNft->resale;
                    $purchase['type'] = $purchase->type;
                }
                $row[] = $purchase;
            }
        }
        $purchases = $row;
        return view( 'nfts.purchases', compact('purchases','user') );
    }
    
    public function soldByme()
    {
        $row = array();
        $user = Auth::user();
        $row = array();
        $creator_id = (!empty($user)) ? $user->creator_id : "";
        $soldnfts = Purchases::where("creator_id", $creator_id)->orderByDesc("created_at")->get();
        foreach($soldnfts as $solditem)
        {
            $soldNft = Nfts::where('nftid', $solditem->nftid)->where('auction_status', "sold")->first();
            $soldPrice = DB::table('nftescrows')->select('amount_paid')->where('nftid', $solditem->nftid)->first();
            if(!empty($soldNft) && !empty($soldPrice))
            {
                $solditem['file'] = $soldNft->file;
                $solditem['title'] = $soldNft->title;
                $solditem['type'] = $soldNft->type;
                $solditem['soldprice'] = $soldPrice->amount_paid;
                $row[] = $solditem;
            }
        }
        $soldnfts = $row;
        return view( 'nfts.solditems', compact('soldnfts','user') );
    }
    
    public function bidMade()
    {
		$usertype = "";
		$count = "0";
		$row = array();
        if(Auth::check())
        {
            $user = Auth::user();
            $bids = Auctions::where("user_id", $user->creator_id)->orderByDesc("created_at")->get();
			foreach($bids as $bid)
			{
				$bid['bidcount'] = Auctions::where('nftid','=',$bid->nftid)->count();
				$nftdata = Nfts::where('nftid','=',$bid->nftid)->first();
				if(!empty($nftdata))
                {
                    $bid['title'] = $nftdata->title;
                    $bid['file'] = $nftdata->file;
                    $highestBid = Auctions::where("nftid", $bid->nftid)->max('bid_amount');
                    $bid['baseprice'] = $nftdata->price;
                    $bid['highestBid'] = $highestBid;
                }
				$row[] = $bid;
			}
			$bids = $row;
            return view('nfts.bidmade', compact('user', 'bids', 'usertype'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    public function offerMade()
    {
        $row = array();
        if(Auth::check())
        {
            $user = Auth::user();
            $offers = Offers::where("user_id", $user->creator_id)->orderByDesc("created_at")->get();
			foreach($offers as $offer)
			{
				$offer['offercount'] = Offers::where('nftid','=',$offer->nftid)->count();
				$nftdata = Nfts::where('nftid','=',$offer->nftid)->first();
                if(!empty($nftdata))
                {
                    $offer['title'] = $nftdata->title;
                    $offer['file'] = $nftdata->file;
                    $offer['baseprice'] = $nftdata->price;
                    $highestOffer = Offers::where("nftid", $offer->nftid)->max('offer_amount');
                    $offer['highestOffer'] = $highestOffer;
                }
				
				$row[] = $offer;
			}
			$offers = $row;
            return view('nfts.offermade', compact('user', 'offers'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::check())
        {
            if(Auth::user()->user_type == "")
            {
                return redirect()->intended('newuser')
                                    ->withSuccess('Please select what type of account you want to gp with?');
                
            }else{
                $user = Auth::user();
                return view('nfts.create', compact('user'));
            }
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datenow  = strtotime(Carbon::now('Asia/Kolkata'));
        $date = $request->input('date');
        $time = $request->input('time');
        $auctiondate = strtotime(date('Y-m-d H:i:s', strtotime("$date $time")));
        if($datenow > $auctiondate)
        {
            return redirect("createnft")->withSuccess("Sorry, auction time should be greater then current time!.");
            exit;
        }
        $combinedDT = "";
        $nftData = array();
        if(Auth::check())
        {
            $user = Auth::user();
            $nftData['creator_id'] = $user->creator_id;
        }else{
            return redirect("login")->withSuccess('Opps! You do not have access');
        }
        
        if($request->hasFile('video'))  
        {
            $file = $request->file('video');
            $fileName = time().'_'.$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            if($extension == "m4a" || $extension == "zip" || $extension == "exe" || $extension == "dmg")
            {
                return redirect("createnft")->withSuccess("Sorry, Operation failed! Please try to upload with these supported formats (jpg,webp,png,gif,mp4,mp3,jpeg).");
                exit;
            }
            $fileNameNew = rand(11111, 99999) . '.' . $extension;
            $filePath = $file->storeAs('uploads/creator/' . $request->input('creator_id'), $fileNameNew, 'public');
            $nftfile = asset("storage/app/public/".$filePath);
            $fileHash = sha1_file( $nftfile );
            $nftid = substr($fileHash, 0, 10);
            //$nftid = substr(str_shuffle($fileHash), 0, 10);
            $nftData['nftid'] = $nftid;
            $nftData['file'] = $filePath;
        }
        $nftData['type'] = $request->input('store_as');
        $nftData['owner_id'] = $nftData['creator_id'];
        $nftData['title'] = $request->input('title');
        $nftData['category'] = $request->input('category');
        $nftData['auction_time'] = date('Y-m-d H:i:s');
        if( $request->input('date') != "" && $request->input('time') != "")
        {
            $date = $request->input('date');
            $time = $request->input('time');
            $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
            $date_convert = strtotime($combinedDT);
            $nftData['auction_end_time'] = $combinedDT;
        }else{
            $combinedDT = NULL;
        }
        $nftData['tags'] = $request->input('tags');
        $nftData['price'] = $request->input('price');
        $published_status = "";
        if($nftData['price'] == "" || $nftData['auction_end_time'] == "")
        {
            $published_status = "draft";
            $nftData['type'] = "draft";
        }else{
            $published_status = "published";
            $nftData['type'] = $request->input('store_as');
        }
        $nftData['status'] = ($request->input('store_as') != "draft") ? $published_status : "draft";
        $is_duplicate_file = Nfts::where("nftid", $nftid)->get();
        if($is_duplicate_file->isEmpty())
        {
            $template = "";
            switch($nftData['type'])
            {
                case "draft" :
                    $template = "draft";
                    break;
                case "demand" :
                    $template = "indemand";
                    break;
                case "auction" :
                    $template = "nftlist";
                    break;
            }
            $rsult = DB::table('nfts')->insert($nftData);
            if($rsult)
            {
                DB::delete('DELETE FROM nfts_temp_preview WHERE creator_id = ?', [$nftData['creator_id']]);
                return redirect($template)->with('status',"NFT Created Successfully");
            }else{
                return redirect($template)->with('failed',"Operation Failed! Something Wrong.");
            }
        }else{
            return redirect('nftlist')->with('failed',"Operation Failed! The file already exist in our system. Please Uplaod diffrent and valid file.");
        }
    }
    
    public function addFavourite(Request $request)
    {
        $likedArray = array();
        if(Auth::check())
        {
            $user = Auth::user();
            $likedArray['user_id'] = $user->creator_id;
            $likedArray['nftid'] = $request->input('id');
            $rsult = DB::table('liked_nfts')->insert($likedArray);
            if($rsult)
            {
                $getNftslikes = Nfts::where('nftid', $request->input('id'))->first();
                $likes = $getNftslikes->likes;
                $newlike = $likes + 1;
                $result = DB::table('nfts')
                        ->where('nftid', $request->input('id'))
                        ->update(array('likes' => $newlike,'is_favourite' => $request->input('val')));
                if($result)
                {
                    echo 1;
                }else{
                    echo 0;
                }
            }else{
                echo 0_0;
            }
        }else{
            echo 'You need to login first to like this nft.';
        }
        die;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nfts  $nfts
     * @return \Illuminate\Http\Response
     */
    public function show($nftid)
    {
        $userarr = array();
        $nfts = Nfts::where("nftid", $nftid)->first();
        $likedstatus = $this->checknftliked($nfts->nftid);
        if( count($likedstatus) > 0)
        {
            foreach($likedstatus as $liked)
            {
                if($liked->liked == "yes")
                {
                    $nfts['like'] = $liked->liked;
                }else{
                    $nfts['like'] = "no";
                }
            }
        }
        $nfts['is_sold'] = $this->isNftSoldOut($nfts->nftid);
        $createdBy = User::where('creator_id', $nfts->creator_id)->first();
        $ownedBy = User::where('creator_id', $nfts->owner_id)->first();
        $currentBid = DB::table('auctions')->latest('bid_amount')->where("nftid", $nfts->nftid)->first();
        $user = Auth::user();
        $currentOffer = DB::table('offers')->latest('offer_amount')->where("nftid", $nfts->nftid)->first();
        $comments = Comments::where('nftid', $nfts->nftid)->get();
        foreach($comments as $comment)
        {
            $userDetails = User::where('creator_id', $comment->user_id)->first();
            $comment['dp'] = asset("storage/app/public/".$userDetails->dp);
            $comment['name'] = $userDetails->name;
            $userarr[] = $comment;
        }
        $comments = $userarr;
        return view('innertemplates.nftview',compact('nfts','user','currentBid','currentOffer','comments','createdBy', 'ownedBy'));
    }
    
    public function details($nftid)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $nfts = Nfts::where("nftid", $nftid)->first();
            $highestBid = Auctions::where("nftid", $nftid)->max('bid_amount');
            $nfts['bidcount'] = Auctions::where('nftid','=',$nftid)->count();
            return view('nfts.nftdetails',compact('nfts','user','highestBid'));
        }
    }
    
    //detailsDemandSupply
    
    public function detailsDemandSupply($nftid)
    {
        $row = array();
        $nfts = Nfts::where("nftid", $nftid)->first();
        $likedstatus = $this->checknftliked($nfts->nftid);
        if( count($likedstatus) > 0)
        {
            foreach($likedstatus as $liked)
            {
                if($liked->liked == "yes")
                {
                    $nfts['like'] = $liked->liked;
                }else{
                    $nfts['like'] = "no";
                }
            }
        }
        $nftstatus = DB::table('soldnfts')->where("nftid", $nftid)->first();
        $highestOffer = Offers::where("nftid", $nftid)->max('offer_amount');
        $getOffer = Offers::where("nftid", $nftid)->first();
        $nfts['offercount'] = Offers::where('nftid','=',$nfts->nftid)->count();
        $user = Auth::user();
        return view('nfts.nftdemanddetails',compact('nfts','user','highestOffer','getOffer','nftstatus'));
    }
    
    public function getFavouriteNfts()
    {
        $allnfts = array();
        $loggedInUserId = "";
        if(Auth::check())
        {
            $user = Auth::user();
            /**
            get nfts of users**/
            
            $nfts = DB::table('liked_nfts')->select('nftid','user_id')->where('user_id', $user->creator_id)->distinct()->get();

            foreach( $nfts as $nft )
            {
                //DB::enableQueryLog();
                $islike = Nfts::where('nftid', $nft->nftid)->get();
                //$query = DB::getQueryLog();
                //dd($query);
                $count = count($islike);

                if($count > 0)
                {
                    foreach($islike as $liked)
                    {
                        if($liked->nftid == $nft->nftid)
                        {
                            $nft->liked = "yes";
                        }else{
                            $nft->liked = "no";
                        }
                        $nft->file = $liked->file;
                        $nft->title = $liked->title;
                        $nft->id = $liked->id;
                        $nft->name = $liked->name;
                        $nft->tags = $liked->tags;
                        $nft->type = $liked->type;
                        $creatorinfo = User::where('creator_id', $liked->creator_id)->get();
                        foreach($creatorinfo as $creators)
                        {
                            $nft->creator_name = $creators->name;
                            $nft->creator_badge = $creators->badges;
                        }
                        $owner = User::where('creator_id', $liked->owner_id)->get();
                        foreach($owner as $onwerinfo)
                        {
                            $nft->owner_name = $onwerinfo->name;
                            $nft->owner_badges = $onwerinfo->badges;
                        }
                        
                        $highestBid = Auctions::where("nftid", $nft->nftid)->max('bid_amount');
                        $nft->heighest_bid = ($highestBid != "") ? $highestBid : 0;
                        $waitingStatus = DB::table('final_auction')->where('nftid', $nft->nftid)->get();
                        $checkiftobsold = count($waitingStatus);
                        $nft->days_left = "Live";
                        if($checkiftobsold > 0)
                        {
                            foreach($waitingStatus as $toBSold)
                            {
                                if($toBSold->status == "waiting")
                                {
                                    $nft->days_left = "2 Days Left";
                                }
                            }
                        }
                        
                        $allnfts[] = $nft;
                    }
                }
            }
            
            $nfts = $allnfts;
            return view('innertemplates.fovourites', compact('user', 'nfts'));
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nfts  $nfts
     * @return \Illuminate\Http\Response
     */
    public function edit($nftid)
    {
        if(Auth::check())
        {
            $dt = Carbon::now();
            $nfts = Nfts::where("nftid", $nftid)->first();
            $user = Auth::user();
            $dt->timestamp = strtotime($nfts->auction_end_time);
            $hour = ($dt->hour <= 9) ? '0'.$dt->hour : $dt->hour;
            $minute = $dt->minute;
            $auction_date = date("m/d/Y", strtotime($nfts->auction_end_time));
            return view('nfts.edit',compact('nfts','user', 'hour', 'minute','auction_date'));
        }
    }
    
    public function marketPlace()
    {
        $user = Auth::user();
        $nfts = $this->getAllNfts();
        $verifiedNfts = $this->getAllNfts("varified",12);
        $trendingNfts = $this->getAllNfts("trending",12); //$this->getTrendingNfts();
        $mostviewdNfts = $this->getAllNfts("mostliked",12); // mostliked $this->mostViewed();
        //return view('innertemplates.marketplace',compact('nfts','user','celebs', 'trending','mostliked'));
        return view('innertemplates.marketplace',compact('nfts','verifiedNfts','user', 'trendingNfts','mostviewdNfts'));
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
        $nftData = array();
        if(Auth::check())
        {
            $user = Auth::user();
            $nftData['creator_id'] = $user->creator_id;
        }else{
            return redirect("login")->withSuccess('Opps! You do not have access');
        }
        
        if($request->hasFile('video'))
        {
            $file = $request->file('video');
            $fileName = time().'_'.$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileNameNew = rand(11111, 99999) . '.' . $extension;
            $filePath = $file->storeAs('uploads/creator/' . $request->input('creator_id'), $fileNameNew, 'public');
            $nftfile = asset("storage/app/public/".$filePath);
            $fileHash = sha1_file( $nftfile );
            $nftid = substr($fileHash, 0, 10);
            $nftData['nftid'] = $nftid;
            $nftData['file'] = $filePath;
        }
        $nftData['type'] = $request->input('store_as');
        $nftData['owner_id'] = $nftData['creator_id'];
        $nftData['title'] = $request->input('title');
        $nftData['category'] = $request->input('category');
        $nftData['tags'] = $request->input('tags');
        $date = $request->input('date');
        $time = $request->input('time');
        $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
        $nftData['auction_time'] = date('Y-m-d H:i:s');
        $nftData['auction_end_time'] = $combinedDT;
        $nftData['price'] = $request->input('price');
        
        $nftData['status'] = ($request->input('store_as') != "draft") ? "published" : "draft";
        $is_duplicate_file = Nfts::where("nftid", $nftid)->get();
        if($is_duplicate_file->isEmpty())
        {
            $template = "";
            switch($nftData['type'])
            {
                case "draft" :
                    $template = "draft";
                    break;
                case "demand" :
                    $template = "indemand";
                    break;
                case "auction" :
                    $template = "nftlist";
                    break;
            }
            $rsult = DB::table('nfts')->where("id", $request->input('id'))->update($nftData);
            if($rsult)
            {
                return redirect($template)->with('status',"NFT Created Successfully");
            }else{
                return redirect($template)->with('failed',"Operation Failed! Something Wrong.");
            }
        }else{
            return redirect('nftlist')->with('failed',"Operation Failed! The file already exist in our system. Please Uplaod diffrent and valid file.");
        }
    }
    
    public function publish(Request $request)
    {
        $nftData = array();
        $nftDetails = Nfts::where("nftid", $request->input('nftid'))->first();
        if(Auth::check())
        {
            $user = Auth::user();
        }else{
            return redirect("login")->withSuccess('Opps! You do not have access');
        }
        
        if($request->hasFile('video'))
        {
            $file = $request->file('video');
            $fileName = time().'_'.$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileNameNew = rand(11111, 99999) . '.' . $extension;
            $filePath = $file->storeAs('uploads/creator/' . $request->input('creator_id'), $fileNameNew, 'public');
            $nftfile = asset("storage/app/public/".$filePath);
        }
        $nftData['type'] = $request->input('store_as');
        $nftData['title'] = $request->input('title');
        $nftData['category'] = $nftDetails->category;
        $nftData['tags'] = ($request->input('tags') == "") ? $nftDetails->tags : $request->input('tags');
        if($nftData['type'] != "indemand")
        {
            $date = $request->input('date');
            $time = $request->input('time');
            $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
            $nftData['auction_time'] = date('Y-m-d H:i:s');
            $nftData['auction_end_time'] = $combinedDT;
        }
        $nftData['price'] = $request->input('price');
        
        $nftData['status'] = "published";
        $pid = "";
        if($request->input('resale') == 1)
        {
            $nftData['resale'] = 1;
            $nftData['auction_status'] = "in auction";
            $pid = $request->input('purchaseId');
        }
        
        $template = "";
        switch($nftData['type'])
        {
            case "draft" :
                $template = "draft";
                break;
            case "demand" :
                $template = "indemand";
                break;
            case "auction" :
                $template = "nftlist";
                break;
        }
        
        $rsult = DB::table('nfts')->where("id", $request->input('id'))->update($nftData);
        if($rsult)
        {
            if($request->input('resale') == 1)
            {
                DB::delete('DELETE FROM auctions WHERE nftid = ?', [$request->input('nftid')]);
                
                DB::delete('DELETE FROM offers WHERE nftid = ?', [$request->input('nftid')]);
                
                DB::table('purchases')->where('id', $pid)->where("owner_id", $nftDetails->owner_id)->where('nftid', $request->input('nftid'))->update(array('resale_status' => 1));
                
                DB::table('nfts')->where("owner_id", $nftDetails->owner_id)->where('nftid', $request->input('nftid'))->update(array('resale' => 1, 'auction_status' => "in auction"));
            }
            return redirect($template)->with('status',"NFT Published Successfully");
        }else{
            return redirect($template)->with('failed',"Operation Failed! Something Wrong.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nfts  $nfts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }
    
    public function preview(Request $request)
    {
        $nftid = 0;
        $nftData = array();
        if(Auth::check())
        {
            $user = Auth::user();
            $nftData['creator_id'] = $user->creator_id;
            DB::delete('DELETE FROM nfts_temp_preview WHERE creator_id = ?', [$user->creator_id]);
        }else{
            return redirect("login")->withSuccess('Opps! You do not have access');
        }
        
        if($request->hasFile('video'))
        {
            $file = $request->file('video');
            $fileName = time().'_'.$file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileNameNew = rand(11111, 99999) . '.' . $extension;
            $filePath = $file->storeAs('uploads/creator/' . $request->input('creator_id'), $fileNameNew, 'public');
            $nftfile = asset("storage/app/public/".$filePath);
            $fileHash = sha1_file( $nftfile );
            $nftid = substr($fileHash, 0, 10);
            $nftData['file'] = $filePath;
        }
        $nftData['nftid'] = $nftid;
        $nftData['type'] = $request->input('store_as');
        $nftData['owner_id'] = $nftData['creator_id'];
        $nftData['title'] = $request->input('title');
        $nftData['category'] = $request->input('category');
        $nftData['tags'] = $request->input('tags');
        $date = $request->input('date');
        $time = $request->input('time');
        $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
        $nftData['auction_time'] = date('Y-m-d H:i:s');
        $nftData['auction_end_time'] = $combinedDT;
        $nftData['price'] = $request->input('price');
        
        $nftData['status'] = ($request->input('store_as') != "draft") ? "published" : "draft";

        $rsult = DB::table('nfts_temp_preview')->insert($nftData);
        if($rsult)
        {
            $user = Auth::user();
            $nft = DB::table('nfts_temp_preview')->latest('id')->where("creator_id", $nftData['creator_id'])->first();
            ob_start();
                return view('dashboard/nftpreview', compact('nft','user'));
            $preview = ob_get_clean();
            echo $preview;
        }else{
            echo 2;
        }
        die;
    }
    
    function countView(Request $request)
    {
        $nftData = array();
        $nftId = $request->input('nftid');
        $id = $request->input('rowid');
        $nft = Nfts::where("nftid", $nftId)->first();
        $totalViews = $nft->views;
        $totalviewadd = $totalViews + 1;
        
        $nftData['views'] = $totalviewadd;
        $result = DB::table('nfts')->where("nftid", $nftId)->update($nftData);
        if($result)
        {
            echo "1";
        }else{
            echo "0";
        }
        
        die();
    }
    
    public function getOffers($nftid)
    {
        $buyerdetails = array();
        $user = Auth::user();
        $allOffers = Offers::where('owner_id', $user->creator_id)->orWhere('nftid', $nftid)->get();
        foreach($allOffers as $offer)
        {
            if($offer->nftid == $nftid)
            {
                $nftDetails = Nfts::where('nftid', $nftid)->first();
                $buyer = User::where('creator_id', $offer->user_id)->first();
                $offer['buyer_name'] = $buyer->name;
                $offer['buyer_phone'] = $buyer->phone;
                $offer['buyer_id'] = $buyer->creator_id;
                $offer['buyer_email'] = $buyer->email;
                $offer['file'] = $nftDetails->file;
                $offer['is_sold'] = $nftDetails->auction_status;
                $offer['title'] = $nftDetails->title;
                $buyerdetails[] = $offer;
            }
        }
        $allOffers = $buyerdetails;
        return view('nfts.offers',compact('allOffers','user'));
    }
    
    public function actionPending()
    {
        if(Auth::check())
        {
            $buyerdetails = array();
            $user = Auth::user();
            $allPendingPurchases = DB::table('final_auction')->where('bidder_id', $user->creator_id)->orderByDesc("created_at")->get();
            foreach($allPendingPurchases as $pendingPurchase)
            {
                if($pendingPurchase->status != "paid")
                {
                    $nftDetails = Nfts::where('nftid', $pendingPurchase->nftid)->first();
                    $pendingAmount = $pendingPurchase->amount_pending;
                    $buyer = User::where('creator_id', $pendingPurchase->bidder_id)->first();
                    $pendingPurchase->file = $nftDetails->file;
                    $pendingPurchase->id = $pendingPurchase->id;
                    $pendingPurchase->title = $nftDetails->title;
                    $pendingPurchase->status = $pendingPurchase->status;
                    $pendingPurchase->buyer = $buyer->name;
                    $pendingPurchase->nftid = $pendingPurchase->nftid;
                    $pendingPurchase->timeleft = $pendingPurchase->waiting_time;
                    $pendingPurchase->amount = $pendingAmount;
                    $pendingPurchase->bidder_id = $pendingPurchase->bidder_id;
                    $buyerdetails[] = $pendingPurchase;
                }
            }
            $allPendingPurchases = $buyerdetails;
            return view('nfts.gotchance',compact('allPendingPurchases','user'));
        }else{
            return redirect("login")->withSuccess('Opps! You do not have access');
        }
    }
    
    function checkNftTwoDaysLeft($nftId)
    {
        $inAuctionNfts = Auctions::where("nftid", $nftId)->first();
        //$checkPendingAmount = 
    }
    
    public function viewAll($viewtype)
    {
        $view = "";
        $nftsarr = array();
        $rownft = array();
        $user = Auth::user();
        switch($viewtype)
        {
            case "verified":
                $nfts = $this->getAllNfts("varified");
                return view('innertemplates.'.$viewtype, compact('nfts','user'));
                break;
                
            case "trending":
                $nfts = $this->getAllNfts("trending");
                return view('innertemplates.'.$viewtype, compact('nfts','user'));
                break;
                
            case "mostliked":
                $nfts = $this->getAllNfts("mostliked");
                return view('innertemplates.'.$viewtype, compact('nfts','user'));
                break;
             case "others":
                $nfts = $this->getAllNfts();
                return view('innertemplates.'.$viewtype, compact('nfts','user'));
                break;
        }
    }
    
    public function checknftliked($nftid)
    {
        $likedNftsStatus = array();
        $nfts = DB::table('liked_nfts')->select('nftid','user_id')->where('nftid', $nftid)->distinct()->get();

        foreach( $nfts as $nft )
        {
            //DB::enableQueryLog();
            $islike = Nfts::where('nftid', $nft->nftid)->get();
            //$query = DB::getQueryLog();
            //dd($query);
            $count = count($islike);

            if($count > 0)
            {
                foreach($islike as $liked)
                {
                    if(Auth::check() && $liked->nftid == $nftid)
                    {
                        $nft->liked = "yes";
                    }else{
                        $nft->liked = "no";
                    }
                    $likedNftsStatus[] = $nft;
                }
            }
        }

        $nfts = $likedNftsStatus;

        return $nfts;
    }
    
    public function checknftsold(Request $request)
    {
        $response = "live";
        $nftid = $request->input('nftid');
        $response = "";
        $solNfts = Nfts::join('purchases', 'nfts.nftid', '=', 'purchases.nftid')
               ->where('purchases.nftid', $nftid)->get(['purchases.*', 'purchases.nftid']);
        foreach($solNfts as $nft)
        {
            if($nft->nftid == $nftid)
            {
                $response = "sold";
            }
        }
        
        echo $response;
        die;
    }
    
    public function isNftSoldOut($nftId)
    {
        $response = "";
        $solNfts = Nfts::where('nftid', $nftId)->where('auction_status',"=","sold")->get();
        
        $count = count((array)$solNfts);
        if($count > 0)
        {
            foreach($solNfts as $nft)
            {
                if($nft->nftid == $nftId)
                {
                    $response = "sold";
                }else{
                    $response = "live";
                }
            }
            
        }
        
        return $response;
    }
    
    public function clearallnofifications(Request $request)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            
            DB::delete('DELETE FROM notifications WHERE user_id = ?', [$user->creator_id]);
            
            echo 1;
            
            die;
        }
    }
    
    public function checkIfUserVerified($user_id)
    {
        $details = array();
        $userDetails = User::where('creator_id', "=", $user_id)->first();
        if(!empty($userDetails))
        {
            if($userDetails->badges == "gold" || $userDetails->badges == "purple")
            {
                $details['name'] = $userDetails->name;
                $details['badges'] = $userDetails->badges;
            }else{
                $details['name'] = $userDetails->name;
                $details['badges'] = "";
            }
        }
        
        return $details;
    }
    
    public function getHeighestBid($nftid)
    {
        return DB::table('auctions')->where('nftid', $nftid)->max('bid_amount');  
    }
    
    public function getAllNfts($type=null,$limit=null)
    {
        $nfts = "";
        $list = array();
        $whereArray = array('status' => "published", "auction_status" => NULL);

        $query = DB::table('nfts');
        foreach($whereArray as $field => $value) {
            $query->where($field, $value);
        }
        if($type != null && $type == "varified")
        {
            $nfts = $query->whereBetween('created_at', 
                        [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                    )->orderByDesc("created_at")->limit($limit)->get();
        }else if($type != null && $type == "trending"){
            $nfts = $query->where("views", ">=", '1')->whereBetween('created_at', 
                        [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                    )->orderByDesc("views")->limit($limit)->get();
        }else if($type != null && $type == "mostliked"){
            $nfts = $query->where("likes", ">=", '1')->whereBetween('created_at', 
                        [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                    )->orderByDesc("likes")->limit($limit)->get();
        }else{
            $nfts = $query->orderByDesc("created_at")->get();
        }
        
        foreach($nfts as $nft)
        {
            $likedstatus = $this->checknftliked($nft->nftid);
            if( count($likedstatus) > 0)
            {
                foreach($likedstatus as $liked)
                {
                    if($liked->liked == "yes")
                    {
                        $nft->liked = $liked->liked;
                    }else{
                        $nft->liked = "no";
                    }
                }
            }else{
                        $nft->liked = "no";
                    }
            $cerator = $this->checkIfUserVerified($nft->creator_id);
            $owner = $this->checkIfUserVerified($nft->owner_id);
            $nft->creator_name = $cerator['name'];
            $nft->creator_badge = $cerator['badges'];
            $nft->owner_name = $owner['name'];
            $nft->owner_badges = $owner['badges'];
            $highestBid = $this->getHeighestBid($nft->nftid);
            $nft->heighest_bid = ($highestBid != "") ? $highestBid : 0;
            $waitingStatus = DB::table('final_auction')->where('nftid', $nft->nftid)->get();
            $checkiftobsold = count($waitingStatus);
            if($checkiftobsold > 0)
            {
                foreach($waitingStatus as $toBSold)
                {
                    if($toBSold->status == "waiting")
                    {
                        $nft->days_left = "Waiting For Payment";
                    }else{
                        $nft->days_left = "Live";
                    }
                }
            }else{
                        $nft->days_left = "Live";
                    }
            
            $list[] = $nft;
        }

       return $list;
    }
}
