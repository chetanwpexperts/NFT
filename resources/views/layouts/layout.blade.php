<!DOCTYPE html>
<html>
<head>
    <title>NFT User Login</title>
    <link href="{{ URL::asset('public/assets/css/bootstrap.min.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/animate.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/style.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/responsive.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/font-awesome.min.css'); }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
</head>
<body class="bg">

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
								<a><img src="{{ URL::asset('public/assets/img/instagram.png'); }}"/></a>
							</li>
							<li>
								<a><img src="{{ URL::asset('public/assets/img/dribble.png'); }}"/></a>
							</li>
							<li>
								<a><img src="{{ URL::asset('public/assets/img/behance.png'); }}"/></a>
							</li>
							<li>
								<a><img src="{{ URL::asset('public/assets/img/facebook.png'); }}"/></a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="footer-link-title">
						<div class="social_connect-1">
							<h4>My Account</h4>
						</div>
						<ul>
							<li><a href="#">My Profile</a></li>
							<li><a href="#">My Orders</a></li>
							<li><a href="#">My Favourites</a></li>
							<li><a href="#">My Wallet</a></li>
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
                                <a><img src="{{ URL::asset('public/assets/img/instagram.png'); }}"/></a>
                            </li>
                            <li>
                                <a><img src="{{ URL::asset('public/assets/img/dribble.png'); }}"/></a>
                            </li>
                            <li>
                                <a><img src="{{ URL::asset('public/assets/img/behance.png'); }}"/></a>
                            </li>
                            <li>
                                <a><img src="{{ URL::asset('public/assets/img/facebook.png'); }}"/></a>
                            </li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="footer-link-title cat_mob">
						<div class="social_connect-2">
							<h4>Popular Categories</h4>
						</div>
						<ul>
							<li><a href="#">My Profile</a></li>
							<li><a href="#">My Orders</a></li>
							<li><a href="#">My Favourites</a></li>
							<li><a href="#">My Wallet</a></li>
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
						<p>2018 - 2021 Ozone Networks, Inc</p>
					 </div>
				</div>
				<div class="col-lg-6 col-sm-6">
				     <div class="copyright_text_links">
						<ul>
							<li><a href="#">Privacy Policy</a></li>
							<li><a href="#">Terms & Conditions</a></li>
						</ul>
					 </div>
				</div>
			</div>
		</div>
	</div>



	<!--Back to top-->
	<div class="scroll-top-wrapper ">
	  <span class="scroll-top-inner">
		<i class="fa fa-2x fa-arrow-circle-up"></i>
	  </span>
	</div>


	<!-- SEARCH MODAL BOX START HERE -->
        <div class="search-form-wrapper">
            <div class="search-trigger close-btn">
                <span></span>
                <span></span>
            </div>
            <form class="search-form" method="post">
                <input type="text" placeholder="Search..." value="">
                <button type="submit" class="search-btn">
                <i class="flaticon-magnifying-glass"></i>
                </button>
            </form>
        </div>
        <!-- SEARCH MODAL BOX END HERE -->


    <!--jQuery-->
    <script src="{{ URL::asset('public/assets/js/jquery.js'); }}"></script>
    <script src="{{ URL::asset('public/assets/js/bootstrap.min.js'); }}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
	<script src="{{ URL::asset('public/assets/js/top.js'); }}"></script>
	<script src="{{ URL::asset('public/assets/js/wow.min.js'); }}"></script>
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
		});


	</script>
	<script>
            $(document).ready(function() {
                $(".search-trigger").on('click', function(e) {
                    $(".search-form-wrapper").toggleClass('open');
              });

            });
          </script>
  </body>
</html>
