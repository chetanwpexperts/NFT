<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NFT</title>
    <!--CSS-->
    <link href="{{ URL::asset('public/assets/css/bootstrap.min.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/animate.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/style.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/responsive.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/font-awesome.min.css'); }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
  </head>
  <body class="bg">

  	<!--Header-Banner-Section-->


	<!--Mobile-header-Section-->
	<section id="mob_section">

		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-sm-3">
					<div class="logo-div">
						<a href="{{ url('/') }}"><img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/> </a>
					</div>
				</div>
				<div class="col-lg-9 col-sm-9">

					<div class="top-links">
						<ul>
							<li><a href="{{ route('login') }}">Marketplace</a></li>
							<li><a href="#"><u>Signin</u></a></li>
							<li>
								<p class="searchBtnTop search-trigger">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<div class="banner-info wow fadeInLeft">
						<h3><span class="orange-clr">DISCOVER</span> <span class="purple-clr">COLLECT</span> <span class="blue-clr">SELF NFT's</span></h3>
						<p>on the world's first & largest NFT marketplace</p>
						<div class="btn_boxx">
							<a href="#" class="buy_btn">Buy & Sell</a>
							<a href="#" class="create_btn">Create</a>
						</div>
						<div class="scroll_down">
							<a class="down" href="#trending-section"><img src="{{ URL::asset('public/assets/img/scroll-down.png'); }}" class="img-responsive"/></a>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="banner-user wow fadeInRight">
						<img src="{{ URL::asset('public/assets/img/hero-illustration.png'); }}" class="img-responsive"/>
					</div>
				</div>
			</div>
		</div>
	</section>



	<!--Desktop-header-Section-->
	<section id="top-section">
		<div class="header_left">
			<div class="logo-div">
				<a href="{{ url('/') }}"><img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/> </a>
			</div>
		</div>
		<div class="header_right">
			<div class="top-links">
						<ul>
							<li><a href="#">Marketplace dfdf</a></li>
							<li>
								<div id="custom-search-input">
									<div class="input-group col-md-12">
										<input type="text" class="  search-query form-control" placeholder="Search" />
										<span class="input-group-btn">
											<button class="btn btn-danger" type="button">
												<span class=" glyphicon glyphicon-search"></span>
											</button>
										</span>
									</div>
								</div>
							</li>
							<li><a href="{{ route('login') }}"><u>Signin</u></a></li>
						</ul>
				</div>
		</div>
		<div class="container" style="clear:both;">
			<div class="row">
				<div class="col-lg-6 col-sm-6">
					<div class="banner-info wow fadeInLeft">
						<h3><span class="orange-clr">DISCOVER</span> <br><span class="purple-clr">COLLECT</span><br><span class="blue-clr">SELF NFT's</span></h3>
						<p>on the world's first & largest NFT marketplace</p>
						<div class="btn_boxx">
							<a href="#" class="buy_btn">Buy & Sell</a>
							<a href="#" class="create_btn">Create</a>
						</div>
						<div class="scroll_down">
							<a class="down" href="#trending-section"><img src="{{ URL::asset('public/assets/img/scroll-down.png'); }}" class="img-responsive"/></a>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-sm-6">
					<div class="banner-user wow fadeInRight">
						<img src="{{ URL::asset('public/assets/img/hero-illustration.png'); }}" class="img-responsive"/>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!--Trending Section-->
	<section id="trending-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="trend-list">
						<div class="trend-title wow fadeInLeft">
							<img src="{{ URL::asset('public/assets/img/trend-icon.png'); }}" class="img-responsive"/>
							<h3>Trending</h3>
							<p>NFTs of the Week</p>
						</div>
						<div class="slider_boxx wow fadeInRight">
							<div id="news-slider" class="owl-carousel">
								<div class="post-slide">
									<div class="first_boxx">
										<div class="owner-info">
											<h3>Owner name</h3>
											<img src="{{ URL::asset('public/assets/img/like.png'); }}"/>
										</div>
										<div class="blog_img">
											<img src="{{ URL::asset('public/assets/img/img-1.png'); }}" class="img-responsive"/>
										</div>
										<div class="list_info">
											<div class="id_badge">
												<p>Id_e9538645873</p>
											</div>
											<div class="creater_info">
												<h2>NFT_title</h2>
												<p>Creator Name</p>
												<ul class="tags">
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>

												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="post-slide">
									<div class="second_boxx">
										<div class="owner-info">
											<h3>Owner name</h3>
											<img src="{{ URL::asset('public/assets/img/like.png'); }}"/>
										</div>
										<div class="blog_img">
											<img src="{{ URL::asset('public/assets/img/img-2.png'); }}" class="img-responsive"/>
										</div>
										<div class="list_info">
											<div class="id_badge">
												<p>Id_e9538645873</p>
											</div>
											<div class="creater_info">
												<h2>NFT_title</h2>
												<p>Creator Name</p>
												<ul class="tags">
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>

												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="post-slide">
									<div class="third_boxx">
										<div class="owner-info">
											<h3>Owner name</h3>
											<img src="{{ URL::asset('public/assets/img/like.png'); }}"/>
										</div>
										<div class="blog_img">
											<img src="{{ URL::asset('public/assets/img/img-3.png'); }}" class="img-responsive"/>
										</div>
										<div class="list_info">
											<div class="id_badge">
												<p>Id_e9538645873</p>
											</div>
											<div class="creater_info">
												<h2>NFT_title</h2>
												<p>Creator Name</p>
												<ul class="tags">
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>

												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="post-slide">
									<div class="first_boxx">
										<div class="owner-info">
											<h3>Owner name</h3>
											<img src="{{ URL::asset('public/assets/img/like.png'); }}"/>
										</div>
										<div class="blog_img">
											<img src="{{ URL::asset('public/assets/img/img-1.png'); }}" class="img-responsive"/>
										</div>
										<div class="list_info">
											<div class="id_badge">
												<p>Id_e9538645873</p>
											</div>
											<div class="creater_info">
												<h2>NFT_title</h2>
												<p>Creator Name</p>
												<ul class="tags">
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>

												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="post-slide">
									<div class="second_boxx">
										<div class="owner-info">
											<h3>Owner name</h3>
											<img src="{{ URL::asset('public/assets/img/like.png'); }}"/>
										</div>
										<div class="blog_img">
											<img src="{{ URL::asset('public/assets/img/img-2.png'); }}" class="img-responsive"/>
										</div>
										<div class="list_info">
											<div class="id_badge">
												<p>Id_e9538645873</p>
											</div>
											<div class="creater_info">
												<h2>NFT_title</h2>
												<p>Creator Name</p>
												<ul class="tags">
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>

												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="post-slide">
									<div class="third_boxx">
										<div class="owner-info">
											<h3>Owner name</h3>
											<img src="{{ URL::asset('public/assets/img/like.png'); }}"/>
										</div>
										<div class="blog_img">
											<img src="{{ URL::asset('public/assets/img/img-3.png'); }}" class="img-responsive"/>
										</div>
										<div class="list_info">
											<div class="id_badge">
												<p>Id_e9538645873</p>
											</div>
											<div class="creater_info">
												<h2>NFT_title</h2>
												<p>Creator Name</p>
												<ul class="tags">
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>

												</ul>
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
	</section>






	<!--sell & earn Section-->
	<section id="sell-earn-section">
		<div class="left_section sell_desk_img">
			<div class="sell_imgs wow fadeInLeft">

			</div>
		</div>
		<div class="right_section wow fadeInRight">
			<div class="trend-title-create">
				<img src="{{ URL::asset('public/assets/img/create-icon.png'); }}" class="img-responsive"/>
				<h3>Create</h3>
				<p>Sell and Earn</p>

			</div>
			<div class="detail_boxx">
				<p class="description">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
				<div class="start_btn">
					<a href="#" class="create_btn">Start Now</a>
				</div>
			</div>
		</div>

		<!--Mobile-View-Section-->
		<div class="left_section sell_img_on">
			<div class="sell_imgs wow fadeInLeft">
				<img src="{{ URL::asset('public/assets/img/sell-img.png'); }}" class="img-responsive"/>
			</div>
		</div>

	</section>


	<!--Valued Section-->
	<section id="valued-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="trend-list">
						<div class="trend-title-value wow fadeInLeft">
							<img src="{{ URL::asset('public/assets/img/star-icon.png'); }}" class="img-responsive"/>
							<h3>Most Valued</h3>
							<p>NFTs of all time on the platform</p>
						</div>
						<div class="slider_boxx wow fadeInRight">
							<div id="news-slider-1" class="owl-carousel">
								<div class="post-slide">
									<div class="first_boxx">
										<div class="owner-info">
											<h3>Owner name</h3>
											<img src="{{ URL::asset('public/assets/img/like.png'); }}"/>
										</div>
										<div class="blog_img">
											<img src="{{ URL::asset('public/assets/img/img-1.png'); }}" class="img-responsive"/>
										</div>
										<div class="list_info">
											<div class="id_badge">
												<p>Id_e9538645873</p>
											</div>
											<div class="creater_info">
												<h2>NFT_title</h2>
												<p>Creator Name</p>
												<ul class="tags">
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>

												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="post-slide">
									<div class="second_boxx">
										<div class="owner-info">
											<h3>Owner name</h3>
											<img src="{{ URL::asset('public/assets/img/like.png'); }}"/>
										</div>
										<div class="blog_img">
											<img src="{{ URL::asset('public/assets/img/img-2.png'); }}" class="img-responsive"/>
										</div>
										<div class="list_info">
											<div class="id_badge">
												<p>Id_e9538645873</p>
											</div>
											<div class="creater_info">
												<h2>NFT_title</h2>
												<p>Creator Name</p>
												<ul class="tags">
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>

												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="post-slide">
									<div class="third_boxx">
										<div class="owner-info">
											<h3>Owner name</h3>
											<img src="{{ URL::asset('public/assets/img/like.png'); }}"/>
										</div>
										<div class="blog_img">
											<img src="{{ URL::asset('public/assets/img/img-3.png'); }}" class="img-responsive"/>
										</div>
										<div class="list_info">
											<div class="id_badge">
												<p>Id_e9538645873</p>
											</div>
											<div class="creater_info">
												<h2>NFT_title</h2>
												<p>Creator Name</p>
												<ul class="tags">
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>

												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class="post-slide">
									<div class="first_boxx">
										<div class="owner-info">
											<h3>Owner name</h3>
											<img src="{{ URL::asset('public/assets/img/like.png'); }}"/>
										</div>
										<div class="blog_img">
											<img src="{{ URL::asset('public/assets/img/img-1.png'); }}" class="img-responsive"/>
										</div>
										<div class="list_info">
											<div class="id_badge">
												<p>Id_e9538645873</p>
											</div>
											<div class="creater_info">
												<h2>NFT_title</h2>
												<p>Creator Name</p>
												<ul class="tags">
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>

												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="post-slide">
									<div class="second_boxx">
										<div class="owner-info">
											<h3>Owner name</h3>
											<img src="{{ URL::asset('public/assets/img/like.png'); }}"/>
										</div>
										<div class="blog_img">
											<img src="{{ URL::asset('public/assets/img/img-2.png'); }}" class="img-responsive"/>
										</div>
										<div class="list_info">
											<div class="id_badge">
												<p>Id_e9538645873</p>
											</div>
											<div class="creater_info">
												<h2>NFT_title</h2>
												<p>Creator Name</p>
												<ul class="tags">
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>

												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="post-slide">
									<div class="third_boxx">
										<div class="owner-info">
											<h3>Owner name</h3>
											<img src="{{ URL::asset('public/assets/img/like.png'); }}"/>
										</div>
										<div class="blog_img">
											<img src="{{ URL::asset('public/assets/img/img-3.png'); }}" class="img-responsive"/>
										</div>
										<div class="list_info">
											<div class="id_badge">
												<p>Id_e9538645873</p>
											</div>
											<div class="creater_info">
												<h2>NFT_title</h2>
												<p>Creator Name</p>
												<ul class="tags">
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>
													<li>
														<div class="tag_div">
															<a>#tags</a>
														</div>

													</li>

												</ul>
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
	</section>

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
