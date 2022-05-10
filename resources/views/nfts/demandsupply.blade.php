@include('layouts.dashboard.header')
@include('layouts.dashboard.sidebar')
<style>
td{
    position: relative;
}

td audio {
    position: absolute;
    top: 1.6rem;
    left: 0.6rem;
    width: 100%;
    height: 45px;
    
}
    table.table td {
    border-top: none;
    /* padding: 22px 20px; */
}
    .viewBtn{
        color:#EECB1C;font-weight: 500;font-size: 13px;text-decoration: none;background:#220a0a24;padding: 0.5rem 0.3rem;border-radius: 5px;
    }
    .viewBtn:hover{
        background: #340404;
        font-size: 11px;
        box-shadow: 2px 2px 4px -2px #f9f9f9;
    }
    .selBtn{
        color: #12D4D1;font-weight: 500;font-size: 13px;text-decoration: none;background:#220a0a24;padding: 0.5rem 0.3rem;border-radius: 5px;
    }
    .selBtn:hover{
        background: #340404;
        font-size: 11px;
        box-shadow: 2px 2px 4px -2px #f9f9f9;
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
						<h3>My <span>NFTs (demand Supply)</span></h3>
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
                                <th>Creation</th>
								<th>Total Offers</th>
								<th>Top Offer</th>
								<th>Status</th>
							  </tr>
							</thead>
							<tbody>
                                @php
                                $count = 1;
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
                                            <td><a href="{{route('nft.demanddetails', [$nft->nftid])}}"><u>{{$nft->title}}</u></a></td>
                                            <td>
                                            <?php 
                                            $ext = pathinfo($nftfile, PATHINFO_EXTENSION);
                                            switch($ext)
                                            {
                                                 case "mp4":
                                                 case "flv":
                                                 case "mov":
                                                    ?> 
                                                    <video controls="" style="width:100%;height:100%;background-color:#000000;" autoplay muted>
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
                                            <td>{{date("Y-m-d", strtotime($nft->created_at))}}</td>
                                            <td><a href="{{route('nft.alloffers', [$nft->nftid])}}">{{$nft->offercount}}</a></td>
                                            <td><i class="fas fa-rupee-sign"></i>{{number_format($nft->highestOffer,2)}}</td>
                                            <td> <a href="{{route('nft.demanddetails', [$nft->nftid])}}" class="viewBtn"><i class="fas fa-eye"></i> View</a>  <a href="{{route('nft.alloffers', [$nft->nftid])}}" class="selBtn"><i class="fas fa-cart-arrow-down"></i> Sell</a></td>
                                            
                                        </tr>
                                        @php
                                    }
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
                        if($nft->is_sold != "yes")
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
                                            <h4>#{{$nft->nftid}} <span style="float:right;color:#a4e98f;">In Demand</span></h4>
                                            <h5><a href="{{route('nft.show', [$nft->nftid])}}" class="wallstreet_link">{{$nft->title}}</a>
                                            <span class="auc_title">Total Offers: {{$nft->offercount}}</span></h5>
                                            <h3 class="price_tag"><span class="current_bid">Current bid</span><i class="fa fa-rupee-sign"></i>{{number_format($nft->highestOffer,2)}}</h3>
                                            <p class="sold_bg_you"> <a href="{{route('nft.demanddetails', [$nft->nftid])}}" style="color:#EECB1C;font-weight:500;font-size: 16px;text-decoration:underline;"><i class="fas fa-eye"></i> View</a> <a href="{{route('nft.alloffers', [$nft->nftid])}}" style="color:#12D4D1;font-weight:500;font-size: 16px;text-decoration:underline;"><i class="fas fa-cart-arrow-down"></i> Sell</a></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            @php
                        }
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