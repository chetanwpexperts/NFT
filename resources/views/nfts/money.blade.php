@include('layouts.dashboard.header')
@include('layouts.dashboard.sidebar')

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-6 col-12">
			<div class="money-wallet">
				<div class="wallet-title">
					<h3>Money in walletdfdf</h3>
				</div>
				<div class="wallet_money">
					<ul>
						<li><img src="{{ URL::asset('public/assets/dashboard/images/wallet-money.png'); }}" class="img-responsive money_img"/></li>
						<li><h3><i class="fa fa-inr" aria-hidden="true"></i>0.00</h3></li>
					</ul>
					
				</div>
			</div>
          </div>
		  <div class="col-lg-6 col-12">
			<div class="money-wallet">
				<div class="wallet-title">
					<h3>Payment Method</h3>
				</div>
				<div class="add_btn">
					<a href="#">Add</a>					
				</div>
			</div>
          </div>
		  <div class="col-lg-4 col-12">
			<div class="money-wallet">
				<div class="wallet-title">
					<h3>Withdraw Money</h3>
				</div>
				<div class="money_form">
					<form>
						<div class="form-group">
							<input type="text" class="form-control" id="money" aria-describedby="emailHelp" placeholder="Enter Amount">
						</div>
						<a href="#" class="btn btn_withdraw">Withdraw</a>
					</form>					
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