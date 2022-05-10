@extends('layouts.innerlayout')

@section('content')

<style>
    iframe.iframe{
        height:620px !important;
    }
	.scrollbar
{

	height: auto;
	width:65%;
	margin-bottom: 25px;
	background: rgba(35,0,30,0.3);
}

.force-overflow
{
	/* min-height: 450px; */
}
#style-4::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
	border-radius: 10px;
}

#style-4::-webkit-scrollbar
{
	width: 10px;
	background-color: #F5F5F5;
	border-radius: 10px;
}

#style-4::-webkit-scrollbar-thumb
{
	background-color: #000000;
	border-radius: 10px;
}
    .nftdesc{
        
        list-style: none;
        display: inline-block;
        padding: 5px 15px;
        border-radius: 10px;
        margin-right: 10px;
        margin-bottom: 10px;
        color:#f9f9f9 !important;
    }
    
@media (min-width:1281px) 
{
    audio {
        top: 27rem !important;
        left: 11rem !important;
    }
}
</style>
<section id="inner-page-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="purchase_boxx">
						<div class="row">
							<div class="col-lg-6 col-ms-6">
								<div class="inner_img img_demand">
                                    <?php $nftfile = asset("storage/app/public/".$nfts->file);
                                    $ext = pathinfo($nftfile, PATHINFO_EXTENSION);
                                    switch($ext)
                                    {
                                         case "mp4":
                                         case "flv":
                                         case "mov":
                                            ?> 
                                            <video controls="" style="width:100%;height:850px;background-color:#000000;" autoplay muted controlsList="nodownload">
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
                                        case "webp":
                                        case "gif":
                                            ?>
                                            <img src="{{$nftfile}}" class="img-responsive" />
                                            <?php
                                            break;
                                    }
                                    ?>
								</div>
							</div>
							<div class="col-lg-6 col-ms-6">
								
								<div class="share-div">
									<a href="#"><img src="{{ URL::asset('public/assets/img/share-icon.png'); }}" style="width:19px;">Share</a>
								</div>
                                <?php
                                $class = "";
                                if($nfts->like == "yes")
                                {
                                    $class = "fas fa-heart";
                                }else{
                                    $class = "far fa-heart";
                                }
                                ?>
								<div class="like_boxx">
									<label for="favourites"><i class="{{$class}} favouritesingle" data-number="1" data-nftid="{{$nfts->nftid}}"></i></label>
                                    <input type="checkbox" class="chk" id="favourites" name="favourite" value="0" style="display:none;" data-row-check="check" />
								</div>
								<div class="inner-info-div">
									<div class="post-views">
										<p><i class="fas fa-eye"></i> {{$nfts->views}} Views</p>
									</div>
								</div> 
								<div class="id-info ID_num">
									<h4>ID : {{$nfts->nftid}}</h4>
								</div>
								<div class="id-title id_name">
									<h3>{{$nfts->title}}</h3>
								</div>
								<div class="creator_boxx">
									<ul>
										<li>
											<div class="purchase-price">
												<h4>Owned By</h4>
                                                <?php 
                                                $avatar = $ownedBy->dp;
                                                if($avatar == "")
                                                {
                                                    $avatar = "users/default.png";
                                                }
                                                $owner_avatar = asset("storage/app/public/".$avatar);  
                                                ?>
												<h3><img src="{{$owner_avatar}}" style="border-radius:50%;"><u>{{$ownedBy->name}}</u></h3>
											</div>
										</li>
										<li>
											<div class="purchase-price">
												<h4>Created By</h4>
                                                <?php 
                                                $cavatar = $createdBy->dp;
                                                if($cavatar == "")
                                                {
                                                    $cavatar = "users/default.png";
                                                }
                                                $creator_avatar = asset("storage/app/public/".$cavatar);
                                                ?>
												<h3><img src="{{$creator_avatar}}" style="border-radius:50%;"><u>{{$createdBy->name}}</u></h3>
											</div>
										</li>
									</ul>
								</div>
                                <?php
                                if($nfts->type != "demand")
                                {
                                    ?>
                                    <div class="auction-timer">
                                        <ul>
                                            <li><img src="{{ URL::asset('public/assets/img/auction-icon.png'); }}"></li>
                                            <li>
                                                <h4>Auction Ends</h4>
                                                <div class="timer_info">
                                                    <p id="timer"></p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php 
                                }else{
                                    ?>
                                    <div class="demand_supply">
                                        <ul>
                                            <li><img src="{{ URL::asset('public/assets/dashboard/images/van.png'); }}" style="width:36px;"></li>
                                            <li>
                                                <h4>On Demand Supply</h4>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php
                                }
                                ?>
								<div class="creator_boxx">
                                    <?php $itemtype = ($nfts->type != "demand") ? "Bid" : "Offer";?>
                                    <?php
                                    $amount = "";
                                    if($nfts->type != "demand")
                                    {
                                        if(!empty($currentBid))
                                        {
                                            $amount = $currentBid->bid_amount;
                                        }
                                    }else{
                                        if(!empty($currentOffer))
                                        {
                                            $amount = $currentOffer->offer_amount;
                                        }
                                    }
                                    ?>
									<ul>
										<li>
											<div class="purchase-price">
												<h4>Current {{$itemtype}}</h4>
												<h3><u id="currentbidu"><?php 
                                                    if($amount != "")
                                                    {
                                                        echo number_format($amount,2);
                                                    }else{
                                                        echo "0.00";
                                                    }
                                                    ?></u></h3>
											</div>
										</li>
										<li>
											<div class="purchase-price">
												<h4>Base {{$itemtype}}</h4>
												<h3><u>{{$nfts->price}}</u></h3>
											</div>
										</li>
									</ul>
								</div>
                                <div class="hashtagss">
									<div class="hashtags_list">
                                        <h4>Description</h4>
										<div class="scrollbar" id="style-4">
										  <div class="force-overflow">
											<p class="nftdesc">{{$nfts->tags}}</p>
										  </div>
										</div>
                                        
										<!--<ul>
											@php
                                            $tags = explode(",", $nfts->tags);
                                            foreach($tags as $tag)
                                            {
                                            @endphp
                                            <li>
                                                <a>{{$nfts->tags}}</a>
                                            </li>
                                            @php
                                            }
                                            @endphp
										</ul>-->
									</div>
								</div>
								<?php   
                                if($nfts->is_sold != "sold")
                                {
                                    ?>
                                    <div class="place-bid">
                                        <?php 
                                        $route = "";
                                        $buttontext = "";
                                        $ptext = "";
                                        if($nfts->type == "auction")
                                        {
                                            $route = route('auction.placebid');
                                            $buttontext = "Place Bid";
                                            $ptext = "Place your Bid";
                                        }else{
                                            $route = route('auction.placeoffer');
                                            $buttontext = "Send Offer";
                                            $ptext = "Send Your Offer";
                                        }
                                        ?>
                                        <p id="labeltxt">{{$ptext}}</p>
                                        <form id="placebidform" class="form-inline" method="post" action="{{$route}}">
                                            @csrf
                                            <div class="form-group">
                                            <?php 
                                            $price = "";
                                            if(is_int($nfts->price))
                                            {
                                                $price = $nfts->price + 1;
                                            }
                                            ?>
                                            <input type="text" name="amount" class="form-control numberonly amount" maxlength="10" id="exampleInputEmail2" value="{{$price}}" placeholder="Enter Amount" onkeypress="return checkOnlyDigits(event)">
                                            <input type="hidden" name="nftid" value="{{$nfts->nftid}}" />
                                            <input type="hidden" name="type" value="{{$nfts->type}}" />
                                            <input type="hidden" id="action" value="{{$route}}">
                                            </div>

                                            <button type="submit" class="btn btn-success" id="pb-button" data-nftprice="{{$nfts->price}}" data-nftid="{{$nfts->nftid}}">{{$buttontext}} <i class="fa fa-spinner fa-spin" style="display:none;"></i></button>
                                        </form>
                                        <div id="mesagediv" style="display:none;">
                                            <div class="alert alert-success" role="alert" style="width:64%;margin-top:1rem;font-weight:bold;">

                                            </div>
                                        </div>

                                        @if (Session::get('success'))
                                            <div class="alert alert-success" role="alert" style="width:64%;margin-top:1rem;font-weight:bold;">
                                                {{ Session::get('success') }}
                                            </div>
                                        @endif
                                    </div>
                                    <?php 
                                }else{
                                    ?>
                                    <button type="button" class="btn btn-success" style="padding: 1.5rem 5rem;background: #e4e718;border: none;color: #404040;font-weight: bold;">SOLD OUT</button>
                                    <p> &nbsp </p>
                                    <?php 
                                }
                                ?>
							</div>
						</div>
					</div>
					<div class="comment_boxx">
						<div class="comment_title">
							<h3><img src="{{ URL::asset('public/assets/img/chat_icon.png'); }}"/>Comments</h3>
						</div>
						<div class="chat_boxx_msg">
                            {{ csrf_field() }}
                            <input type="hidden" id="nftid" value="{{$nfts->nftid}}">
                            <div class="commentdiv">
                                <?php
                                /*
                                if(!empty($comments))
                                {
                                    foreach($comments as $comment)
                                    {
                                        ?>
                                        <div class="media">
                                            <div class="media-left media-middle">
                                                <a href="#">
                                                    <img class="media-object" src="{{$comment->dp}}" alt="user-img" style="border-radius:50%;height:50px;">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <?php
                                                $now = new DateTime;
                                                $ago = new DateTime($comment->created_at);
                                                $diff = $now->diff($ago);

                                                $diff->w = floor($diff->d / 7);
                                                $diff->d -= $diff->w * 7;

                                                $string = array(
                                                    'y' => 'year',
                                                    'm' => 'month',
                                                    'w' => 'week',
                                                    'd' => 'day',
                                                    'h' => 'hour',
                                                    'i' => 'minute',
                                                    's' => 'second',
                                                );
                                                foreach ($string as $k => &$v) {
                                                    if ($diff->$k) {
                                                        $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                                                    } else {
                                                        unset($string[$k]);
                                                    }
                                                }

                                                //if (!$full) $string = array_slice($string, 0, 1);
                                                $postedDate = $string ? implode(', ', $string) . ' ago' : 'just now';
                                                ?>
                                                <h4 class="media-heading">{{$comment->name}} <span>{{$postedDate}}</span></h4>
                                                <p>{{$comment->comment}}.</p>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <div class="media">
                                      <div class="media-body">
                                        <p>No comments yet!</p>
                                      </div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="load-more">
                                    <button class="btn btn-success">Load More</button>
                                </div>
                                <?php 
                                */
                                ?>
                            </div>
							<div class="post-comment">
								<form class="form-inline" id="commentForm" name="commentForm">
									  <div class="form-group">
										  <input type="text" name="comment" class="form-control" id="comment" placeholder="Write your comment" required>
									  </div>
									  <button type="submit" class="btn btn-success" data-creatorid="{{$nfts->creator_id}}" data-nftid="{{$nfts->nftid}}" id="commentBtn">Post Comment</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</section>
<?php 
date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
$time = new DateTime($nfts->auction_end_time);
$target_date = $time->format('Y-m-d H:i:s');
//echo $target_date = $nfts->auction_end_time;
$timeLeft = (strtotime($target_date) - time()) * 1000;
if($nfts->type == "auction")
{
    ?>
    <script>
    var countDownDate = new Date("{{$target_date}}").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

      // Get today's date and time
      var now = new Date().getTime();

      // Find the distance between now and the count down date
      var distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Output the result in an element with id="demo"

      document.getElementById("timer").innerHTML = days + "d: " + hours + "h: "
      + minutes + "m: " + seconds + "s";

      // If the count down is over, write some text 
      if (distance < 0) 
      {
        clearInterval(x);
        document.getElementById("timer").innerHTML = "EXPIRED";
        $("#pb-button").prop("disabled", true);
        $("#pb-button").attr("readonly", "readonly");
      }
    }, 1000);
    </script>
    <?php 
}
?>
<script src="{{ URL::asset('public/assets/js/jquery.js'); }}"></script>
<script>
jQuery(document).ready(function(){
    $("#pb-button").on("click", function(){
        var amount = $("input[name='amount']").val();
        $("#currentbidu").html(amount);
    });
});
</script>
{{--

<script>
jQuery( document ).ready( function() 
{
    var nftid = $(".id-info h4").text();
    nftid = nftid.replace('ID', "");
    nftid = nftid.replace(': ', "");
    setInterval(function(){
        checkifnftsoldout(nftid);
    },10000);
});
function checkifnftsoldout(nftid)
{
    $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
    });
    $.ajax({
        url: "{{route('nft.checksoldnft')}}",
        type:'POST',
        data:  {nftid:nftid},
        success: function(response)
        {
            if(response == "sold")
            {
                $("#placebidform").remove();
                $("#labeltxt").remove();
            }
        }
    });
    return false;
}
</script>
--}}
@endsection