@extends('layouts.innerlayout')

@section('content')

<section id="inner-page-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="inner-page-title">
						<h3><span style="color:#FF5E5B;">Most Liked NFTs</span></h3>
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
                                        <img src="{{$badges}}" class="img-responsive" style="width: 20%;position: absolute;left:32rem;top: -3.5rem;" />
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
            @endphp
			</div>
		</div>
	</section>

@endsection