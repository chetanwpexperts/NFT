@include('layouts.dashboard.header')
@include('layouts.dashboard.sidebar')
<style>
td{
    position: relative;
}

td audio {
    position: absolute;
    top: 2rem;
    left: 3.6rem;
    width: 67%;
    height: 45px;
}
.color{
    background: #1c0d0d;
    color: #ff0000;
    padding: 0.4rem 0.5rem;
    margin-top: 5px;
    border-radius: 1rem;
}
</style>
<script> 
var timer2 = "15:01";
var interval = setInterval(function() {
  var timer = timer2.split(':');
  //by parsing integer, I avoid all extra string processing
  var minutes = parseInt(timer[0], 10);
  var seconds = parseInt(timer[1], 10);
  --seconds;
  minutes = (seconds < 0) ? --minutes : minutes;
  if (minutes < 0){ clearInterval(interval); return false; };
  seconds = (seconds < 0) ? 59 : seconds;
  seconds = (seconds < 10) ? '0' + seconds : seconds;
  //minutes = (minutes < 10) ?  minutes : minutes;
  $('.countdown').html(minutes + ':' + seconds);
  timer2 = minutes + ':' + seconds;
}, 1000);
</script>
<!-- Content Wrapper. Contains page content -->
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
                        <h3>Activities <span>(Offers Made)</span></h3>
					</div>
					<div class="table_boxx">
						<div class="col-lg-4 col-sm-4" id="inner_search">
							<div id="custom-search-input-inner">
                                <div class="input-group col-md-12">
                                    <input type="text" class="  search-query form-control" placeholder="Search" />
                                    <span class="input-group-btn">
                                        <button class="btn btn-danger" type="button">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </span>
                                </div>
							</div>
						</div>
                        
						<table class="table table-striped">
							<thead>
							  <tr>
								<th>S.No</th>
								<th>Creation ID</th>
								<th>Title</th>
								<th>Preview</th>
								<th>Your Offer</th>
								<th>Highest Offer</th>
								<th>Status</th>
							  </tr>
							</thead>
							<tbody>
                                @php
                                $count = 1;
                                $i = 0;
                                foreach($offers as $nft)
                                {
                                    $offer_id  = $nft->id;
                                    $file = $nft->file;
                                    $nftfile = asset("storage/app/public/".$file);
                                    @endphp
                                    <tr>
                                        <td>{{$count}}</td>
                                        <td>#{{$nft->nftid}}</td>
                                        <td><a href="{{route('nft.demanddetails', [$nft->nftid])}}?p=myoffers"><u>{{$nft->title}}</u></a></td>
                                        <td>
                                        <?php
                                        $status = ($nft->status != "") ? ucfirst($nft->status) : "View";
										?>
                                        <?php 
                                        $ext = pathinfo($nftfile, PATHINFO_EXTENSION);
                                        switch($ext)
                                        {
                                             case "mp4":
                                             case "flv":
                                             case "mov":
                                                ?> 
                                                <video controls="" style="width:100%;background-color:#000000;" autoplay muted>
                                                                    <source src="{{$nftfile}}" type="video/mp4">
                                                                </video>
                                                <?php
                                                break;
                                            case "mp3":
                                                ?>
                                                <audio controls controlsList="nodownload">
                                                    <source src="{{$nftfile}}" type="audio/mpeg">
                                                </audio>
                                                <?php
                                                break;
                                             case "png":
                                                ?>
                                                <img src="{{$nftfile}}" class="img-responsive img_tab" />
                                                <?php
                                                break;
                                            case "jpeg":
                                                ?>
                                                <img src="{{$nftfile}}" class="img-responsive img_tab"/>
                                                <?php
                                                break;
                                            case "jpg":
                                                ?>
                                                <img src="{{$nftfile}}" class="img-responsive img_tab"/>
                                                <?php
                                                break;
                                        }
                                        ?>
                                        </td>
                                        <td><i class="fas fa-rupee-sign"></i>{{$nft->offer_amount}} 
                                            <div class="timer_<?=$offer_id?>">
                                            <?php 
                                            if($status == "1")
                                            {
                                                ?>
                                                <div class="color time_<?=$offer_id?>">
                                                    <strong>Time left: <span class="countdown"></span></strong>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            </div>
                                        </td>
										
                                        <td><i class="fas fa-rupee-sign"></i>{{$nft->highestOffer}}</td>
                                        <td><p class="sold_bg_not">
                                            <?php 
                                            if($status == "View")
                                            { ?>
                                                <a href="{{route('nft.demanddetails', [$nft->nftid])}}" style="color:#EECB1C;font-weight:500;font-size: 16px;text-decoration:underline;">View</a>
                                            <?php 
                                            }else{
                                                switch($status)
                                                {
                                                    case "4":
                                                        echo "Rejected";
                                                        break;
                                                    case "3":
                                                        echo "<font color='#77b9e9'>In Progress</font><small>Update Your wallet. Money will be auto debited.</small>";
                                                        break;
                                                    case "2":
                                                        echo "<font color='#51d132'>You Win</font>";
                                                        break;
                                                    case "1":
                                                        echo "<font color='#ebc60a'>In Demand</font>";
                                                        break;
                                                };
                                            }
                                            ?>
                                            </p></td>
                                    </tr>
                                    @php
                                    $i++;
                                    $count++;
                                }
                                @endphp
							</tbody>
						</table>
					</div>
					<!--Mobile-Table-View-->
					@php
                    $count = 1;
                    foreach($offers as $nft)
                    {
                        $file = $nft->file;

                        $nftfile = asset("storage/app/public/".$file);
                        $auction_end_date = date("d/m/Y", strtotime($nft->auction_end_time))
                        @endphp
                        <div id="mobile_tab">
                            <ul>
                                <li>
                                    <div class="table-img">
                                        <?php 
                                        $status = ($nft->status != "") ? ucfirst($nft->status) : "View";
                                        $ext = pathinfo($nftfile, PATHINFO_EXTENSION);
                                        switch($ext)
                                        {
                                             case "mp4":
                                             case "flv":
                                             case "mov":
                                                ?> 
                                                 <video controls="" style="width:100%;background-color:#000000;" autoplay muted>
                                                                    <source src="{{$nftfile}}" type="video/mp4">
                                                                </video>
                                                <?php
                                                break;
                                            case "mp3":
                                                ?>
                                                <audio controls controlsList="nodownload">
                                                    <source src="{{$nftfile}}" type="audio/mpeg">
                                                </audio>
                                                <?php
                                                break;
                                             case "png":
                                                ?>
                                                <img src="{{$nftfile}}" class="img-responsive img_tab" />
                                                <?php
                                                break;
                                            case "jpeg":
                                                ?>
                                                <img src="{{$nftfile}}" class="img-responsive img_tab"/>
                                                <?php
                                                break;
                                            case "jpg":
                                                ?>
                                                <img src="{{$nftfile}}" class="img-responsive img_tab"/>
                                                <?php
                                                break;
                                        }
                                        ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="offer-details">
                                        <h4>#{{$nft->nftid}} <span style="float:right;">{{$auction_end_date}}</span></h4>
                                        <a href="{{route('nft.show', [$nft->nftid])}}" class="wallstreet_link">{{$nft->title}}</a>
                                        <span class="auc_title">
                                        <?php if($status == "1")
                                        {
                                            ?>
                                            <div class="color time_<?=$offer_id?>">
                                                <strong>Time left: <span class="countdown"></span></strong>
                                            </div>
                                            <?php
                                        } 
                                        ?>
                                        </span>
                                        <h3 class="price_tag"><span class="current_bid">Current bid</span><i class="fa fa-rupee-sign"></i>{{$nft->offer_amount}}</h3>
                                        <div class="sold_bg_you timer_<?=$offer_id?>">
                                            <?php 
                                            
                                            if($status == "View")
                                            { ?>
                                                <a href="{{route('nft.demanddetails', [$nft->nftid])}}" style="color:#EECB1C;font-weight:500;font-size: 16px;text-decoration:underline;">View</a>
                                            <?php 
                                            }else{
                                                switch($status)
                                                {
                                                    case "4":
                                                        echo "Rejected";
                                                        break;
                                                    case "3":
                                                        echo "<font color='#77b9e9'>In Progress</font><small>Update Your wallet. Money will be auto debited.</small>";
                                                        break;
                                                    case "2":
                                                        echo "<font color='#51d132'>You Win</font>";
                                                        break;
                                                    case "1":
                                                        echo "<font color='#ebc60a'>In Demand</font>";
                                                        break;
                                                };
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        @php
                        $count++;
                    }
                    @endphp
					<!--Mobile-Table-View-->
					
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
  <!-- /.content-wrapper -->

@include('layouts.dashboard.footer')
<script src="https://player.vimeo.com/api/player.js"></script>