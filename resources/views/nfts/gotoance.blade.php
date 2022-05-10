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
						<h3>Pending Action<span> On My NFTs (Demand Supply / Auction)</span></h3>
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
								<th>NFT</th>
								<th>Title</th>
								<th>Preview</th>
                                <th>Buyer</th>
								<th>Amount</th>
								<th>Action</th>
							  </tr>
							</thead>
							<tbody>
                                <?php
                                $count = 1;
                                foreach($allPendingPurchases as $nft)
                                {
                                    $nftdetails = DB::table("nfts")->where("nftid", "=", $nft->nftid)->first();
                                    $finalId = $nft->id;
                                    $file = $nft->file;

                                    $nftfile = asset("storage/app/public/".$file);
                                    $nftfile = asset("storage/app/public/".$file);
                                    date_default_timezone_set("Asia/Calcutta"); 
                                    $dt = new DateTime($nft->timeleft, new DateTimeZone('UTC'));
                                    $dt->setTimezone(new DateTimeZone('Asia/Calcutta'));
                                    $auction_end_date = $dt->format('Y-m-d H:i:s T');
                                    ?>
                                    <tr id="dataid_<?=$finalId?>">
                                        <td><?=$count?></td>
                                        <td>#<?=$nft->nftid?></td>
                                        <td><?=$nft->title?></td>
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
                                            case "gif":
                                                ?>
                                                <img src="{{$nftfile}}" class="img-responsive img_tab"/>
                                                <?php
                                                break;
                                        }
                                        ?>
                                        </td>
                                        <td>{{$auction_end_date}}</td>
                                        <td>{{$nft->buyer}}</td>
                                        <td>{{$nft->amount}}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="ddd" data-value="makepayment" data-amount="<?=$nft->amount?>" data-nftid="<?=$nft->nftid?>" data-offer_id="<?=$finalId?>"> <i class="fas fa-user-check"></i> Make Payment</a>
                                        </td>
                                    </tr>
                                    <?php
                                    $count++;
                                }
                               ?>
							</tbody>
						</table>
					</div>
					<!--Mobile-Table-View-->
					@php
                    $count = 1;
                    foreach($allPendingPurchases as $nft)
                    {
                        $nftdetails = DB::table("nfts")->where("nftid", "=", $nft->nftid)->first();
                        $offer_id = $nft->id;
                        $file = $nft->file;

                        $nftfile = asset("storage/app/public/".$file);
                        date_default_timezone_set("Asia/Calcutta"); 
                        $dt = new DateTime($nft->timeleft, new DateTimeZone('UTC'));
                        $dt->setTimezone(new DateTimeZone('Asia/Calcutta'));
                        $auction_end_date = $dt->format('Y-m-d H:i:s T');
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
                                        <h3 class="price_tag"><span class="current_bid">Amount</span><i class="fa fa-rupee-sign"></i>{{number_format($nft->amount,2)}}</h3>
                                        <p class="sold_bg_you">
                                        <a href="javascript:void(0);" class="ddd" data-value="makepayment" data-amount="<?=$nft->amount?>" data-nftid="<?=$nft->nftid?>" data-offer_id="<?=$finalId?>"> <i class="fas fa-user-check"></i> Make Payment</a>
                                        </p>
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


<script>
jQuery( document ).ready( function($)
{
    $(".ddd").on("click", function()
    {
        var whichtr = $(this).closest("tr");
        var nftid = $(this).attr('data-nftid');
        var amount = $(this).attr('data-amount');
        var offerid = $(this).attr('data-offer_id');
        var status = $(this).attr("data-value");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'POST',
            url:"{{ route('offers.acceptedrejected') }}",
            data:{nftid:nftid,status:status,offerid:offerid,amount:amount},
            success:function(data)
            {
                if(data == "rejected")
                {
                    whichtr.remove();
                    return false;
                }
                if(data == "accepted")
                {
                    window.location.href = "{{route('creator.soldbyme')}}";
                }
            }
        });
    });
});
</script>