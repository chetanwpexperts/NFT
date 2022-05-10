<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NFT</title>
    <meta name="google-site-verification" content="K5lvzr81kRI2jSZo27EsZ1zUwiWWJMftO6mOnl15XOw" />
    <link rel="stylesheet" href="{{ URL::asset('public/assets/dashboard/plugins/fontawesome-free/css/all.min.css'); }}">
    <!--CSS-->
    <link href="{{ URL::asset('public/assets/css/bootstrap.min.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/animate.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/style.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/responsive.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/font-awesome.min.css'); }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
    <link href="{{ URL::asset('public/assets/css/homepage.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/nft.css'); }}" rel="stylesheet">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-BBJ0SR0TTS"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-BBJ0SR0TTS');
    </script>
  </head>
  <body class="bg" onmousedown="return false" onselectstart="return false">
      <div id="loader-wrapper">
  			<div id="loader"></div>

  			<div class="loader-section section-left"></div>
              <div class="loader-section section-right"></div>

  		</div>
  	<!--Header-Banner-Section-->
	<!--Mobile-header-Section-->
	<section id="mob_section">

		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-sm-3">
					<div class="logo-div">
						<a href="{{ url('/') }}">
						<img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/> </a>
					</div>
				</div>
				<div class="col-lg-9 col-sm-9">

					<div class="top-links fullwidth">
						<ul>
							<li><a href="{{route('nft.marketplace')}}">Marketplace</a></li>
                            @if (Auth::guest())
                                <li><a href="{{ route('login') }}"><u>Sign In</u></a></li>
                            @else
                                <li>
                                    <div class="dropdown">
                                        <a class="btn dropdown-toggle" href="javascipt:void(0);" id="dropdownMenu1" data-toggle="dropdown">
                                        <?php 
                                        $avatar = $user->dp;
                                        if($avatar == "")
                                        {
                                            $avatar = "users/default.png";
                                        }
                                        $user_avatar = asset("storage/app/public/".$avatar);  
                                        ?>
                                        <img src="{{$user_avatar}}" width="30%" style="border-radius:50%;"> {{$user->name}}
                                        </a>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            <li><a href="{{ route('auth.dashboard') }}"><i class="icon-envelope icon-large"></i>Dashboard</a></li>
                                            <li><a href="{{ route('nft.favourites') }}"><i class="icon-envelope icon-large"></i>Favourite NFTs</a></li>
                                            <li><a href="{{ route('logout') }}"><i class="icon-truck icon-large"></i>Logout</a></li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
							<li>
								<p class="searchBtnTop search-trigger">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<div class="banner-info wow fadeInLeft">
						<h3><span class="orange-clr">CREATE</span> <span class="purple-clr">DISCOVER</span> <span class="blue-clr">COLLECT Or Sell NFTs</span></h3>
						<p>on the world's first & largest NFT marketplace All in <i class="fa fa-inr" aria-hidden="true"></i></p>
						<div class="btn_boxx">
							<a href="{{route('login')}}" class="buy_btn">Buy & Sell</a>
							<a href="{{route('login')}}" class="create_btn">Create</a>
						</div>
						<div class="scroll_down">
							<a class="down" href="#trending-section"><img src="{{ URL::asset('public/assets/img/scroll-down.png'); }}" class="img-responsive"/></a>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="banner-user wow fadeInRight">
						<img src="{{ URL::asset('public/assets/img/hero-illustration.png'); }}" class="img-responsive"/>
					</div>
				</div>
			</div>
		</div>
	</section>



	<!--Desktop-header-Section-->
	<section id="top-section">
		<div class="header_left">
			<div class="logo-div">
				<a href="{{ url('/') }}">
				<img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/> </a>
			</div>
		</div>
		<div class="header_right">
			<div class="top-links">
                <ul>
                    <li><a href="{{route('nft.marketplace')}}">Marketplace</a></li>
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}"><u>Sign In</u></a></li>
                    @else
                        <li>
                            <div class="dropdown">
                                <a class="btn dropdown-toggle" href="javascipt:void(0);" id="dropdownMenu1" data-toggle="dropdown">
                                <?php 
                                $avatar = $user->dp;
                                if($avatar == "")
                                {
                                    $avatar = "users/default.png";
                                }
                                $user_avatar = asset("storage/app/public/".$avatar);  
                                ?>
                                <img src="{{$user_avatar}}" style="border-radius:50%;"> {{$user->name}}
                                </a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="{{ route('auth.dashboard') }}"><i class="icon-envelope icon-large"></i>Dashboard</a></li>
                                    <li><a href="{{ route('nft.favourites') }}"><i class="icon-envelope icon-large"></i>Favourite NFTs</a></li>
                                    <li><a href="{{ route('logout') }}"><i class="icon-truck icon-large"></i>Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
		</div>
		<div class="container" style="clear:both;">
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<div class="banner-info wow fadeInLeft">
						<h3><span class="orange-clr">CREATE</span> <br><span class="purple-clr">DISCOVER</span><br><span class="blue-clr">COLLECT OR <br />SELL NFT's</span></h3>
						<p>on the world's first & largest NFT marketplace, ALL in <i class="fa fa-inr" aria-hidden="true"></i></p>
						<div class="btn_boxx">
							<a href="{{route('login')}}" class="buy_btn">Buy & Sell</a>
							<a href="{{route('login')}}" class="create_btn">Create</a>
						</div>
						<div class="scroll_down">
							<a class="down" href="#trending-section"><img src="{{ URL::asset('public/assets/img/scroll-down.png'); }}" class="img-responsive"/></a>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="banner-user wow fadeInRight">
						<img src="{{ URL::asset('public/assets/img/hero-illustration.png'); }}" class="img-responsive"/>
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
							<img src="{{ URL::asset('public/assets/img/trend-icon.png'); }}" class="img-responsive"/>
							<h3>Trending</h3>
							<p>NFTs of the Week</p>
						</div>
						<div class="slider_boxx wow fadeInRight">
							<div id="news-slider" class="owl-carousel">
                                <?php 
                               // echo "<pre>";
                                // print_r($recentNfts);
                                ?>
                                @php
                                $x=0;
                                $color_array = array('first_boxx', 'second_boxx', 'third_boxx', 'four_boxx');
                                $i = 1;
                                $class = "";
                                foreach($recentNfts as $recntnft)
                                {
                                    if($recntnft->auction_status != "sold")
                                    {
                                        $nftfile = asset("storage/app/public/".$recntnft->file);
                                        $goldbadge = asset("storage/app/public/".setting('site.gold_badge'));
                                        $purplebadge = asset("storage/app/public/".setting('site.purple_badge'));
                                        if(!empty($user) && $recntnft->is_favourite == 1)
                                        {
                                            $class = "fas fa-heart";
                                        }else{
                                            $class = "far fa-heart";
                                        }
                                        $badge = "";
                                        if($recntnft->owner_badges == "gold")
                                        {
                                            $badge = $goldbadge;
                                        }else if($recntnft->owner_badges == "purple"){
                                            $badge = $purplebadge;
                                        }
                                        $x++;
                                        $cls = $color_array[$x%3];
                                        @endphp
                                        <div class="post-slide">
                                            <a href="{{route('nft.view', [$recntnft->nftid])}}" title="{{$recntnft->title}}" class="nftx" data-nftid="{{$recntnft->nftid}}" data-rowid="{{$recntnft->id}}">
                                                <div class="{{$cls}}">
                                                    <div class="owner-info">
                                                        <?php 
                                                        if($badge != "")
                                                        {
                                                            ?>
                                                            <img src="{{$badge}}" class="img-responsive badgesicon" />
                                                            <?php
                                                        }
                                                        ?>
                                                        <h3>{{$recntnft->owner_name}}</h3>
                                                        <!--fas fa-heart -->
                                                        <label for="favourites_{{$i}}"><i class="{{$class}} changeclass favourite" data-number="{{$i}}" data-nftid="{{$recntnft->nftid}}"></i></label>
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
                                                            case "gif":
                                                            case "webp":
                                                                ?>
                                                                <img src="{{$nftfile}}" class="img-responsive" />
                                                                <?php
                                                                break;
                                                        }

                                                        ?>
                                                    </div>
                                                    <div class="list_info">
                                                        <div class="id_badge">
                                                            <p>Id_{{$recntnft->nftid}}</p>
                                                        </div>
                                                        <div class="creater_info_list">
                                                            <?php 
                                                            $truncated = Str::limit($recntnft->title, 6, '...');
                                                            $badges = "";
                                                            if($recntnft->creator_badge == "gold")
                                                            {
                                                                $badges = $goldbadge;
                                                            }else if($recntnft->creator_badge == "purple"){
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
                                                            <p>{{$recntnft->creator_name}}</p>
                                                             
                                                            <!--<ul class="tags">
                                                                @php
                                                                $tags = explode(",", $recntnft->tags);
                                                                foreach($tags as $tag)
                                                                {
                                                                @endphp
                                                                <li>
                                                                    <div class="tag_div">
                                                                        <a>{{$tag}}</a>
                                                                    </div>
                                                                </li>
                                                                @php
                                                                }
                                                                @endphp
                                                            </ul>-->
                                                        </div>
                                                        
                                                        <div class="descnft">
                                                            <p><?php
                                                                echo $desc = Str::limit($recntnft->tags, 30, '...');
                                                                ?></p>
                                                            </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        @php
                                        $i++;
                                    }
                                }
                                @endphp
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!--sell & earn Section-->
	<section id="sell-earn-section">
		<div class="left_section sell_desk_img">
			<div class="sell_imgs wow fadeInLeft">

			</div>
		</div>
		<div class="right_section wow fadeInRight">
			<div class="trend-title-create">
				<img src="{{ URL::asset('public/assets/img/create-icon.png'); }}" class="img-responsive"/>
				<h3>Create</h3>
				<p>Sell and Earn</p>

			</div>
			<div class="detail_boxx">
				<p class="description">NFT-X provides our talented Indian Artists a direct platform for making their art as marketable assets.
                NFT-X provides platform for creation of NFT’s and also a marketplace where these NFT’s can be bought and sold.
                NFT-X requires Zero Coding Knowledge and Zero Cryptocurrencies (Works totally in ₹)</p>
				<div class="start_btn">
					<a href="{{ url('/registration') }}" class="create_btn">Start Now</a>
				</div>
			</div>
		</div>

		<!--Mobile-View-Section-->
		<div class="left_section sell_img_on">
			<div class="sell_imgs wow fadeInLeft">
				<img src="{{ URL::asset('public/assets/img/sell-img.png'); }}" class="img-responsive"/>
			</div>
		</div>

	</section>


	<!--Valued Section-->
	<section id="valued-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="trend-list">
						<div class="trend-title wow fadeInLeft">
							<h3>Most Valued</h3>
							<p>NFTs of the Week</p>
						</div>
						<div class="slider_boxx wow fadeInRight">
							<div id="news-slider-1" class="owl-carousel">
                                @php
                                $x=0;
                                $color_array = array('first_boxx', 'second_boxx', 'third_boxx', 'four_boxx');
                                $i = 1;
                                $class = "";
                                foreach($trending as $trendng)
                                {
                                    $nftfile = asset("storage/app/public/".$trendng->file);
                                    $goldbadge = asset("storage/app/public/".setting('site.gold_badge'));
                                    $purplebadge = asset("storage/app/public/".setting('site.purple_badge'));
                                    if($trendng->liked == "yes")
                                    {
                                        $class = "fas fa-heart";
                                    }else{
                                        $class = "far fa-heart";
                                    }
                                    $ownerbadge = "";
                                    if($trendng->owner_badges == "gold")
                                    {
                                        $ownerbadge = $goldbadge;
                                    }else if($trendng->owner_badges == "purple"){
                                        $ownerbadge = $purplebadge;
                                    }
                                    $x++;
                                    $cls = $color_array[$x%3];
                                    @endphp
                                    <div class="post-slide">
                                        <a href="{{route('nft.view', [$trendng->nftid])}}" title="{{$trendng->title}}" class="nftx" data-nftid="{{$trendng->nftid}}" data-rowid="{{$trendng->id}}">
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
                                                    <h3>{{$trendng->owner_name}}

                                                    </h3>
                                                    <!--fas fa-heart -->
                                                    <label for="favourites_{{$i}}"><i class="{{$class}} changeclass favourite" data-number="{{$i}}" data-nftid="{{$trendng->nftid}}"></i></label>
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
                                                        case "gif":
                                                        case "webp":
                                                            ?>
                                                            <img src="{{$nftfile}}" class="img-responsive" />
                                                            <?php
                                                            break;
                                                    }

                                                    ?>
                                                </div>
                                                <div class="list_info">
                                                    <div class="id_badge">
                                                        <p>Id_{{$trendng->nftid}}</p>
                                                    </div>
                                                    <div class="creater_info_list">
                                                        <?php 
                                                        $truncated = Str::limit($trendng->title, 6, '...');
                                                        $badges = "";
                                                        if($trendng->creator_badge == "gold")
                                                        {
                                                            $badges = $goldbadge;
                                                        }else if($trendng->creator_badge == "purple"){
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
                                                        <p>{{$trendng->creator_name}}</p>
                                                        <div class="creator_list">
                                                            <ul>
                                                                <li>
                                                                    <?php
                                                                    $tyype = "";
                                                                    if($trendng->type=="auction")
                                                                    {
                                                                        $tyype = "Auction";
                                                                    ?>
                                                                    <div class="auction_icon">
                                                                        <img src="{{ URL::asset('public/assets/img/auction-icon.png')}}"/>
                                                                    </div>
                                                                    <?php 
                                                                    }else{
                                                                        $tyype = "Demand";
                                                                        ?>
                                                                        <div class="auction_icon">
                                                                            <img src="{{ URL::asset('public/assets/dashboard/images/van.png')}}"/>
                                                                        </div>
                                                                        <?php 
                                                                    }
                                                                    ?>
                                                                </li>
                                                                <li>
                                                                    <h4 class="auction_view_title">on {{$tyype}}</h4>
                                                                    <?php 
                                                                    $daysLeft = ($trendng->days_left != "") ? $trendng->days_left : "Live";
                                                                    ?>
                                                                    <p class="auction_day">{{$daysLeft}}</p>
                                                                </li>
                                                                <li>
                                                                    <h4 class="auction_view_title"><img src="{{ URL::asset('public/assets/img/inr.png')}}" style="width:8px; margin-right:3px;">{{$trendng->heighest_bid}}</h4>
                                                                    <p class="auction_day">Current Bid</p>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="descnft">
                                                    <?php $desc = Str::limit($trendng->tags, 30, '...'); ?>
                                                    <p>{{$desc}}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    @php
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

	<!--Footer Section-->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-sm-6 desk_off">
					<div class="footer-logo">
						<img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/>
					</div>
					<div class="footer-content">
						<p>The world’s first and largest digital marketplace for crypto collectibles and non-fungible tokens (NFTs). Buy, sell, and discover exclusive digital assets.</p>
					</div>
					<div class="social_connect">
						<h4>Social Connectivity</h4>
					</div>
					<div class="social_links">
						<ul>
							<li>
                                <a href="https://www.instagram.com/nftx_india/"><img src="{{ URL::asset('public/assets/img/instagram.png'); }}"/></a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/company/nft-x"><img src="{{ URL::asset('public/assets/img/linkedin_icon.png'); }}"/></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/nftxindia"><img src="{{ URL::asset('public/assets/img/twitter_icon.png'); }}"/></a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/nftxindia/"><img src="{{ URL::asset('public/assets/img/facebook.png'); }}"/></a>
                            </li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="footer-link-title">
						<div class="social_connect-1">
							<h4>Other Pages</h4>
						</div>
						<ul>
							<li><a href="javascript:void(0);">Blog</a></li>
                            <li><a href="{{route('nft.about')}}">About</a></li>
							<li><a href="{{route('nft.contact')}}">Contact</a></li>
                            <li><a href="{{route('nft.refundcancelation')}}">Refund & Cancelation Policy</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6 mob_on">
					<div class="footer-logo">
						<img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/>
					</div>
					<div class="footer-content">
						<p>The world’s first and largest digital marketplace for crypto collectibles and non-fungible tokens (NFTs). Buy, sell, and discover exclusive digital assets.</p>
					</div>
					<div class="social_links">
						<ul>
							<li>
                                <a href="https://www.instagram.com/nftx_india/"><img src="{{ URL::asset('public/assets/img/instagram.png'); }}"/></a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/company/nft-x"><img src="{{ URL::asset('public/assets/img/linkedin_icon.png'); }}"/></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/nftxindia"><img src="{{ URL::asset('public/assets/img/twitter_icon.png'); }}"/></a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/nftxindia/"><img src="{{ URL::asset('public/assets/img/facebook.png'); }}"/></a>
                            </li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="footer-link-title cat_mob">
						<div class="social_connect-2">
							<h4>Important Links</h4>
						</div>
						<ul>
                            <li><a href="{{ url('/registration') }}">Sign Up</a></li>
                            <li><a href="{{ route('nft.faq') }}">FAQ</a></li>
                            <li><a href="{{route('nft.marketplace')}}">Marketplace</a></li>
							<li><a href="{{route('nft.refundcancelation')}}">Refund & Cancelation Policy</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<div id="copyright_div">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-sm-6">
				     <div class="copyright_text">
						<p>2021 - 2022 NFT-X - INVI India Pvt. Ltd.</p>
                        <p>Designed & Developed By <font color="#339f3b">Webtenor Apps</font></p>
					 </div>
				</div>
				<div class="col-lg-6 col-sm-6">
				     <div class="copyright_text_links">
						<ul>
							<li><a href="{{route('nft.ppolicy')}}">Privacy Policy</a></li>
							<li><a href="{{route('nft.terms')}}">Terms & Conditions</a></li>
						</ul>
					 </div>
				</div>
			</div>
		</div>
	</div>

	<!--Back to top-->
	<div class="scroll-top-wrapper ">
	  <span class="scroll-top-inner">
		<i class="fa fa-2x fa-arrow-circle-up"></i>
	  </span>
	</div>


	<!-- SEARCH MODAL BOX START HERE -->
    <div class="search-form-wrapper">
        <div class="search-trigger close-btn">
            <span></span>
            <span></span>
        </div>
        <form class="search-form" method="post">
            <input type="text" placeholder="Search..." value="">
            <button type="submit" class="search-btn">
            <i class="flaticon-magnifying-glass"></i>
            </button>
        </form>
    </div>
    <!-- SEARCH MODAL BOX END HERE -->


    <!--jQuery-->
        <script src="{{ URL::asset('public/assets/js/jquery.js'); }}"></script>
        <script src="{{ URL::asset('public/assets/js/bootstrap.min.js'); }}"></script>
    	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
    	<script src="{{ URL::asset('public/assets/js/top.js'); }}"></script>
    	<script src="{{ URL::asset('public/assets/js/wow.min.js'); }}"></script>
        <script src="https://player.vimeo.com/api/player.js"></script>
        <script>
            new WOW().init();
        </script>
    	<script>
        $(document).ready(function() 
        {
            $("#news-slider").owlCarousel({
                items : 3,
                itemsDesktop:[1199,3],
                itemsDesktopSmall:[980,2],
                itemsMobile : [600,1],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:true
            });
        
            $("#news-slider-1").owlCarousel({
                items : 3,
                itemsDesktop:[1199,3],
                itemsDesktopSmall:[980,2],
                itemsMobile : [600,1],
                navigation:true,
                navigationText:["",""],
                pagination:true,
                autoPlay:true
            });
        
            $(".search-trigger").on('click', function(e) 
            {
                $(".search-form-wrapper").toggleClass('open');
            });
            DropDown.prototype = 
            {
                initEvents : function() 
                {
                    var obj = this;
                    obj.dd.on('click', function(event)
                    {
                        $(this).toggleClass('active');
                        return false;
                    });

                    obj.opts.on('click',function()
                    {
                        var opt = $(this);
                        obj.val = opt.text();
                        obj.index = opt.index();
                        obj.placeholder.text(obj.val);
                    });
                },
                getValue : function() 
                {
                    return this.val;
                },
                getIndex : function() 
                {
                    return this.index;
                }
            }
            
            setTimeout(function(){
                $('body').addClass('loaded');
            }, 3000);
            
            $( document ).on('click', ".nftx", function(e)
            {
                var nftid = $(this).attr("data-nftid");
                var rowid = $(this).attr("data-rowid");
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{route('nft.addviews')}}",
                    data: {'_token':'{{ csrf_token() }}',nftid:nftid, rowid:rowid},
                    success: function(response)
                    { 
                        if(response == 1)
                        {
                            return true;
                        }else{
                            e.preventDefault();
                        }
                    }
                });
            });
        });
            
        function DropDown(el) 
        {
            this.dd = el;
            this.placeholder = this.dd.children('span');
            this.opts = this.dd.find('ul.dropdown > li');
            this.val = '';
            this.index = -1;
            this.initEvents();
        }
        
        </script>
      @if (Auth::guest())
    <script></script>     
@else
    <script>
    jQuery( document ).ready( function() 
    {
        $( document ).on("click", ".changeclass", function(){
                $(this).removeClass('far');
                $(this).addClass('fas');
                return false;
            });
        $( document ).on('click', ".favouritesingle", function(e)
        {
            $(this).addClass("fas fa-heart");
            $(this).addClass("added");
            $(this).parents(".owl-item").find(".chk").val(1);
            var rowid = $(this).attr("data-number");
            var nftid = $(this).attr("data-nftid");
            var val = $(this).parents(".owl-item").find(".chk").val();
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{route('nft.addfavourite')}}",
                data: {'_token':'{{ csrf_token() }}',id:nftid, val:val},
                success: function(response)
                { 
                    console.log(response);
                }
            });

            return false;
        });

        $( document ).on('click', ".favourite", function(e)
        {
            $(this).parents(".owl-item").find(".chk").val(1);
            var nftid = $(this).attr("data-nftid");
            var rowid = $(this).attr("data-rowid");
            var val = $(this).parents(".owl-item").find(".chk").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{route('nft.addfavourite')}}",
                data: {'_token':'{{ csrf_token() }}',id:nftid, rowid:rowid, val:val},
                success: function(response)
                { 
                    $(this).parents('.owl-itme').removeClass("far fa-heart");
                    $(this).parents('.owl-itme').addClass("fas fa-heart");
                    $(this).addClass("added");
                }
            });
        });
    });
    </script>
@endif
      </body>
    </html>
