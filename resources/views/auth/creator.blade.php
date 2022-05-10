@extends('layouts.authlayout')

@section('content')

   <!--SignIn-Section-->
    <section>
        <form name="creatorform" id="creatorform" method="post">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-logo">
                        <a href="{{ url('/') }}"><img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 col-sm-12 col-md-offset-2 width_70">
                    <div class="creator-title">
                        @if (Session::get('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <h3>Hurry, Few more steps to become</h3>
                        <h2><?php echo ($utype == "creator") ? "CREATOR" : "NFT USER";?></h2>
                        <?php $userlable = ($utype == "creator") ? "Creator" : "NFT User";?>
                        <h4>{{$userlable}} ID : {{$unique_creator_id}}</h4>
                    </div>
                </div>
            </div>
            <?php
            if($utype == "creator")
            {
                ?>
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-offset-3">
                        <div class="video_upload">
                            <div class="camera_icon">
                                <img src="{{ URL::asset('public/assets/img/camera_icon.png'); }}" class="img-responsive"/>
                            </div>
                            <div class="form-group">
                              <input type="file" name="vfile" id="vfile" class="input-file" accept="video/*" capture="camera" id="recorder">
                                <div id="preview" style="display:none;">
                                    <video width="320" height="150" controls id="player"></video>
                                </div>
                              <label for="vfile" class="btn btn-tertiary js-labelFile" id="vlable">
                                <span class="js-fileName" id="vfilnm"><p>Upload a video speaking your creator ID</p></span>
                                <span class="duration">Duration 5sec-10sec (Max 5 mb)</span>
                              </label>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="row">
                <div class="col-lg-12">
                    <div class="social_title_links">
                        <h4>Provide atleast 2 social media links</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 col-sm-8 col-md-offset-1">
                    <div class="col-lg-6 col-sm-6">
                        <div class="inputWithIcon inputIconBg">
                          <input type="text" name="social_media_accounts[]" placeholder="www.instagram.com/" class="form-control">
                          <p class="icon_box_new">
                            <img src="{{ URL::asset('public/assets/img/creators/instagram.png'); }}" class="img-responsive"/>
                          </p>

                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="inputWithIcon inputIconBg">
                          <input type="text" name="social_media_accounts[]" placeholder="www.facebook.com/" class="form-control">
                          <p class="icon_box_new">
                            <img src="{{ URL::asset('public/assets/img/creators/facebook.png'); }}" class="img-responsive"/>
                          </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="inputWithIcon inputIconBg">
                          <input type="text" name="social_media_accounts[]" placeholder="www.linkedin.com/" class="form-control">
                          <p class="icon_box_new">
                            <img src="{{ URL::asset('public/assets/img/creators/linkedin.png'); }}" class="img-responsive"/>
                          </p>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-sm-6">
                        <div class="inputWithIcon inputIconBg">
                          <input type="text" name="social_media_accounts[]" placeholder="www.twitter.com" class="form-control">
                          <p class="icon_box_new">
                            <img src="{{ URL::asset('public/assets/img/creators/link.png'); }}" class="img-responsive"/>
                          </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="inputWithIcon inputIconBg">
                          <input type="text" name="social_media_accounts[]" placeholder="www.pinterest.com" class="form-control">
                          <p class="icon_box_new">
                            <img src="{{ URL::asset('public/assets/img/creators/link.png'); }}" class="img-responsive"/>
                          </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-md-offset-3">
                    <?php 
                    if($utype == "creator")
                    {
                        ?>
                        <div class="become_creator">
                            <a href="#" id="creatorbtn">Click to become a <span>CREATOR</span></a>
                        </div>
                        <?php
                    }else{
                        ?>
                        <div class="become_creator">
                            <a href="#" id="creatorbtn">Click to become a <span>NFT USER</span></a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            
            <div class="alert alert-success" id="success-alert">
              <p>&nbsp;</p>
              <button type="button" class="close" data-dismiss="alert">x</button>
              <strong>Congratualtions, You have completed the verification process. Please wait for admin approval. </strong> Redirecting...
                <p>&nbsp;</p>
            </div>
            <div class="alert alert-error" id="error-alert">
                <p>&nbsp;</p>
              <button type="button" class="close" data-dismiss="alert">x</button>
              <strong>Operation failed! </strong> Somethign wrong at server side.
                <p>&nbsp;</p>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="bottom_text">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>
<script>
  var recorder = document.getElementById('recorder');
  var player = document.getElementById('player');

  recorder.addEventListener('change', function(e) {
    var file = e.target.files[0];
    // Do something with the video file.
    player.src = URL.createObjectURL(file);
  });
</script>
@endsection