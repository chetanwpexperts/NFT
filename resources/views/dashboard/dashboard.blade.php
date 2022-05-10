@include('layouts.dashboard.header')
@extends('layouts.dashboard.sidebar')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-12">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>INR {{number_format($creatorWallet,2)}}</h3>
                <p>My Wallet</p>
              </div>
              <div class="icon">
                <img src="{{ URL::asset('public/assets/dashboard/images/inr-icon.png'); }}"/>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-12">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>INR {{number_format($totalSpent,2)}}</h3>

                <p>Total Spent</p>
              </div>
              <div class="icon icon_2">
                <img src="{{ URL::asset('public/assets/dashboard/images/inr-2.png'); }}"/>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-12">
            <!-- small box -->
            <div class="small-box bg-grey">
              <div class="inner">
                <h3>INR {{number_format($totalEarning,2)}}</h3>

                <p>Total Earnings</p>
              </div>
              <div class="icon icon_3">
                <img src="{{ URL::asset('public/assets/dashboard/images/inr-3.png'); }}"/>
              </div>
            </div>
          </div>
          <!-- ./col -->
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
