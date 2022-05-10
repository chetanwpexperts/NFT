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

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $db = "";
        $user = Auth::user();
        $creator_id = (!empty($user)) ? $user->creator_id : "";
        $row = array();
        $amount = $request->input('amount');
        $category = $request->input('category');
        $type = $request->input('keyword');
        $nfts = "";
        if($type != "")
        {
            $nfts = $this->getNftByAuction($type);
        }
        $amountarr = "";
        $amount_start = "";
        $amount_end = "";
        if($amount != "")
        {
            $amountarr = explode(" - ", $amount);
            $amount_start = $amountarr[0];
            $amount_end = $amountarr[1];
            
            $nfts = $this->getNftsByPrice($amount_start, $amount_end);
        }
        
        if($category != "")
        {
            $nfts = $this->getNftsByCategory($category);
        }
        return view('innertemplates.search', compact('nfts', 'user', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
    
    function getNftByAuction($type)
    {
        $array = array();
        $array['type'] = $type;
        $nfts = $this->getAllNfts($array);
        return $nfts;
    }
    
    function getNftsByPrice($startPrice, $endPrice)
    {
        $array = array();
        $array['startPrice'] = $startPrice;
        $array['endPrice'] = $endPrice;
        $nfts = $this->getAllNfts($array);
        return $nfts;
    }
    
    public function getNftsByCategory($category)
    {
        $array = array();
        $array['category'] = $category;
        $nfts = $this->getAllNfts($array);
        return $nfts;
    }
    
    public function getAllNfts($array = array())
    {
        $nfts = "";
        $list = array();
        if(!empty($array))
        {
            if(isset($array['type']) && $array['type'] != "")
            {
                $whereArray = array('type' => $array['type'], 'status' => "published", "auction_status" => NULL);
                $query = DB::table('nfts');
                foreach($whereArray as $field => $value) {
                    $query->where($field, $value);
                }
                $nfts = $query->orderByDesc("created_at")->get();
            }else if((isset($array['startPrice']) && $array['startPrice'] != "") && (isset($array['endPrice']) && $array['endPrice'] != ""))
            {
                $query = DB::table('nfts');
                $nfts = $query->orderByDesc("created_at")->where('price', '>=', $array['startPrice'])->where('price', '<=', $array['endPrice'])->get();
            }else if(isset($array['category']) && $array['category'] != "")
            {
                $whereArray = array('category' => $array['category'], 'status' => "published", "auction_status" => NULL);
                foreach($whereArray as $field => $value) {
                    $query->where($field, $value);
                }
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
}
