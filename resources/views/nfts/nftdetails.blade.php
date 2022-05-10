@include('layouts.dashboard.header')
@include('layouts.dashboard.sidebar')
<style>
	.scrollbar
{

	height: 155px;
	width:90%;
	overflow-y: scroll;
	margin-bottom: 25px;
	background: rgba(35,0,30,0.3);
}

.force-overflow
{
	min-height: 100%;
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
</style>

<div class="content-wrapper">
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-12 col-12">
			<div class="new-creation">
				<div class="creation-title">
					<div class="creation_txt">
						<h3>{{ $nfts->title }} <span class="auction_title">(In {{ ucfirst($nfts->type) }})</span></h3>
					</div>
					<div class="purchase_boxx">
						<div class="row">
							<div class="col-lg-6 col-ms-6">
								<div class="inner_img"> 
                                    <?php 
                                    $file = $nfts->file;
                                    $nftfile = asset("storage/app/public/".$file);
                                    ?>
                                    <?php 
                                    $ext = pathinfo($nftfile, PATHINFO_EXTENSION);
                                    switch($ext)
                                    {
                                         case "mp4":
                                         case "flv":
                                         case "mov":
                                            ?> 
                                            <video controls="" style="width:100%;height:500px;background-color:#000000;" autoplay muted>
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
                                            <img src="{{$nftfile}}" class="img-responsive"/>
                                            <?php
                                            break;
                                        case "jpeg":
                                            ?>
                                            <img src="{{$nftfile}}" class="img-responsive"/>
                                            <?php
                                            break;
                                        case "jpg":
                                            ?>
                                            <img src="{{$nftfile}}" class="img-responsive"/>
                                            <?php
                                            break;
                                        case "gif":
                                            ?>
                                            <img src="{{$nftfile}}" class="img-responsive img_tab"/>
                                            <?php
                                            break;
                                    }

                                    ?>
								</div>
							</div>
							<div class="col-lg-6 col-ms-6">
								<div class="inner-info-div">
									<div class="post-views">
										<p><i class="fas fa-eye"></i> {{$nfts->views}} Views</p>
									</div>
								</div>
								<div class="id-info">
									<h4>ID : {{$nfts->nftid}}</h4>
								</div>
								<div class="id-title">
									<h3>{{ $nfts->title }}</h3>
								</div>
								<div class="auction-timer">
									<ul>
										<li><img src="{{ URL::asset('public/assets/dashboard/images/auction-icon.png'); }}"/></li>
										<li>
                                            <h4>Auction Ends</h4>
											<div class="timer_info">
                                                <p id="timer"></p>
											</div>
										</li>
									</ul>
								</div>
								<div class="purchase-price">
									<h4>Current Bid</h4>
									<h3>&#8377;{{number_format($highestBid,2)}}</h3>
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
                                                <a>#{{$tag}}</a>
                                            </li>
                                            @php
                                            }
                                            @endphp
										</ul>-->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
          </div>
          <!-- ./col -->

        </div>
        <!-- /.row -->
        <!-- Main row -->
       
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@include('layouts.dashboard.footer')
<?php 
$target_date = $nfts->auction_end_time;
$timeLeft = (strtotime($target_date) - time()) * 1000;
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
  }
}, 1000);
</script>