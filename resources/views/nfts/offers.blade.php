@include('layouts.dashboard.header')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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
.color {
    background: #1c0d0d;
    color: #ff0000;
    padding: 0.4rem 0.5rem;
    margin-top: 5px;
    border-radius: 1rem;
}
</style>
<script src="{{ URL::asset('public/assets/dashboard/plugins/jquery/jquery.min.js'); }}"></script>

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
						<h3>Offers <span>On My NFT (demand Supply)</span></h3>
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
                                <th>Buyer</th>
								<th>Offer Amount</th>
								<th>Status</th>
							  </tr>
							</thead>
							<tbody>
                                <?php
                                $count = 1;
                                foreach($allOffers as $nft)
                                {
                                    if($nft->is_sold != "sold")
                                    {
                                        if($nft->status != 4 && $user->creator_id == $nft->owner_id)
                                        {
                                            $offer_id = $nft->id;
                                            $file = $nft->file;

                                            $nftfile = asset("storage/app/public/".$file);
                                            ?>
                                            <tr id="dataid_<?=$offer_id?>">
                                                <td><?=$count?></td>
                                                <td>#<?=$nft->nftid?></td>
                                                <td><a href="{{route('nft.demanddetails', [$nft->nftid])}}"><u><?=$nft->title?></u></a></td>
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
                                                <td><?=date("Y-m-d", strtotime($nft->created_at))?></td>
                                                <td><?=$nft->buyer_name?></td>
                                                <td><?=$nft->offer_amount?>
                                                    <?php
                                                    if($nft->status != 3)
                                                    {
                                                    $waitingtime = $nft->created_at->addMinutes(15);
                                                    $timeinterval = date("i:s", strtotime($waitingtime));
                                                    ?>
                                                    <script>
                                                    jQuery(document).ready(function($){
                                                       function rejectedafter15minutes(attribute)
                                                        {
                                                            $(".loading-overlay").addClass("is-active");
                                                            var whichtr = attribute.closest("tr");
                                                            var nftid = attribute.attr('data-nftid');
                                                            var amount = attribute.attr('data-amount');
                                                            var offerid = attribute.attr('data-offer_id');
                                                            $.ajaxSetup({
                                                                headers: {
                                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                }
                                                            });
                                                            $.ajax({
                                                                type:'POST',
                                                                url:"{{ route('nft.removefifteenminutesoldrecord') }}",
                                                                data:{nftid:nftid,status:"reject",offerid:offerid,amount:amount},
                                                                success:function(data)
                                                                {
                                                                    $(".loading-overlay").removeClass("is-active");
                                                                    if(data == "rejected")
                                                                    {
                                                                        whichtr.remove();
                                                                        location.reload();
                                                                    }
                                                                }
                                                            });
                                                        } 


                                                    var timer2 = "{{$timeinterval}}";
                                                    var interval = setInterval(function() {


                                                      var timer = timer2.split(':');
                                                      //by parsing integer, I avoid all extra string processing
                                                      var minutes = parseInt(timer[0], 10);
                                                      var seconds = parseInt(timer[1], 10);
                                                      --seconds;
                                                      minutes = (seconds < 0) ? --minutes : minutes;
                                                      if (minutes < 0){ clearInterval(interval); rejectedafter15minutes($('.countdown_<?=$offer_id?>')); return false; };
                                                      seconds = (seconds < 0) ? 59 : seconds;
                                                      seconds = (seconds < 10) ? '0' + seconds : seconds;
                                                      //minutes = (minutes < 10) ?  minutes : minutes;
                                                      $('.countdown_<?=$offer_id?>').html(minutes + ':' + seconds);
                                                      timer2 = minutes + ':' + seconds;
                                                    }, 1000);
                                                        });
                                                    </script>
                                                    <div class="color time_<?=$offer_id?>">
                                                        <strong>Time left: <span class="countdown_<?=$offer_id?>" data-value="accept" data-amount="<?=$nft->offer_amount?>" data-nftid="<?=$nft->nftid?>" data-offer_id="<?=$offer_id?>"></span></strong>
                                                    </div>
                                                    <?php 
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    if($nft->status == 3)
                                                    {
                                                        ?>
                                                        <p class="sold_bg_you"> In Progress </p>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <a href="javascript:void(0);" class="ddd" data-value="accept" data-amount="<?=$nft->offer_amount?>" data-nftid="<?=$nft->nftid?>" data-offer_id="<?=$offer_id?>"> <i class="fas fa-user-check"></i> Accept</a> &nbsp;
                                                        <a href="javascript:void(0);" class="ddd" data-value="reject" data-amount="<?=$nft->offer_amount?>" data-nftid="<?=$nft->nftid?>" data-offer_id="<?=$offer_id?>"> <i class="fas fa-user-times"></i> Reject</a>
                                                        <?php 
                                                    }
                                                    ?>
                                                </td>
                                                <!--<td><i class="fas fa-eye"></i> <a href="{{route('nft.demanddetails', [$nft->nftid])}}?amount={{$nft->offer_amount}}" style="color:#EECB1C;font-weight:500;font-size: 16px;text-decoration:underline;">View</a></td>-->
                                            </tr>
                                           <?php
                                        }
                                    }
                                    $count++;
                                }
                               ?>
							</tbody>
						</table>
					</div>
					<!--Mobile-Table-View-->
					@php
                    $count = 1;
                    foreach($allOffers as $nft)
                    {
                        if($nft->status != 4 && $user->creator_id == $nft->owner_id)
                        {
                            $offer_id = $nft->id;
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
                                            <h3 class="price_tag"><span class="current_bid">Offer Amount</span><i class="fa fa-rupee-sign"></i>{{number_format($nft->offer_amount,2)}}
                                            <?php
                                                $waitingtime = $nft->created_at->addMinutes(15);
                                                $timeinterval = date("i:s", strtotime($waitingtime));
                                                ?>
                                                <script>
                                                jQuery(document).ready(function($){
                                                   function rejectedafter15minutes(attribute)
                                                    {
                                                        $(".loading-overlay").addClass("is-active");
                                                        var whichtr = attribute.closest("tr");
                                                        var nftid = attribute.attr('data-nftid');
                                                        var amount = attribute.attr('data-amount');
                                                        var offerid = attribute.attr('data-offer_id');
                                                        $.ajaxSetup({
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            }
                                                        });
                                                        $.ajax({
                                                            type:'POST',
                                                            url:"{{ route('nft.removefifteenminutesoldrecord') }}",
                                                            data:{nftid:nftid,status:"reject",offerid:offerid,amount:amount},
                                                            success:function(data)
                                                            {
                                                                $(".loading-overlay").removeClass("is-active");
                                                                if(data == "rejected")
                                                                {
                                                                    whichtr.remove();
                                                                    location.reload();
                                                                }
                                                            }
                                                        });
                                                    } 
                                                
                                                
                                                var timer2 = "{{$timeinterval}}";
                                                var interval = setInterval(function() {


                                                  var timer = timer2.split(':');
                                                  //by parsing integer, I avoid all extra string processing
                                                  var minutes = parseInt(timer[0], 10);
                                                  var seconds = parseInt(timer[1], 10);
                                                  --seconds;
                                                  minutes = (seconds < 0) ? --minutes : minutes;
                                                  if (minutes < 0){ clearInterval(interval); rejectedafter15minutes($('.countdown_<?=$offer_id?>')); return false; };
                                                  seconds = (seconds < 0) ? 59 : seconds;
                                                  seconds = (seconds < 10) ? '0' + seconds : seconds;
                                                  //minutes = (minutes < 10) ?  minutes : minutes;
                                                  $('.countdown_<?=$offer_id?>').html(minutes + ':' + seconds);
                                                  timer2 = minutes + ':' + seconds;
                                                }, 1000);
                                                    });
                                                </script>
                                            </h3>
                                            <p class="sold_bg_you">
                                            <div class="color time_<?=$offer_id?>">
                                                    <strong>Time left: <span class="countdown_<?=$offer_id?>" data-value="accept" data-amount="<?=$nft->offer_amount?>" data-nftid="<?=$nft->nftid?>" data-offer_id="<?=$offer_id?>"></span></strong>
                                                </div>
                                            <?php 
                                            if($nft->status == 3)
                                            {
                                                ?>
                                                In Progress
                                                <?php
                                            }else{
                                                ?>
                                                <a href="javascript:void(0);" class="ddd" data-value="accept" data-amount="<?=$nft->offer_amount?>" data-nftid="<?=$nft->nftid?>" data-offer_id="<?=$offer_id?>"> <i class="fas fa-user-check"></i> Accept</a> &nbsp;
                                                <a href="javascript:void(0);" class="ddd" data-value="reject" data-amount="<?=$nft->offer_amount?>" data-nftid="<?=$nft->nftid?>" data-offer_id="<?=$offer_id?>"> <i class="fas fa-user-times"></i> Reject</a>
                                                <?php 
                                            }
                                            ?>
                                            </p>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<script>
jQuery( document ).ready( function($)
{
    $(".ddd").on("click", function()
    {
        $(".loading-overlay").addClass("is-active");
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
                $(".loading-overlay").removeClass("is-active");
                if(data == "rejected")
                {
                    whichtr.remove();
                    return false;
                }
                if(data == "accepted")
                {
                    console.log(data);
                    window.location.href = "{{route('creator.soldbyme')}}";
                }
                
                if(data == "nofunds")
                {
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Buyer not have enough balance in his wallet. You have to wait for 5 hours atleast. Whenever he update his wallet you got your payment.',
                      footer: 'NFT-X Team!'
                    });
                    
                    setTimeout(function(){ location.reload(); }, 2500);
                }
                
                if(data == "waiting")
                {
                    Swal.fire({
                      icon: 'success',
                      title: 'Offer Accepted...',
                      text: 'Buyer not have enough balance in his wallet. You have to wait for 5 hours atleast. Whenever he update his wallet you got your payment.',
                      footer: 'NFT-X Team!'
                    });
                    
                    setTimeout(function(){ location.reload(); }, 2500);
                }
            }
        });
    });
    
    
});
</script>