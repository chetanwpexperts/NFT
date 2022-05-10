<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>NFT</title>
    <meta name="google-site-verification" content="K5lvzr81kRI2jSZo27EsZ1zUwiWWJMftO6mOnl15XOw" />
    <link rel="stylesheet" href="{{ URL::asset('public/assets/dashboard/plugins/fontawesome-free/css/all.min.css'); }}">
    <!--CSS-->
    <link href="{{ URL::asset('public/assets/css/bootstrap.min.css'); }}" rel="stylesheet">
	<link href="{{ URL::asset('public/assets/css/animate.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/style.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/responsive.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/font-awesome.min.css'); }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="{{ URL::asset('public/assets/css/nft.css'); }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
      <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-BBJ0SR0TTS');
    </script>
  </head>
  <body class="bg">
  <div id="loader-wrapper">
  			<div id="loader"></div>

  			<div class="loader-section section-left"></div>
              <div class="loader-section section-right"></div>

  		</div>

	<!--Mobile-header-Section-->
	<section id="mob_section" class="mob_height">
		
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-sm-3">
					<div class="logo-div">
                        <a href="{{ url('/') }}"><img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/></a>
					</div>
				</div>
				<div class="col-lg-9 col-sm-9">
					
					<div class="top-links fullwidth">
						<ul>
							<li><a href="{{route('nft.marketplace')}}">Marketplace</a></li>
							@if (Auth::guest())
                                <li><a href="{{ route('login') }}"><u>Sign In</u></a></li>
                            @else
                                <li>
                                    <div class="dropdown">
                                        <a class="btn dropdown-toggle" href="javascipt:void(0);" id="dropdownMenu1" data-toggle="dropdown">
                                        <?php 
                                        $avatar = $user->dp;
                                        if($avatar == "")
                                        {
                                            $avatar = "users/default.png";
                                        }
                                        $user_avatar = asset("storage/app/public/".$avatar);  
                                        ?>
                                        <img class="imgg_user" src="{{$user_avatar}}" style="border-radius:50%;"> {{$user->name}}
                                        </a>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            <li><a href="{{ route('auth.dashboard') }}"><i class="icon-envelope icon-large"></i>Dashboard</a></li>
                                            <li><a href="{{ route('nft.favourites') }}"><i class="icon-envelope icon-large"></i>Favourite NFTs</a></li>
                                            <li><a href="{{ route('logout') }}"><i class="icon-truck icon-large"></i>Logout</a></li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
							<li>
								<p class="searchBtnTop search-trigger">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
		</div>
	</section>

  	<!--NFT Listing-->
	<section id="inner-header">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-sm-5">
					<div class="inner-logo">
						<a href="{{ url('/') }}"><img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/></a>
					</div>	
				</div>
				<div class="col-lg-9 col-sm-7">
					<div class="top-links inner-header-link">
						<ul>
							<li><a href="{{route('nft.marketplace')}}">Marketplace</a></li>
							@if (Auth::guest())
                                <li><a href="{{ route('login') }}"><u>Sign In</u></a></li>
                            @else
                                <li style="width: 18%;">
                                    <div class="dropdown">
                                        <a class="btn dropdown-toggle" href="javascipt:void(0);" id="dropdownMenu1" data-toggle="dropdown">
                                        <?php 
                                        $avatar = $user->dp;
                                        if($avatar == "")
                                        {
                                            $avatar = "users/default.png";
                                        }
                                        $user_avatar = asset("storage/app/public/".$avatar);  
                                        ?>
                                        <img class="imgg_user" src="{{$user_avatar}}" style="border-radius:50%;"> {{$user->name}}
                                        </a>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            <li><a href="{{ route('auth.dashboard') }}"><i class="icon-envelope icon-large"></i>Dashboard</a></li>
                                            <li><a href="{{ route('nft.favourites') }}"><i class="icon-envelope icon-large"></i>Favourite NFTs</a></li>
                                            <li><a href="{{ route('logout') }}"><i class="icon-truck icon-large"></i>Logout</a></li>
                                        </ul>
                                    </div>
                                </li>
                            @endif
						</ul>
				</div>	
				</div>
			</div>

		</div>
	</section>
	
	@yield('content')

	<!--Footer Section-->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-sm-6 desk_off">
					<div class="footer-logo">
						<img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/>
					</div>
					<div class="footer-content">
						<p>The world’s first and largest digital marketplace for crypto collectibles and non-fungible tokens (NFTs). Buy, sell, and discover exclusive digital assets.</p>
					</div>
					<div class="social_connect">
						<h4>Social Connectivity</h4>
					</div>
					<div class="social_links">
						<ul>
							<li>
                                <a href="https://www.instagram.com/nftx_india/"><img src="{{ URL::asset('public/assets/img/instagram.png'); }}"/></a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/company/nft-x"><img src="{{ URL::asset('public/assets/img/linkedin_icon.png'); }}"/></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/nftxindia"><img src="{{ URL::asset('public/assets/img/twitter_icon.png'); }}"/></a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/nftxindia/"><img src="{{ URL::asset('public/assets/img/facebook.png'); }}"/></a>
                            </li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="footer-link-title">
						<div class="social_connect-1">
							<h4>Other Pages</h4>
						</div>
						<ul>
							<li><a href="javascript:void(0);">Blog</a></li>
                            <li><a href="{{route('nft.about')}}">About</a></li>
							<li><a href="{{route('nft.contact')}}">Contact</a></li>
                            <li><a href="{{route('nft.refundcancelation')}}">Refund & Cancelation Policy</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6 mob_on">
					<div class="footer-logo">
						<img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/>
					</div>
					<div class="footer-content">
						<p>The world’s first and largest digital marketplace for crypto collectibles and non-fungible tokens (NFTs). Buy, sell, and discover exclusive digital assets.</p>
					</div>
					<div class="social_links">
						<ul>
							<li>
                                <a href="https://www.instagram.com/nftx_india/"><img src="{{ URL::asset('public/assets/img/instagram.png'); }}"/></a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/company/nft-x"><img src="{{ URL::asset('public/assets/img/linkedin_icon.png'); }}"/></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/nftxindia"><img src="{{ URL::asset('public/assets/img/twitter_icon.png'); }}"/></a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/nftxindia/"><img src="{{ URL::asset('public/assets/img/facebook.png'); }}"/></a>
                            </li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="footer-link-title cat_mob">
						<div class="social_connect-2">
							<h4>Important Links</h4>
						</div>
						<ul>
                            <li><a href="{{ url('/registration') }}">Sign Up</a></li>
                            <li><a href="{{ route('nft.faq') }}">FAQ</a></li>
                            <li><a href="{{route('nft.marketplace')}}">Marketplace</a></li>
							<li><a href="{{route('nft.refundcancelation')}}">Refund & Cancelation Policy</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>
      
    <div id="copyright_div">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-sm-6">
				     <div class="copyright_text">
						<p>2021 - 2022 NFT-X - INVI India Pvt. Ltd.</p>
                        <p>Designed & Developed By <font color="#339f3b">Webtenor Apps</font></p>
					 </div>
				</div>
				<div class="col-lg-6 col-sm-6">
				     <div class="copyright_text_links">
						<ul>
							<li><a href="{{route('nft.ppolicy')}}">Privacy Policy</a></li>
							<li><a href="{{route('nft.terms')}}">Terms & Conditions</a></li>
						</ul>
					 </div>
				</div>
			</div>
		</div>
	</div>

			
    <script src="{{ URL::asset('public/assets/js/jquery.js'); }}"></script>
    <script src="{{ URL::asset('public/assets/js/bootstrap.min.js'); }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
    <script src="{{ URL::asset('public/assets/js/top.js'); }}"></script>
    <script src="{{ URL::asset('public/assets/js/wow.min.js'); }}"></script>
    <script src="https://player.vimeo.com/api/player.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        new WOW().init();
    </script>
	<script>
		$(document).ready(function() {
			$("#news-slider").owlCarousel({
				items : 3,
				itemsDesktop:[1199,3],
				itemsDesktopSmall:[980,2],
				itemsMobile : [600,1],
				navigation:true,
				navigationText:["",""],
				pagination:true,
				autoPlay:true
			});
		});
		
		$(document).ready(function() {
			$("#news-slider-1").owlCarousel({
				items : 3,
				itemsDesktop:[1199,3],
				itemsDesktopSmall:[980,2],
				itemsMobile : [600,1],
				navigation:true,
				navigationText:["",""],
				pagination:true,
				autoPlay:true
			});
            
            setTimeout(function(){
                $('body').addClass('loaded');
            }, 3000);
		});
        
        $(document).ready(function() {
			$("#news-slider-2").owlCarousel({
				items : 3,
				itemsDesktop:[1199,3],
				itemsDesktopSmall:[980,2],
				itemsMobile : [600,1],
				navigation:true,
				navigationText:["",""],
				pagination:true,
				autoPlay:true
			});
            
            setTimeout(function(){
                $('body').addClass('loaded');
            }, 3000);
		});
		
		
	</script>
	<script>
            $(document).ready(function() {
       

            $(".search-trigger").on('click', function(e) {
                $(".search-form-wrapper").toggleClass('open');
              });
                
                $( document ).on('click', ".nftx", function(e)
                {
                    var nftid = $(this).attr("data-nftid");
                    var rowid = $(this).attr("data-rowid");
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{route('nft.addviews')}}",
                        data: {'_token':'{{ csrf_token() }}',nftid:nftid, rowid:rowid},
                        success: function(response)
                        { 
                            if(response == 1)
                            {
                                return true;
                            }else{
                                e.preventDefault();
                            }
                        }
                    });
                });
                
                $("#auction").on("click", function(){
                    $(this).addClass("auctionbtnlink");
                    $("#demand").removeClass("demandbtnlink");
                });
                
                $("#demand").on("click", function(){
                    $(this).addClass("demandbtnlink");
                    $("#auction").removeClass("auctionbtnlink");
                });
				
				$('audio,video').each(function(){
				   $(this).volume = 0.0;
				});

            });
          </script>
      
      <script>
	jQuery( document ).ready( function($){
		$( "#slider-range" ).slider({
			range: true,
			min: 0,
			max: 100000,
			values: [ 1, 100000 ],
			slide: function( event, ui ) {
				$( "#amount" ).val( "₹" + ui.values[ 0 ] + " - ₹" + ui.values[ 1 ] );
                $( "#amounthidden" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
			}
		});
		$( "#amount" ).val( "₹" + $( "#slider-range" ).slider( "values", 0 ) +
			" - ₹" + $( "#slider-range" ).slider( "values", 1 ) );

		$( "#slider-range1" ).slider({
			range: true,
			min: 0,
			max: 100000,
			values: [ 1, 100000 ],
			slide: function( event, ui ) {
				$( "#amount1" ).val( "₹" + ui.values[ 0 ] + " - ₹" + ui.values[ 1 ] );
                $( "#amounthidden" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
			}
		});
		$( "#amount1" ).val( "₹" + $( "#slider-range1" ).slider( "values", 0 ) +
			" - ₹" + $( "#slider-range1" ).slider( "values", 1 ) );
	} );
	</script>
	<script>
		$(document).ready(function () {
        $(".object_title_new").click(function () {
            $(".content_info_div").toggle(500);

        });

        $(".arrow-up").click(function () {
            if ($('.report-content').css('display') == 'none') {
                $(".arrow-up img").attr('src', 'assets/img/filter_icon.png');
            } else {
                $(".arrow-up img").attr('src', 'assets/img/filter_icon.png');
            }
            $(".report-content").toggle(600);
            console.log($('.report-content').css('display'));


        });
            
            
        $("#commentForm").on('submit', function(e)
        {
            e.preventDefault();
            var user_id = $("#commentBtn").attr('data-creatorid');
            var nftid = $("#commentBtn").attr('data-nftid');
            var comment = $("#comment").val();
            $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
            $.ajax({
                url: "{{ route('comments.add') }}",
                type: 'POST',
                data: {comment:comment,user_id:user_id,nftid:nftid},
                success: function(response)
                {
                    if(response == 2)
                    {
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'You are not logged In',
                          footer: 'Please Login'
                        });
                    }else if(response == 0){
                        Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Somehting went wrong!',
                          footer: 'Please contact with administrator!'
                        })
                    }else{
                        console.log(response);
                        $(".commentdiv").append(response);
                        $("#comment").val('');
                    }
                }
            });
            
            return false;
        });
            
        var _token = $('meta[name="csrf-token"]').attr('content');
        var nftid = $('#nftid').val();
        load_data(nftid, _token);

        function load_data(nftid, _token)
        {
            $.ajax({
                url:"{{ route('loadmore.load_data') }}",
                method:"POST",
                data:{nftid:nftid,_token:_token},
                success:function(data)
                {
                    $('#load_more_button').remove();
                    $('.commentdiv').append(data);
                }
            });
        }

        $(document).on('click', '#load_more_button', function(){
            var nftid = $('#nftid').val();
            $('#load_more_button').html('<b>Loading...</b>');
            load_data(nftid, _token);
        });
            
        $("#auction").on("click", function(e) 
        {
            var val = $(this).attr("data-val");
            $("#keyword").val(val);
        });
        $("#demand").on("click", function(e) 
        {
            var val = $(this).attr("data-val");
            $("#keyword").val(val);
        });
            
        $("#placebidform").on('submit', function(e)
        {
            $(".fa-spin").show();
            e.preventDefault();
            var action = $("#action").val();
            $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
            });
            $.ajax({
                url: action,
                type:'POST',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(response)
                {
                    if(response == '99')
                    {
                        var message = "You don't have permission to bid. Please login first or register yourself if you don't have an account with us.";  
                        $("#mesagediv").show();
                        $(".alert-success").html(message);
                        setTimeout( function()
                        {
                            window.location.href = "{{route('login')}}";
                        }, 2000);
                    }else{
                        $("#mesagediv").show();
                        $(".alert-success").html(response);
                        $(".fa-spin").hide();
                    }
                }
            });
            
            return false;
        });
            
            $('.numberonly').keypress(function (e) {    
    
                var charCode = (e.which) ? e.which : event.keyCode    
    
                if (String.fromCharCode(charCode).match(/[^0-9]/g))    
    
                    return false;                        
    
            });  

    });
        
        $(function () {
            $(".loaddata").slice(0, 3).show();
            $("#loadmore").on('click', function (e) {
                e.preventDefault();
                $(".loaddata:hidden").slice(0, 3).slideDown();
                if ($(".loaddata:hidden").length == 0) {
                    $("#load").fadeOut('slow');
                }
                $('html,body').animate({
                    scrollTop: $("#loadmore").offset().top
                }, 2500);
            });
        });
        
        function checkifnftsoldout(nftid)
        {
            $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
            });
            $.ajax({
                url: action,
                type:'POST',
                data:  {nftid:nftid},
                success: function(response)
                {
                    if(response == '99')
                    {
                        var message = "You don't have permission to bid. Please login first or register yourself if you don't have an account with us.";  
                        $("#mesagediv").show();
                        $(".alert-success").html(message);
                        setTimeout( function()
                        {
                            window.location.href = "{{route('login')}}";
                        }, 2000);
                    }else{
                        $("#mesagediv").show();
                        $(".alert-success").html(response);
                        $(".fa-spin").hide();
                    }
                }
            });
            
            return false;
        }
	</script>
      @if (Auth::guest())
    <script></script>     
@else
    <script>
    jQuery( document ).ready( function() 
    {
        $( document ).on("click", ".changeclass", function(){
                $(this).removeClass('far');
                $(this).addClass('fas');
                return false;
            });
        $( document ).on('click', ".favouritesingle", function(e)
        {
            $(this).addClass("fas fa-heart");
            $(this).addClass("added");
            $(this).parents(".owl-item").find(".chk").val(1);
            var rowid = $(this).attr("data-number");
            var nftid = $(this).attr("data-nftid");
            var val = $(this).parents(".owl-item").find(".chk").val();
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{route('nft.addfavourite')}}",
                data: {'_token':'{{ csrf_token() }}',id:nftid, val:val},
                success: function(response)
                { 
                    console.log(response);
                }
            });

            return false;
        });

        $( document ).on('click', ".favourite", function(e)
        {
            $(this).parents(".owl-item").find(".chk").val(1);
            var nftid = $(this).attr("data-nftid");
            var rowid = $(this).attr("data-rowid");
            var val = $(this).parents(".owl-item").find(".chk").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{route('nft.addfavourite')}}",
                data: {'_token':'{{ csrf_token() }}',id:nftid, rowid:rowid, val:val},
                success: function(response)
                { 
                    $(this).parents('.owl-itme').removeClass("far fa-heart");
                    $(this).parents('.owl-itme').addClass("fas fa-heart");
                    $(this).addClass("added");
                }
            });
        });
    });
        
    function checkOnlyDigits(e)
    {
        e = e ? e : window.event;
        var charCode = e.which ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            //document.getElementById('errorMsg').style.display = 'block';
            //document.getElementById('errorMsg').style.color = 'red';
            //document.getElementById('errorMsg').innerHTML = 'OOPs! Only digits allowed.';
            return false;
        } else {
            //document.getElementById('errorMsg').style.display = 'none';
            return true;
        }
    }
    </script>
@endif
  </body>
</html>