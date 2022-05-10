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
</style>
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
                        <h3>Activities <span>(Bids Made)</span></h3>
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
								<th>Your Bid</th>
								<th>Highest Bid</th>
								<th>Status</th>
							  </tr>
							</thead>
							<tbody>
                                @php
                                $count = 1;
                                $i = 0;
                                foreach($bids as $nft)
                                {
                                    $file = $nft->file;
                                    $nftfile = asset("storage/app/public/".$file);
                                    @endphp
                                    <tr>
                                        <td>{{$count}}</td>
                                        <td>#{{$nft->nftid}}</td>
                                        <td><a href="{{route('nft.show', [$nft->nftid])}}"><u>{{$nft->title}}</u></a></td>
                                        <td>
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
                                        <td><i class="fas fa-rupee-sign"></i>{{$nft->bid_amount}}</td>
                                        <td><i class="fas fa-rupee-sign"></i>{{$nft->highestBid}}</td>
                                        <?php 
                                        $st = "";
                                        if($nft->status == 1)
                                        {
                                            $st = "In Auction";
                                        }else if($nft->status == 2)
                                        {
                                            $st = "Not Sold";
                                        }else{
                                            $st = "Sold";
                                        }
                                        ?>
                                        <td><p class="sold_bg_not">{{ucfirst($st)}}</p></td>
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
                    foreach($bids as $nft)
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
                                        <span class="auc_title">Auc. end date : {{$auction_end_date}}</span>
                                        <h3 class="price_tag"><span class="current_bid">Current bid</span><i class="fa fa-rupee-sign"></i>0</h3>
                                        <p class="sold_bg_you">SOLD TO YOU</p>
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