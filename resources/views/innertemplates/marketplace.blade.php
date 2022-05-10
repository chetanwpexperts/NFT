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
	.iframe{
	background-color:#000;
	}
    .loaddata {
        display:none;
    }
    .auctionbtnlink {
		background: #f8f8f8;
		color: #404040 !important;
		border-radius: 6px;
		font-size: 14px;
		padding: 1px 6px !important;
		margin-right: 8px;
	}
    .demandbtnlink{
        background: #f8f8f8;
       color: #404040 !important;
        border-radius: 6px;
        font-size: 14px;
		padding: 1px 6px !important;
		margin-right: 8px;
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
                                    <div class="auction_border" style="padding-bottom:0; padding-left:0;">
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
	
	
    <!--Celebs Section-->
	<section id="trending-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="trend-list">
						<div class="trend-title wow fadeInLeft">
							<h3>Verified <span class="tikk"><i class="fa fa-check" aria-hidden="true"></i></span></h3>
							<p>NFTs of the Week</p>
                            <?php if(!empty($verifiedNfts)){ ?>
                            <div class="viewall"><a class="btn btn-default viewallbtn" href="{{route('view.all', ['verified'])}}"><?php echo 'View All';?></a></div>
                            <?php }else{ echo "";}?>
						</div>
						<div class="slider_boxx wow fadeInRight">
							<div id="news-slider" class="owl-carousel">
                                @php
                                $x=0;
                                $color_array = array('first_boxx', 'second_boxx', 'third_boxx', 'four_boxx');
                                $i = 1;
                                $class = "";
                                foreach($verifiedNfts as $verified)
                                {
                                    if($verified->auction_status != "sold")
                                    {
                                        $nftfile = asset("storage/app/public/".$verified->file);
                                        $goldbadge = asset("storage/app/public/".setting('site.gold_badge'));
                                        $purplebadge = asset("storage/app/public/".setting('site.purple_badge'));
                                        if($verified->liked == "yes")
                                        {
                                            $class = "fas fa-heart";
                                        }else{
                                            $class = "far fa-heart";
                                        }
                                        $ownerbadge = "";
                                        if($verified->owner_badges == "gold")
                                        {
                                            $ownerbadge = $goldbadge;
                                        }else if($verified->owner_badges == "purple"){
                                            $ownerbadge = $purplebadge;
                                        }
                                        $x++;
                                        $cls = $color_array[$x%3];
                                        @endphp
                                        <div class="post-slide">
                                            <a href="{{route('nft.view', [$verified->nftid])}}" title="{{$verified->title}}" class="nftx" data-nftid="{{$verified->nftid}}" data-rowid="{{$verified->id}}">
                                                <div class="{{$cls}}">
                                                    <div class="owner-info">
                                                        <?php 
                                                        if($ownerbadge != "")
                                                        {
                                                            ?>
                                                            <img src="{{$ownerbadge}}" class="img-responsive badgesicon" />
                                                            <?php
                                                        }
                                                        ?>
                                                        <h3>{{$verified->owner_name}}

                                                        </h3>
                                                        <!--fas fa-heart -->
                                                        <label for="favourites_{{$i}}"><i class="{{$class}} changeclass favourite" data-number="{{$i}}" data-nftid="{{$verified->nftid}}"></i></label>
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
                                                                <img src="{{ URL::asset('public/assets/img/audio_clip_img.jpg'); }}" class="img-responsive" />
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
                                                            case "gif":
                                                                ?>
                                                                <img src="{{$nftfile}}" class="img-responsive" />
                                                                <?php
                                                                break;
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="list_info">
                                                        <div class="id_badge">
                                                            <p>Id_{{$verified->nftid}}</p>
                                                        </div>
                                                        <div class="creater_info_list">
                                                            <?php 
                                                            $truncated = Str::limit($verified->title, 6, '...');
                                                            $badges = "";
                                                            if($verified->creator_badge == "gold")
                                                            {
                                                                $badges = $goldbadge;
                                                            }else if($verified->creator_badge == "purple"){
                                                                $badges = $purplebadge;
                                                            }
                                                            ?>
                                                            <h2>{{$truncated}}</h2>
                                                            <?php 
                                                            if($badges != "")
                                                            {
                                                                ?>
                                                                <img src="{{$badges}}" class="img-responsive img_tick"/>
                                                                <?php
                                                            }
                                                            ?>
                                                            <p>{{$verified->creator_name}}</p>
                                                            <div class="creator_list">
                                                                <ul>
                                                                    <li>
                                                                        <?php
                                                                        $type = "";
                                                                        if($verified->type=="auction")
                                                                        {
                                                                            $type = "Auction";
                                                                        ?>
                                                                        <div class="auction_icon">
                                                                            <img src="{{ URL::asset('public/assets/img/auction-icon.png')}}"/>
                                                                        </div>
                                                                        <?php 
                                                                        }else{
                                                                            $type = "Demand";
                                                                            ?>
                                                                            <div class="auction_icon">
                                                                                <img src="{{ URL::asset('public/assets/dashboard/images/van.png')}}"/>
                                                                            </div>
                                                                            <?php 
                                                                        }
                                                                        ?>
                                                                    </li>
                                                                    <li>
                                                                        <h4 class="auction_view_title">on {{$type}}</h4>
                                                                        <?php 
                                                                        $daysLeft = ($verified->days_left != "") ? $verified->days_left : "Live";
                                                                        ?>
                                                                        <p class="auction_day">{{$daysLeft}}</p>
                                                                    </li>
                                                                    <li>
                                                                        <h4 class="auction_view_title"><img src="{{ URL::asset('public/assets/img/inr.png')}}" style="width:8px; margin-right:3px;">{{$verified->heighest_bid}}</h4>
                                                                        <p class="auction_day">Current Bid</p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="descnft">
                                                        <?php $desc = Str::limit($verified->tags, 30, '...'); ?>
                                                        <p>{{$desc}}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        @php
                                    }
                                    $i++;
                                }
                                @endphp
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


    <!--Trending Section-->
	<section id="trending-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="trend-list">
						<div class="trend-title wow fadeInLeft">
							<h3>Trending</h3>
							<p>NFTs of the Week</p>
                            <?php if(!empty($trendingNfts)){ ?>
                            <div class="viewall"><a class="btn btn-default viewallbtn" href="{{route('view.all', ['trending'])}}"><?php echo 'View All';?></a></div>
                            <?php }else{ echo "";}?>
						</div>
						<div class="slider_boxx wow fadeInRight">
							<div id="news-slider-1" class="owl-carousel">
                                @php
                                $x=0;
                                $color_array = array('first_boxx', 'second_boxx', 'third_boxx', 'four_boxx');
                                $i = 1;
                                $class = "";
                                foreach($trendingNfts as $trending)
                                {
                                    if($trending->auction_status != "sold")
                                    {
                                        $nftfile = asset("storage/app/public/".$trending->file);
                                        $goldbadge = asset("storage/app/public/".setting('site.gold_badge'));
                                        $purplebadge = asset("storage/app/public/".setting('site.purple_badge'));
                                        if($trending->liked == "yes")
                                        {
                                            $class = "fas fa-heart";
                                        }else{
                                            $class = "far fa-heart";
                                        }
                                        $ownerbadge = "";
                                        if($trending->owner_badges == "gold")
                                        {
                                            $ownerbadge = $goldbadge;
                                        }else if($trending->owner_badges == "purple"){
                                            $ownerbadge = $purplebadge;
                                        }
                                        $x++;
                                        $cls = $color_array[$x%3];
                                        @endphp
                                        <div class="post-slide">
                                            <a href="{{route('nft.view', [$trending->nftid])}}" title="{{$trending->title}}" class="nftx" data-nftid="{{$trending->nftid}}" data-rowid="{{$trending->id}}">
                                                <div class="{{$cls}}">
                                                    <div class="owner-info">
                                                        <?php 
                                                        if($ownerbadge != "")
                                                        {
                                                            ?>
                                                            <img src="{{$ownerbadge}}" class="img-responsive badgesicon" />
                                                            <?php
                                                        }
                                                        ?>
                                                        <h3>{{$trending->owner_name}}

                                                        </h3>
                                                        <!--fas fa-heart -->
                                                        <label for="favourites_{{$i}}"><i class="{{$class}} changeclass favourite" data-number="{{$i}}" data-nftid="{{$trending->nftid}}"></i></label>
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
                                                                <img src="{{ URL::asset('public/assets/img/audio_clip_img.jpg'); }}" class="img-responsive" />
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
                                                            case "gif":
                                                                ?>
                                                                <img src="{{$nftfile}}" class="img-responsive" />
                                                                <?php
                                                                break;
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="list_info">
                                                        <div class="id_badge">
                                                            <p>Id_{{$trending->nftid}}</p>
                                                        </div>
                                                        <div class="creater_info_list">
                                                            <?php 
                                                            $truncated = Str::limit($trending->title, 6, '...');
                                                            $badges = "";
                                                            if($trending->creator_badge == "gold")
                                                            {
                                                                $badges = $goldbadge;
                                                            }else if($trending->creator_badge == "purple"){
                                                                $badges = $purplebadge;
                                                            }
                                                            ?>
                                                            <h2>{{$truncated}}</h2>
                                                            <?php 
                                                            if($badges != "")
                                                            {
                                                                ?>
                                                                <img src="{{$badges}}" class="img-responsive img_tick"/>
                                                                <?php
                                                            }
                                                            ?>
                                                            <p>{{$trending->creator_name}}</p>
                                                            <div class="creator_list">
                                                                <ul>
                                                                    <li>
                                                                        <?php 
                                                                        $type = "";
                                                                        if($trending->type=="auction")
                                                                        {
                                                                            $type = "Auction";
                                                                        ?>
                                                                        <div class="auction_icon">
                                                                            <img src="{{ URL::asset('public/assets/img/auction-icon.png')}}"/>
                                                                        </div>
                                                                        <?php 
                                                                        }else{
                                                                            $type = "Demand";
                                                                            ?>
                                                                            <div class="auction_icon">
                                                                                <img src="{{ URL::asset('public/assets/dashboard/images/van.png')}}"/>
                                                                            </div>
                                                                            <?php 
                                                                        }
                                                                        ?>
                                                                    </li>
                                                                    <li>
                                                                        <h4 class="auction_view_title">on {{$type}}</h4>
                                                                        <?php 
                                                                        $daysLeft = ($trending->days_left != "") ? $trending->days_left : "Live";
                                                                        ?>
                                                                        <p class="auction_day">{{$daysLeft}}</p>
                                                                    </li>
                                                                    <li>
                                                                        <h4 class="auction_view_title"><img src="{{ URL::asset('public/assets/img/inr.png')}}" style="width:8px; margin-right:3px;">{{$trending->heighest_bid}}</h4>
                                                                        <p class="auction_day">Current Bid</p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="descnft">
                                                        <?php $desc = Str::limit($trending->tags, 30, '...'); ?>
                                                        <p>{{$desc}}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        @php
                                    }
                                    $i++;
                                }
                                @endphp
                                
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

    <!--Favourite Section-->
	<section id="trending-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="trend-list">
						<div class="trend-title wow fadeInLeft">
							<h3>Most Liked</h3>
							<p>NFTs of the Week</p>
                            <?php if(!empty($mostviewdNfts)){ ?>
                            <div class="viewall"><a class="btn btn-default viewallbtn" href="{{route('view.all', ['mostliked'])}}"><?php echo 'View All';?></a></div>
                            <?php }else{ echo "";}?>
						</div>
						<div class="slider_boxx wow fadeInRight">
							<div id="news-slider-2" class="owl-carousel">
                                @php
                                $x=0;
                                $color_array = array('first_boxx', 'second_boxx', 'third_boxx', 'four_boxx');
                                $i = 1;
                                $class = "";
                                foreach($mostviewdNfts as $mostviewd)
                                {
                                    if($mostviewd->auction_status != "sold")
                                    {
                                        $nftfile = asset("storage/app/public/".$mostviewd->file);
                                        $goldbadge = asset("storage/app/public/".setting('site.gold_badge'));
                                        $purplebadge = asset("storage/app/public/".setting('site.purple_badge'));
                                        if($mostviewd->liked == "yes")
                                        {
                                            $class = "fas fa-heart";
                                        }else{
                                            $class = "far fa-heart";
                                        }
                                        $ownerbadge = "";
                                        if($mostviewd->owner_badges == "gold")
                                        {
                                            $ownerbadge = $goldbadge;
                                        }else if($mostviewd->owner_badges == "purple"){
                                            $ownerbadge = $purplebadge;
                                        }
                                        $x++;
                                        $cls = $color_array[$x%3];
                                        @endphp
                                        <div class="post-slide">
                                            <a href="{{route('nft.view', [$mostviewd->nftid])}}" title="{{$mostviewd->title}}" class="nftx" data-nftid="{{$mostviewd->nftid}}" data-rowid="{{$mostviewd->id}}">
                                                <div class="{{$cls}}">
                                                    <div class="owner-info">
                                                        <?php 
                                                        if($ownerbadge != "")
                                                        {
                                                            ?>
                                                            <img src="{{$ownerbadge}}" class="img-responsive badgesicon" />
                                                            <?php
                                                        }
                                                        ?>
                                                        <h3>{{$mostviewd->owner_name}}

                                                        </h3>
                                                        <!--fas fa-heart -->
                                                        <label for="favourites_{{$i}}"><i class="{{$class}} changeclass favourite" data-number="{{$i}}" data-nftid="{{$mostviewd->nftid}}"></i></label>
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
                                                                <img src="{{ URL::asset('public/assets/img/audio_clip_img.jpg'); }}" class="img-responsive" />
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
                                                            case "gif":
                                                                ?>
                                                                <img src="{{$nftfile}}" class="img-responsive" />
                                                                <?php
                                                                break;
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="list_info">
                                                        <div class="id_badge">
                                                            <p>Id_{{$mostviewd->nftid}}</p>
                                                        </div>
                                                        <div class="creater_info_list">
                                                            <?php 
                                                            $truncated = Str::limit($mostviewd->title, 6, '...');
                                                            $badges = "";
                                                            if($mostviewd->creator_badge == "gold")
                                                            {
                                                                $badges = $goldbadge;
                                                            }else if($mostviewd->creator_badge == "purple"){
                                                                $badges = $purplebadge;
                                                            }
                                                            ?>
                                                            <h2>{{$truncated}}</h2>
                                                            <?php 
                                                            if($badges != "")
                                                            {
                                                                ?>
                                                                <img src="{{$badges}}" class="img-responsive img_tick"/>
                                                                <?php
                                                            }
                                                            ?>
                                                            <p>{{$mostviewd->creator_name}}</p>
                                                            <div class="creator_list">
                                                                <ul>
                                                                    <li>
                                                                        <?php 
                                                                        $type = "";
                                                                        if($mostviewd->type=="auction")
                                                                        {
                                                                            $type = "Auction";
                                                                        ?>
                                                                        <div class="auction_icon">
                                                                            <img src="{{ URL::asset('public/assets/img/auction-icon.png')}}"/>
                                                                        </div>
                                                                        <?php 
                                                                        }else{
                                                                            $type = "Demand";
                                                                            ?>
                                                                            <div class="auction_icon">
                                                                               <img src="{{ URL::asset('public/assets/dashboard/images/van.png')}}"/>
                                                                            </div>
                                                                            <?php 
                                                                        }
                                                                        ?>
                                                                    </li>
                                                                    <li>
                                                                        <h4 class="auction_view_title">on {{$type}}</h4>
                                                                        <?php 
                                                                        $daysLeft = ($mostviewd->days_left != "") ? $mostviewd->days_left : "Live";
                                                                        ?>
                                                                        <p class="auction_day">{{$daysLeft}}</p>
                                                                    </li>
                                                                    <li>
                                                                        <h4 class="auction_view_title"><img src="{{ URL::asset('public/assets/img/inr.png')}}" style="width:8px; margin-right:3px;">{{$mostviewd->heighest_bid}}</h4>
                                                                        <p class="auction_day">Current Bid</p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="descnft">
                                                        <?php $desc = Str::limit($mostviewd->tags, 30, '...'); ?>
                                                        <p>{{$desc}}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        @php
                                    }
                                    $i++;
                                }
                                @endphp
                               
							</div>
						</div>
					</div>
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
						<h3><span style="color:#FF5E5B;">Discover</span>, <span style="color:#7D30FF;">collect</span>, and <span style="color:#140BF3;">sell</span> extraordinary NFTs</h3>
                        <?php if(!empty($nfts)){ ?>
                        <div class="viewall"><a class="btn btn-default viewallbtn" href="{{route('view.all', ['others'])}}"><?php echo 'View All';?></a></div>
                        <?php }else{ echo "";}?>
					</div>
				</div>
			</div>
			<div class="row">
                @php
                $x=0;
                $color_array = array('first_boxx', 'second_boxx', 'third_boxx', 'four_boxx');
                $i = 1;
                $class = "";
                foreach($nfts as $nft)
                {
                    if($nft->auction_status != "sold")
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
                            <div class="{{$cls}}">
                                <div class="owner-info-list">
                                    <?php 
                                    if($ownerbadge != "")
                                    {
                                        ?>
                                        <img src="{{$ownerbadge}}" class="img-responsive badgesicon" />
                                        <?php
                                    }
                                    ?>
                                    <h3>{{$nft->owner_name}}</h3>
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
                                        <img src="{{ URL::asset('public/assets/img/audio_clip_img.jpg'); }}" class="img-responsive" />
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
                                    case "gif":
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
                                            <img src="{{$badges}}" class="img-responsive img_tick"/>
                                            <?php
                                        }
                                        ?>
                                        <p>{{$nft->creator_name}}</p>
                                        <div class="creator_list">
                                            <ul>
                                                <li>
                                                    <?php 
                                                    $type = "";
                                                    if($nft->type=="auction")
                                                    {
                                                        $type = "Auction";
                                                    ?>
                                                    <div class="auction_icon">
                                                        <img src="{{ URL::asset('public/assets/img/auction-icon.png')}}"/>
                                                    </div>
                                                    <?php 
                                                    }else{
                                                        $type = "Demand";
                                                        ?>
                                                        <div class="auction_icon">
                                                            <img src="{{ URL::asset('public/assets/dashboard/images/van.png')}}"/>
                                                        </div>
                                                        <?php 
                                                    }
                                                    ?>
                                                </li>
                                                <li>
                                                    <h4 class="auction_view_title">on {{$type}}</h4>
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
                    }
                    $i++;
                }
                @endphp
            </div>
		</div>
	</section>

@endsection