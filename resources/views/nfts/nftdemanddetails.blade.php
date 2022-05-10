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
						<h3>{{ $nfts->title }} <span class="demand_title">({{ ucfirst($nfts->type) }} supply)</span></h3>
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
								<div class="demand_supply">
									<ul>
										<li><img src="{{ URL::asset('public/assets/dashboard/images/van.png'); }}" style="width:36px;"></li>
										<li>
											<h4>On Demand Supply</h4>
										</li>
									</ul>
								</div>
								<div class="purchase-latest">
									<ul>
										<li>
											<div class="purchase-price">
												<h4>Highest Offer</h4>
												<h3>&#8377;{{number_format($highestOffer,2)}}</h3>
											</div>
										</li>
										<li>	
											<div class="purchase-price">
												<h4>Total Offers</h4>
												<h3><a style="color:#f9f9f9;" href="{{route('nft.alloffers', [$nfts->nftid])}}">{{$nfts->offercount}}</a></h3>
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

<script>
jQuery( document ).ready( function($)
{
    $(".acceptOffer").on("click", function()
    {
        var nftid = $(this).attr("data-nft-id");
        var status = $(this).attr("data-status");
        var offerid = $(this).attr("data-offer-id");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'POST',
            url:"{{ route('offers.acceptedrejected') }}",
            data:{nftid:nftid,status:status,offerid:offerid},
            success:function(data)
            {
                $('.success-message').show("slow");
                $('.success-message').html("Offer Accepted!");
                $('.success-message').fadeIn('slow', function(){
                   $('.success-message').delay(3000).fadeOut(); 
                    window.location.href = "{{route('creator.soldbyme')}}";
                });
            }
        });
    });
    
    $(".rejectoffer").on("click", function()
    {
        var nftid = $(this).attr("data-nft-id");
        var status = $(this).attr("data-status");
        var offerid = $(this).attr("data-offer-id");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'POST',
            url:"{{ route('offers.acceptedrejected') }}",
            data:{nftid:nftid,status:status,offerid:offerid},
            success:function(data)
            {
                $('.success-message').show("slow");
                $('.success-message').html("Offer Rejected!");
                $('.success-message').fadeIn('slow', function(){
                   $('.success-message').delay(3000).fadeOut(); 
                    window.location.href = "{{route('nft.alloffers',['nftid' => $nfts->nftid])}}";
                });
            }
        });
    });
});
</script>