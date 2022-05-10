<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>NFT User Login</title>
    <!--CSS-->
    <link href="{{ URL::asset('public/assets/css/bootstrap.min.css'); }}" rel="stylesheet">
	<link href="{{ URL::asset('public/assets/css/animate.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/style.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/responsive.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/font-awesome.min.css'); }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
    <link href="{{ URL::asset('public/assets/css/nft.css'); }}" rel="stylesheet">
  </head>
  <body class="bg">
  <div id="loader-wrapper">
  			<div id="loader"></div>

  			<div class="loader-section section-left"></div>
              <div class="loader-section section-right"></div>

  		</div>
