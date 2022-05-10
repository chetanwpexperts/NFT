@include('layouts.dashboard.header')
@include('layouts.dashboard.sidebar')
<style>
td{
    position: relative;
}

td audio {
    position: absolute;
    top: 2rem;
    left: 0.6rem;
    width: 100%;
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
						<h3>My <span>NFTs</span></h3>
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ session('status') }}
                        </div>
                        @elseif(session('failed'))
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ session('failed') }}
                        </div>
                        @endif
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
								<th>Auc.End Date</th>
								<th>Status</th>
                                <th>Action</th>
							  </tr>
							</thead>
							<tbody>
                                @php
                                
                                $count = 1;
                                $i = 0;
                                foreach($nfts as $nft)
                                {
                                    if($nft->is_sold != "yes")
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
                                                case "gif":
                                                    ?>
                                                    <img src="{{$nftfile}}" class="img-responsive img_tab"/>
                                                    <?php
                                                    break;
                                            }
                                            ?>
                                            </td>
                                            <td>{{date("Y-m-d", strtotime($nft->auction_end_time))}}</td>
                                            <?php
                                            $now = new \Datetime();
                                            $now = (array) $now;
                                            $status = ($now['date'] > $nft->auction_end_time) ? "Auction Expired" : "In Auction";
                                            $sold_status = ($nft->auction_status == "sold") ? "Sold" : $status;
                                            ?>
                                            <td><p class="sold_bg_not sold_bg_not-custom">{{$sold_status}}</p><small>Current Bid</small> <br /><i class="fas fa-rupee-sign"></i>{{$nft->highestBid}}</td>
                                            <td> <a href="{{route('nft.show', [$nft->nftid])}}" style="color:#FF5E5B;font-weight:800;font-size: 11px;text-decoration:underline;"><i class="fas fa-eye"></i> View</a></td>
                                        </tr>
                                        @php
                                    }
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
                    foreach($nfts as $nft)
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
                                            case "gif":
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
                                        <?php 
                                        if($nft->auction_status != "sold")
                                        {
                                            ?>
                                            <h4>#{{$nft->nftid}} <span style="float:right;color:#f55050;">In Auction</span></h4>
                                            <a href="{{route('nft.show', [$nft->nftid])}}" class="wallstreet_link">{{$nft->title}}</a>
                                            <span class="auc_title">Auc. end date : {{$auction_end_date}}</span>
                                            <h3 class="price_tag"><span class="current_bid">Current bid</span><i class="fa fa-rupee-sign"></i>{{$nft->highestBid}}</h3>
                                            <?php 
                                            $status = ($nft->type == "auction") ? "In Auction" : "";
                                            ?>
                                            <p class="sold_bg_you">{{$status}}</p>
                                            <?php 
                                        }else{
                                            ?>
                                            <h4>#{{$nft->nftid}} <span style="float:right;">Auction End</span></h4>
                                            <p class="sold_bg_you">Sold</p>
                                            <?php
                                        }
                                        ?>
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