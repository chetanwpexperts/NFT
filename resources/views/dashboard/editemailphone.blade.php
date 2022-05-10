@include('layouts.dashboard.header')
@include('layouts.dashboard.sidebar') 
<style>
button.imp_btn {
    background-color: transparent;
    border-color: transparent;
}
.creation-title form label {
    padding: 0 8px !important;
}
.update-btn-new {
   text-align: left !important;
}
</style>
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
						<h3>Edit Email And Phone</h3>
                        <div class="alert alert-success successdiv" role="alert" style="display:none;"></div>
					</div>
                    <div id="success"></div>
                    @include('flash-message')
					<form id="updatephonemail" action="" method="POST" enctype="multipart/form-data">
                      @csrf
                     <div class="form-group">
						<label for="email">Email</label>
						<input id="email" type="email" class="form-control" name="email" value="{{$user->email}}" required>
					  </div>
					  <div class="form-group">
						<label for="phone">Phone</label>
						<input id="phone" type="phone" class="form-control" name="phone" value="{{$user->phone}}" required>
					  </div>
					  <!-- <div class="form-group">
						<label for="exampleInputEmail1">Password</label>
						<input id="conf_pass" type="password" class="form-control" name="conf_pass" value="" placeholder="Confirm Password" required>
						<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					  </div> -->
					  
					  <div class="update-btn-new">
						<button type="submit" name="submit" class="post-auction" id="sentotp">Send OTP</button>
					  </div>
					</form>
				</div>
                
                <div class="creation-title" id="verifyotpdiv" style="display:none;">
                    <p>&nbsp;</p>
					<div class="creation_txt">
						<h3>Enter OTP For Verification</h3>
					</div>
					<form id="verifyotp" action="" method="POST" enctype="multipart/form-data">
                      @csrf
                     <div class="form-group">
						<label for="emailotp">Eenter Email OTP</label>
						<input id="emailotp" type="text" maxlength="6" class="form-control" name="phone_otp" value="" required>
					  </div>
					  <div class="form-group">
						<label for="phoneotp">Enter Phone OTP</label>
						<input id="phoneotp" type="text" maxlength="6" class="form-control" name="email_otp" value="" required>
					  </div>
					  
					  <div class="update-btn-new">
						<button type="submit" name="submit" class="post-auction" id="updateotps">Verify And Update</button>
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
<script>
    jQuery( document ).ready( function () 
    {
        $("#sentotp").on('click', function(e)
        {
            e.preventDefault();
            $(".loading-overlay").addClass("is-active");
            var formdata = new FormData(document.getElementById("updatephonemail"));
            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.updateprofile') }}",
                data: formdata,
                contentType: false,
            cache: false,
            processData:false,
                success: function(response)
                {
                    $(".loading-overlay").removeClass("is-active");
                    $(".successdiv").show('slow');
                    $(".successdiv").html("OTP Sent Successfully!");
                    setTimeout( function() { $(".successdiv").hide('slow'); }, 1000);
                }
            });
            return false;
        });
        
        $("#verifyotp").on('submit', function(e)
        {
            e.preventDefault();
            $(".loading-overlay").addClass("is-active");
            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.checkuserotp') }}",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(response)
                {
                    $(".loading-overlay").removeClass("is-active");
                    $(".successdiv").show('slow');
                    $(".successdiv").html("Phone Number and Email Changed successfully.");
                    setTimeout( function() { location.reload(); }, 2000);
                }
            });
            return false;
        });
    });
</script>