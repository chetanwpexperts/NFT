@extends('layouts.innerlayout')

@section('content')
<style>
    .tikk{
        background: rgb(195,34,170);
        background: linear-gradient(0deg, rgba(195,34,170,0.7819502801120448) 0%, rgba(245,207,91,1) 100%);
        color: #000000;
        font-size: 18px;
        margin-left: -3px;
        position: relative;
        top: -6px;
        padding: 1px 3px;
        border-radius: 6px;
    }
    .descnft{
        padding-bottom: 1rem;
    }
    .viewallbtn{
        background: linear-gradient(0deg, rgb(73 54 233 / 78%) 0%, rgb(253 112 80) 100%);
        border: none;
        color: #f9f9f9;
        font-weight: 500;
        text-transform: capitalize;
        letter-spacing: 1px;
    }
    #news-slider-2 {
        margin-top: 70px;
    }
    
    .auctionbtnlink{
        background: #f8f8f8;
        color: #404040 !important;
        border-radius: 6px;
        font-size: 12px;
    }
    .demandbtnlink{
        background: #f8f8f8;
       color: #404040 !important;
        border-radius: 6px;
        font-size: 12px;
    }
</style>
<section id="filters">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12">
					<form name="search" method="post" action="{{route('nft.search')}}">
                        @csrf
                        <div class="filter_canvas">
                            <ul>
                                <li>
                                    <div class="filter_box">
                                        <img src="{{ URL::asset('public/assets/img/filter.png'); }}">
                                        <h3>Filters</h3>
                                    </div>
                                </li>
                                <li>
                                    <div class="auction_border">
                                        <a href="#" id="auction" data-val="auction">Auction</a><span style="color:#EECB1C;">|</span><a href="#" id="demand" data-val="demand">Demand Supply</a>
                                        <input type="hidden" name="keyword" id="keyword" />
                                    </div>
                                </li>
                                <li>
                                    <div class="auction_border" style="padding-bottom:0;">
                                        <h4>Price:</h4>
                                        <div class="price_boxx_slider">
                                            <div id="slider-range"></div>
                                            <p class="input_list">
                                                <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                                            </p>
                                        </div>
                                        <input type="hidden" name="amount" id="amounthidden" />
                                    </div>
                                </li>
                                <li>
                                    <select class="form-control" name="category" id="cat">
                                        <option value="">Select Category</option>
                                        <option value="image">Image</option>
                                        <option value="video">Video</option>
                                        <option value="audio">Audio</option>
                                        <option value="script">Script</option>
                                        <option value="story">Story</option>
                                    </select>
                                </li>
                                <li>	
                                    <div class="buttons">
                                        <button class="btn btn-success" type="submit" id="searchbtn"><i class="fa fa-check" aria-hidden="true"></i> Apply</button>
                                        <div class="reset-link"><a href="#">Reset</a></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
					</form>
				</div>
			</div>
		</div>
	</section>

	<!--Inner Section-->
	<section id="inner-page-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="inner-page-title"> 
						<h3><span style="color:#FF5E5B;">Search: </span></h3>
					</div>
				</div>
			</div>
			<div class="row">
            @php
            $x=0;
            $color_array = array('first_boxx', 'second_boxx', 'third_boxx', 'four_boxx');
            $i = 1;
            $class = "";
            if(!empty($nfts))
            {
                foreach($nfts as $nft)
                {
                    $nftfile = asset("storage/app/public/".$nft->file);
                    $goldbadge = asset("storage/app/public/".setting('site.gold_badge'));
                    $purplebadge = asset("storage/app/public/".setting('site.purple_badge'));
                    if($nft->liked == "yes")
                    {
                        $class = "fas fa-heart";
                    }else{
                        $class = "far fa-heart";
                    }
                    $ownerbadge = "";
                    if($nft->owner_badges == "gold")
                    {
                        $ownerbadge = $goldbadge;
                    }else if($nft->owner_badges == "purple"){
                        $ownerbadge = $purplebadge;
                    }
                    $x++;
                    $cls = $color_array[$x%3];
                    @endphp
                    <div class="col-lg-4 col-sm-6 loaddata">
                        <a href="{{route('nft.view', [$nft->nftid])}}" title="{{$nft->title}}" class="nftx" data-nftid="{{$nft->nftid}}" data-rowid="{{$nft->id}}">
                            <div class="{{$cls}}" style="margin-bottom:30px;">
                                <div class="owner-info">
                                    <?php 
                                    if($ownerbadge != "")
                                    {
                                        ?>
                                        <img src="{{$ownerbadge}}" class="img-responsive badgesicon" />
                                        <?php
                                    }
                                    ?>
                                    <h3>{{$nft->owner_name}}

                                    </h3>
                                    <!--fas fa-heart -->
                                    <label for="favourites_{{$i}}"><i class="{{$class}} changeclass favourite" data-number="{{$i}}" data-nftid="{{$nft->nftid}}"></i></label>
                                    <input type="checkbox" class="chk" id="favourites_{{$i}}" name="favourite" value="0" style="display:none;" data-row-check="check_{{$i}}" />

                                </div>
                                <div class="blog_img">
                                    <?php 
                                    $ext = pathinfo($nftfile, PATHINFO_EXTENSION);
                                    switch($ext)
                                    {
                                         case "mp4":
                                         case "flv":
                                         case "mov":
                                            ?> 
                                            <video controls="" style="width:100%;height:100%;background-color:#000000;" autoplay muted controlsList="nodownload">
                                                <source src="{{$nftfile}}" type="video/mp4">
                                            </video>
                                            <?php
                                            break;
                                         case "mp3":
                                            ?>
                                            <img src="{{ URL::asset('public/assets/img/audio.gif'); }}" class="img-responsive" />
                                            <audio controls controlsList="nodownload">
                                                <source src="{{$nftfile}}" type="audio/mpeg">
                                            </audio>
                                            <?php
                                            break;
                                         case "png":
                                            ?>
                                            <img src="{{$nftfile}}" class="img-responsive" />
                                            <?php
                                            break;
                                        case "jpeg":
                                            ?>
                                            <img src="{{$nftfile}}" class="img-responsive" />
                                            <?php
                                            break;
                                        case "jpg":
                                            ?>
                                            <img src="{{$nftfile}}" class="img-responsive" />
                                            <?php
                                            break;
                                    }

                                    ?>
                                </div>
                                <div class="list_info">
                                    <div class="id_badge">
                                        <p>Id_{{$nft->nftid}}</p>
                                    </div>
                                    <div class="creater_info_list">
                                        <?php 
                                        $truncated = Str::limit($nft->title, 6, '...');
                                        $badges = "";
                                        if($nft->creator_badge == "gold")
                                        {
                                            $badges = $goldbadge;
                                        }else if($nft->creator_badge == "purple"){
                                            $badges = $purplebadge;
                                        }
                                        ?>
                                        <h2>{{$truncated}}</h2>
                                        <?php 
                                        if($badges != "")
                                        {
                                            ?>
                                            <img src="{{$badges}}" class="img-responsive" style="width: 20%;position: absolute;left: 21rem;top: -3.5rem;" />
                                            <?php
                                        }
                                        ?>
                                        <p>{{$nft->creator_name}}</p>
                                        <div class="creator_list">
                                            <ul>
                                                <li>
                                                    <?php 
                                                    if($nft->type=="auction")
                                                    {
                                                    ?>
                                                    <div class="auction_icon">
                                                        <img src="{{ URL::asset('public/assets/img/auction-icon.png')}}"/>
                                                    </div>
                                                    <?php 
                                                    }else{
                                                        ?>
                                                        <div class="auction_icon">
                                                            <img src="{{ URL::asset('public/assets/dashboard/images/van.png')}}"/>
                                                        </div>
                                                        <?php 
                                                    }
                                                    ?>
                                                </li>
                                                <li>
                                                    <h4 class="auction_view_title">on Auction</h4>
                                                    <?php 
                                                    $daysLeft = ($nft->days_left != "") ? $nft->days_left : "Live";
                                                    ?>
                                                    <p class="auction_day">{{$daysLeft}}</p>
                                                </li>
                                                <li>
                                                    <h4 class="auction_view_title"><img src="{{ URL::asset('public/assets/img/inr.png')}}" style="width:8px; margin-right:3px;">{{$nft->heighest_bid}}</h4>
                                                    <p class="auction_day">Current Bid</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="descnft">
                                    <?php $desc = Str::limit($nft->tags, 30, '...'); ?>
                                    <p>{{$desc}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @php
                    $i++;
                }
            }else{
                @endphp
                <div class="col-lg-12">
                    <h5 style="color: #f9f9f9; font-size: 3rem;"> Sorry, No Nft Found!</h5>
                </div>
            @php
            }
            @endphp
			</div>
		</div>
	</section>
@endsection