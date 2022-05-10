@include('layouts.dashboard.header')
@extends('layouts.dashboard.sidebar') 

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-7 col-12">
			<div class="new-creation">
				<div class="creation-title">
					<div class="creation_txt">
						<h3>Change Password</h3>
					</div>
                    @include('flash-message')
					<form action="{{ route('dashboard.updatepassword') }}" method="POST" enctype="multipart/form-data">
                      @csrf
					  <div class="form-group">
						<label for="exampleInputEmail1">New Password</label>
						<input id="password" type="password" class="form-control" name="password" value="" placeholder="New Password" required>
						<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					  </div>
					  <div class="form-group">
						<label for="exampleInputEmail1">Confirm Password</label>
						<input id="conf_pass" type="password" class="form-control" name="conf_pass" value="" placeholder="Confirm Password" required>
						<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					  </div>
					  <div class="form-group">
						<label for="exampleInputEmail1">Current Password</label>
						<input id="current_pass" type="password" class="form-control" name="current_pass" value="" placeholder="Current Password" required>
						<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					  </div>
					  <div class="update-btn-new">
						<button type="submit" name="submit" class="post-auction">Update</button>
					  </div>
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
  <!-- /.content-wrapper -->

@include('layouts.dashboard.footer')