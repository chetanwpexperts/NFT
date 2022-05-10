<style>
i.fas.fa-bullhorn {
    background: rgb(195,34,170);
    background: linear-gradient(  0deg, rgba(195,34,170,0.7819502801120448) 0%, rgba(245,207,91,1) 100%);
    padding: 3px;
    font-size: 16px;
    border-radius: 4px;
    color:#11031c94;
}
</style>
<aside class="main-sidebar sidebar-nft elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
		<span style="display: inline-flex;">
			<img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive brand-image elevation-3"/>
			<div id="nav_menu_icon" class="nav-link" data-widget="pushmenu" role="button"><img src="{{ URL::asset('public/assets/dashboard/images/menu.png'); }}" style=" width: 26px; float: left;  margin-left: 25px;margin-top: 10px;"></div>
			<div class="cross_icon" data-widget="pushmenu" role="button"><img src="{{ URL::asset('public/assets/dashboard/images/cross.png'); }}" style="width:20px;"/></div>
		</span>
	</a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{route('auth.dashboard')}}" class="nav-link active">
              <img src="{{ URL::asset('public/assets/dashboard/images/dashboard.png'); }}" class="img-responsive" style="width:20px;"/>
              <p>
                Dashboard

              </p>
            </a>
          </li>
         
          <li class="nav-item">
            <a href="#" class="nav-link">
               <img src="{{ URL::asset('public/assets/dashboard/images/nft.png'); }}" class="img-responsive" style="width:20px;"/>
              <p>
                My NFTs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('creator.purchases')}}" class="nav-link">
                  <p>Purchases</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('nft.draft')}}" class="nav-link">
                  <p>Drafts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('nft.auction')}}" class="nav-link">
                  <p>In Auction</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('nft.demand')}}" class="nav-link">
                  <p>In Demand Supply</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <img src="{{ URL::asset('public/assets/dashboard/images/activity.png'); }}" class="img-responsive" style="width:20px;"/>
              <p>
                Activities
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('nft.bids')}}" class="nav-link">
                  <p>Bid Made</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('nft.offers')}}" class="nav-link">
                  <p>Offer Made</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('nft.actionpending')}}" class="nav-link">
                  <p>Action Pending</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('creator.soldbyme')}}" class="nav-link">
              <img src="{{ URL::asset('public/assets/dashboard/images/sold.png'); }}" class="img-responsive" style="width:20px;"/>
              <p>
                Sold By me
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('wallet.money')}}" class="nav-link">
             <img src="{{ URL::asset('public/assets/dashboard/images/money.png'); }}" class="img-responsive" style="width:25px;"/>
              <p>
                Money
              </p>
            </a>
          </li>
          <li class="nav-item creation_bg">
            <a href="{{route('nft.create')}}" class="nav-link">
             <img src="{{ URL::asset('public/assets/dashboard/images/newcreation.png'); }}"/><p>New Creation</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
	  <div class="creator_id">
		<p>Creator ID</p>
		<h3>{{$user->creator_id}}</h3>
	  </div>

    </div>
    <!-- /.sidebar -->
  </aside>
