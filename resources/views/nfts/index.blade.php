@include('layouts.dashboard.header')
@include('layouts.dashboard.sidebar')

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
								<th>Total Offers</th>
								<th>Your Offers</th>
								<th>Status</th>
							  </tr>
							</thead>
							<tbody>
                                @php
                                $count = 1;
                                foreach($nfts as $nft)
                                {
                                    $file = $nft->file;
                                    
                                    $nftfile = asset("storage/app/public/".$file);
                                    @endphp
                                    <tr>
                                        <td>{{$count}}</td>
                                        <td>#{{$nft->nftid}}</td>
                                        <td><u>{{$nft->title}}</u></td>
                                        <td>
                                    <?php 
                                        $ext = pathinfo($nftfile, PATHINFO_EXTENSION);
                                        switch($ext)
                                        {
                                             case "mp4":
                                             case "flv":
                                             case "mov":
                                                ?> 
                                                <iframe class="iframe" src="{{$nftfile}}?title=0&byline=0&portrait=0&sidedock=0&?autoplay=1&muted=1" width="43%" height="93" frameborder="0" webkitallowfullscreen   mozallowfullscreen allowfullscreen allow="autoplay" style="border:1px solid #f7f7f7;border-radius: 11px;">
                                                </iframe>
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
                                        <td>0</td>
                                        <td><i class="fas fa-rupee-sign"></i>{{$nft->price}}</td>
                                        <td><p class="sold_bg_not">NOT SOLD YET</p></td>
                                    </tr>
                                    @php
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
                                        <img src="{{$nftfile}}" class="img-responsive"/>
                                    </div>
                                </li>
                                <li>
                                    <div class="offer-details">
                                        <h4>#{{$nft->nftid}} <span style="float:right;">{{$auction_end_date}}</span></h4>
                                        <a href="#" class="wallstreet_link">{{$nft->title}}</a>
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