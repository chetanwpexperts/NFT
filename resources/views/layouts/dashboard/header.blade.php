<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="google-site-verification" content="K5lvzr81kRI2jSZo27EsZ1zUwiWWJMftO6mOnl15XOw" />
  <title>Admin Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ URL::asset('public/assets/dashboard/plugins/fontawesome-free/css/all.min.css'); }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css">
    
  <!-- Tempusdominus Bootstrap 4
  <link rel="stylesheet" href="{{ URL::asset('public/assets/dashboard/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); }}">-->
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ URL::asset('public/assets/dashboard/dist/css/adminlte.min.css'); }}">
  <link rel="stylesheet" href="{{ URL::asset('public/assets/dashboard/css/style.css'); }}">
  <link rel="stylesheet" href="{{ URL::asset('public/assets/dashboard/css/responsive.css'); }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ URL::asset('public/assets/dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'); }}">
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <link href="{{ URL::asset('public/assets/css/nft.css'); }}" rel="stylesheet">
    <style>
    .dropdown-menu.dropdown-menu-lg.dropdown-menu-right.logs.show {
        height: 270px;
        overflow: scroll;
    }
    .clearall {
        background: #a12e2e;
        padding: 0.4rem 1rem;
        border: none;
        color: #ffffff !important;
        font-weight: bold;
        border-radius: 5px;
    }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <div class="loading-overlay">
        <img class="loaderonactions" src="{{ URL::asset('public/assets/img/original.gif'); }}">
        </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
	<ul class="navbar-nav" id="menu_ot">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><img src="{{ URL::asset('public/assets/dashboard/images/menu.png'); }}" style=" width:26px;"></a>
      </li>
	  <li class="nav-item">
		<div class="nav_logo">
			<a href="{{ url('/') }}">
                <img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/></a>
		</div>
	  </li>
    </ul>
	<div class="creation_bg_top">
		<a href="{{route('nft.create')}}" class="nav-link">
             <img src="{{ URL::asset('public/assets/dashboard/images/newcreation.png'); }}"/><p>New Creation</p>
        </a>
	</div>
    <div class="creation_bg_top">
        <a href="{{route('nft.marketplace')}}" class="nav-link">
          <p>
            <i class="fas fa-bullhorn"></i> Marketplace 
              <?php 
                /*
                date_default_timezone_set("Asia/Calcutta");   //India time (GMT+5:30)
              
                $minutes_to_add = 5;

                $time = new DateTime('2021-11-20 21:22');
                $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));

                $stamp = $time->format('Y-m-d H:i');
                */
              ?>
          </p>
        </a>
    </div>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <!-- Notifications Dropdown Menu -->
	  <li class="nav-item dropdown">
        <a class="nav-link link_usr" data-toggle="dropdown" href="#">
        	<p class="username_txt">{{$user->name}}</p>
            <?php
            $user_avatar = "";
            if($user->dp == "")
            {
                $user_avatar = asset("storage/app/public/".$user->avatar);
            }else{
                $user_avatar = asset("storage/app/public/".$user->dp);
            }
            
            ?>
          <img src="{{$user_avatar}}" class="user_imgs" style="border-radius:50%;" />
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <?php 
          if($user->user_type == "")
          {
                ?>
                <a href="{{route('auth.creator')}}" class="dropdown-item">
                <span class="text-muted text-sm">Become A Creator</span>
                </a>
                <?php 
          }
          ?>
          <a href="{{route('dashboard.editprofile')}}" class="dropdown-item">
            <span class="text-muted text-sm">Edit Profile</span>
          </a>
          <a href="{{route('dashboard.editemailphone')}}" class="dropdown-item">
            <span class="text-muted text-sm">Edit Profile or Phone</span>
          </a>
          <a href="{{route('dashboard.changepassword')}}" class="dropdown-item">
            <span class="text-muted text-sm">Change Password</span>
          </a>
		  <a href="{{ route('logout') }}" class="dropdown-item">
            <span class="text-muted text-sm">Log Out</span>
          </a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
           <img src="{{ URL::asset('public/assets/dashboard/images/bell.png'); }}" style="width:22px;"/>
          <span class="badge badge-warning navbar-badge logcount">0</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right logs">
          <div class="notification">
              <a href="javascript:void(0);" data-user="<?=$user->creator_id?>" id="clearall" class="dropdown-item">
                <span class="text-muted text-sm clearall"> Clear All</span>
              </a>
              <a href="#" class="dropdown-item">
                <span class="text-muted text-sm"> No Notifications Found</span>
              </a>
              <div class="dropdown-divider"></div>
          </div>
        </div>
      </li>
      <li class="nav-item" id="logout">
        <a class="nav-link" href="{{ route('logout') }}" role="button">
          <img src="{{ URL::asset('public/assets/dashboard/images/logout.png'); }}" style="width:30px;"/>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
