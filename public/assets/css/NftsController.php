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
            $nfts = Nfts::where("creator_id", $user->creator_id)->where("type", "auction")->where("status", '!=', "sold")->get();
			foreach($nfts as $nft)
			{
                $auctionData = Auctions::where('nftid','=',$nft->nftid)->first();
				$nft['bidcount'] = Auctions::where('nftid','=',$nft->nftid)->count();
                $highestBid = Auctions::where('nftid','=',$nft->nftid)->max('bid_amount');
                $nft['highestBid'] = (!empty($highestBid)) ? $highestBid : 0;
                $nft['auction_status'] = (!empty($auctionData)) ? $auctionData->status : "";
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
            $nfts = Nfts::where("creator_id", $user->creator_id)->where("type", "demand")->where("status", '!=', "sold")->get();
            foreach($nfts as $nft)
			{
                
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
            $nfts = Nfts::where("creator_id", $user->creator_id)->where("status", "draft")->get();
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
        $purchases = Purchases::where("owner_id", $creator_id)->get();
        foreach($purchases as $purchase)
        {
            $purchasedNft = Nfts::where('nftid', $purchase->nftid)->first();
            $purchase['file'] = $purchasedNft->file;
            $purchase['title'] = $purchasedNft->title;
            $row[] = $purchase;
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
        $soldnfts = Purchases::where("owner_id", $creator_id)->get();
        foreach($soldnfts as $solditem)
        {
            $soldNft = Nfts::where('nftid', $solditem->nftid)->where('status', "sold")->first();
            $solditem['file'] = $soldNft->file;
            $solditem['title'] = $soldNft->title;
            $row[] = $solditem;
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
            $bids = Auctions::where("user_id", $user->creator_id)->get();
			foreach($bids as $bid)
			{
				$bid['bidcount'] = Auctions::where('nftid','=',$bid->nftid)->count();
				$nftdata = Nfts::where('nftid','=',$bid->nftid)->first();
				$bid['title'] = $nftdata->title;
				$bid['file'] = $nftdata->file;
                $highestBid = Auctions::where("nftid", $bid->nftid)->max('bid_amount');
				$bid['baseprice'] = $nftdata->price;
                $bid['highestBid'] = $highestBid;
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
            $offers = Offers::where("user_id", $user->creator_id)->get();
			foreach($offers as $offer)
			{
				$offer['offercount'] = Offers::where('nftid','=',$offer->nftid)->count();
				$nftdata = Nfts::where('nftid','=',$offer->nftid)->first();
				$offer['title'] = $nftdata->title;
				$offer['file'] = $nftdata->file;
				$offer['baseprice'] = $nftdata->price;
                $highestOffer = Offers::where("nftid", $offer->nftid)->max('offer_amount');
                $offer['highestOffer'] = $highestOffer;
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
        $nftData['auction_time'] = date('Y-m-d H:i:s');
        if( $request->input('date') != "" && $request->input('time') != "")
        {
            $date = $request->input('date');
            $time = $request->input('time');
            $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
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
            $nfts['bidcount'] = Auctions::where('nftid','=',$nfts->nftid)->count();
            return view('nfts.nftdetails',compact('nfts','user','highestBid'));
        }
    }
    
    //detailsDemandSupply
    
    public function detailsDemandSupply($nftid)
    {
        $row = array();
        $nfts = Nfts::where("nftid", $nftid)->first();
        $nftstatus = DB::table('soldnfts')->where("nftid", $nftid)->first();
        $highestOffer = Offers::where("nftid", $nftid)->max('offer_amount');
        $getOffer = Offers::where("nftid", $nftid)->first();
        $nfts['offercount'] = Offers::where('nftid','=',$nfts->nftid)->count();
        $user = Auth::user();
        return view('nfts.nftdemanddetails',compact('nfts','user','highestOffer','getOffer','nftstatus'));
    }
    
    public function getFavouriteNfts()
    {
        $row = array();
        if(Auth::check())
        {
            $user = Auth::user();
            $likednfts = DB::table('liked_nfts')->where("user_id", $user->creator_id)->get();
            foreach($likednfts as $nft)
            {
                $likedarr = DB::table('nfts')->where("nftid", $nft->nftid)->first();
                $nfts[] = $likedarr;
            }
            foreach($nfts as $nft)
            {
                $highestBid = Auctions::where("nftid", $nft->nftid)->max('bid_amount');
                $nft->bidcount = Auctions::where('nftid','=',$nft->nftid)->count();
                $nft->highestBid = $highestBid;
                $creatorDetails = User::where('creator_id', $nft->creator_id)->first();
                $nft->creatorname = $creatorDetails->name;
                $row[] = $nft;
            }
            $nfts = $row;
            return view('innertemplates.fovourites', compact('user', 'nfts'));
        }
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
        $rownft = array();
        $user = Auth::user();
        $creator_id = (!empty($user)) ? $user->creator_id : "";
        $celebs = Nfts::join('users', 'users.creator_id', '=', 'nfts.creator_id')->where("users.badges", "=", "gold")->orWhere("users.badges", "=", "purple")->where("nfts.type", "!=", "draft")->where("nfts.status", '!=', "draft")->where("users.badges", "!=", "")->get();
        $c = array();
        foreach($celebs as $cnfts)
        {
            $isnftlike = DB::table('liked_nfts')->where('nftid', $cnfts->nftid)->where('user_id', $creator_id)->first();
            if(!empty($isnftlike))
            {
                $cnfts['liked'] = "yes";
            }else{
                $cnfts['liked'] = "no";
            }
            $c[] = $cnfts;
        }
        $celebs = $c;
        $trending = Nfts::join('users', 'users.creator_id', '=', 'nfts.creator_id')->where("nfts.views", ">=", "500")->where("nfts.type", "!=", "draft")->where("nfts.status", '!=', "sold")->get();
        $tr = array();
        foreach($trending as $trnfts)
        {
            $isnftlike = DB::table('liked_nfts')->where('nftid', $trnfts->nftid)->where('user_id', $creator_id)->first();
            if(!empty($isnftlike))
            {
                $trnfts['liked'] = "yes";
            }else{
                $trnfts['liked'] = "no";
            }
            $tr[] = $trnfts;
        }
        $trending = $tr;
        $mostliked = Nfts::join('users', 'users.creator_id', '=', 'nfts.creator_id')
        ->where("nfts.likes", ">=", '100')
        ->orWhere("users.creator_id", "=", $creator_id)
        ->where("nfts.type", "!=", "draft")
        ->where("nfts.status", '!=', "sold")
        ->where("users.badges", "=", "")
        ->get();
        $ml = array();
        foreach($mostliked as $mlnfts)
        {
            $isnftlike = DB::table('liked_nfts')->where('nftid', $mlnfts->nftid)->where('user_id', $creator_id)->first();
            if(!empty($isnftlike))
            {
                $mlnfts['liked'] = "yes";
            }else{
                $mlnfts['liked'] = "no";
            }
            $ml[] = $mlnfts;
        }
        $mostliked = $ml;
        $row = array();
        $nfts = Nfts::join('users', 'users.creator_id', '=', 'nfts.creator_id')->where("nfts.type", "!=", "draft")->where("nfts.status", '!=', "draft")->where("users.badges", "=", "gold")->orWhere("users.badges", "=", "purple")->paginate(8);
        foreach($nfts as $nft)
        {
            $highestBid = Auctions::where("nftid", $nft->nftid)->max('bid_amount');
            $nft['heighest_bid'] = $highestBid;
            $row[] = $nft;
        }
        $nfts = $row;
        return view('innertemplates.marketplace',compact('nfts','user','celebs', 'trending','mostliked'));
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
        if(Auth::check())
        {
            $user = Auth::user();
            $nftData['creator_id'] = $user->creator_id;
        }else{
            return redirect("login")->withSuccess('Opps! You do not have access');
        }
        
        $is_duplicate_file = Nfts::where("id", $request->input('id'))->first();
        
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
            if($is_duplicate_file->nftid == $nftid)
            {
                return redirect('nftlist')->with('failed',"Found duplicate! Target file already exist. Please try another one.");
                exit;
            }
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
        
        $nftData['status'] = "published";
        
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
        $allOffers = Offers::where('nftid', $nftid)->where('owner_id', $user->creator_id)->get();
        foreach($allOffers as $offer)
        {
            $nftDetails = Nfts::where('nftid', $nftid)->first();
            $buyer = User::where('creator_id', $offer->user_id)->first();
            $offer['buyer_name'] = $buyer->name;
            $offer['buyer_phone'] = $buyer->phone;
            $offer['buyer_email'] = $buyer->email;
            $offer['file'] = $nftDetails->file;
            $offer['title'] = $nftDetails->title;
            $buyerdetails[] = $offer;
        }
        $allOffers = $buyerdetails;
        return view('nfts.offers',compact('allOffers','user'));
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
                $nfts = Nfts::join('users', 'users.creator_id', '=', 'nfts.creator_id')->where("users.badges", "=", "gold")->orWhere("users.badges", "=", "purple")->where("nfts.type", "!=", "draft")->where("nfts.status", '!=', "draft")->where("users.badges", "!=", "")->get();
                if(Auth::check())
                {
                    $creator_id = (!empty($user)) ? $user->creator_id : "";
                    foreach($nfts as $cnfts)
                    {
                        $isnftlike = DB::table('liked_nfts')->where('nftid', $cnfts->nftid)->where('user_id', $creator_id)->first();
                        if(!empty($isnftlike))
                        {
                            $cnfts['liked'] = "yes";
                        }else{
                            $cnfts['liked'] = "no";
                        }
                        $nftsarr[] = $cnfts;
                    }
                    
                    $nfts = $nftsarr;
                }
                
                return view('innertemplates.'.$viewtype, compact('nfts','user'));
                break;
                
            case "trending":
                $nfts = Nfts::join('users', 'users.creator_id', '=', 'nfts.creator_id')->where("nfts.views", ">=", '5')->where("nfts.type", "!=", "draft")->where("nfts.status", '!=', "draft")->get();
                if(Auth::check())
                {
                    $creator_id = (!empty($user)) ? $user->creator_id : "";
                    foreach($nfts as $trnfts)
                    {
                        $isnftlike = DB::table('liked_nfts')->where('nftid', $trnfts->nftid)->where('user_id', $creator_id)->first();
                        if(!empty($isnftlike))
                        {
                            $trnfts['liked'] = "yes";
                        }else{
                            $trnfts['liked'] = "no";
                        }
                        $nftsarr[] = $trnfts;
                    }
                    
                    $nfts = $nftsarr;
                }
                
                return view('innertemplates.'.$viewtype, compact('nfts','user'));
                break;
                
            case "mostliked":
                $creator_id = (!empty($user)) ? $user->creator_id : "";
                $nfts = Nfts::join('users', 'users.creator_id', '=', 'nfts.creator_id')
                ->where("nfts.likes", ">=", '100')
                ->orWhere("users.creator_id", "=", $creator_id)
                ->where("nfts.type", "!=", "draft")
                ->where("nfts.status", '!=', "draft")
                ->where("users.badges", "=", "")
                ->get();
                if(Auth::check())
                {
                    foreach($nfts as $mlnfts)
                    {
                        $isnftlike = DB::table('liked_nfts')->where('nftid', $mlnfts->nftid)->where('user_id', $creator_id)->first();
                        if(!empty($isnftlike))
                        {
                            $mlnfts['liked'] = "yes";
                        }else{
                            $mlnfts['liked'] = "no";
                        }
                        $nftsarr[] = $mlnfts;
                    }
                    
                    $nfts = $nftsarr;
                }
                
                return view('innertemplates.'.$viewtype, compact('nfts','user'));
                break;
        }
    }
}
