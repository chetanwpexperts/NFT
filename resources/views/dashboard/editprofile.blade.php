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
						<h3>Edit Profile</h3>
					</div>
                    @include('flash-message')
					<form id="updateprofle" action="" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                            <?php
                            $user_avatar = "";
                            if($user->dp == "")
                            {
                                $user_avatar = asset("storage/app/public/".$user->avatar);
                            }else{
                                $user_avatar = asset("storage/app/public/".$user->dp);
                            }
                            ?>
                            <label class="display_text">Profile Picture</label>
                            <input type="file" name="dp" id="dp" class="form-control js-labelFile" placeholder="image" style="display:none" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            <button class="imp_btn" id="OpenImgUpload">
                                <img id="blah" src="{{$user_avatar}}" height="112px" width="112px">
                                <span id="spnFilePath"></span>
                                <div class="changetext">Change Profile Picture</div>
                            </button>
                        </div>
					  <div class="form-group">
						<label for="displayname">Display Name</label>
						<input id="displayname" type="text" class="form-control" name="name" value="{{$user->name}}" required>
					  </div>
					  <!-- <div class="form-group">
						<label for="exampleInputEmail1">Password</label>
						<input id="conf_pass" type="password" class="form-control" name="conf_pass" value="" placeholder="Confirm Password" required>
						<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
					  </div> -->
					  
					  <div class="update-btn-new">
						<button type="submit" name="submit" class="post-auction" id="updateprofile">Update</button>
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