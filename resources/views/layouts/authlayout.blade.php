<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="google-site-verification" content="K5lvzr81kRI2jSZo27EsZ1zUwiWWJMftO6mOnl15XOw" />
    <title>NFT</title>
    <!--CSS-->
    <link href="{{ URL::asset('public/assets/css/bootstrap.min.css'); }}" rel="stylesheet">
	<link href="{{ URL::asset('public/assets/css/animate.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/style.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/responsive.css'); }}" rel="stylesheet">
    <link href="{{ URL::asset('public/assets/css/font-awesome.min.css'); }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
    <link href="{{ URL::asset('public/assets/css/nft.css'); }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
      <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-BBJ0SR0TTS');
    </script>
  </head>
  <body class="bg">
  <div id="loader-wrapper">
  			<div id="loader"></div>

  			<div class="loader-section section-left"></div>
              <div class="loader-section section-right"></div>

  		</div>
      
      <div class="loading-overlay">
        <img class="loaderonactions" src="{{ URL::asset('public/assets/img/original.gif'); }}">
        </div>
      
      @yield('content')
      
    <!--jQuery-->
    <script src="{{ URL::asset('public/assets/js/jquery.js'); }}"></script>
    <script src="{{ URL::asset('public/assets/js/bootstrap.min.js'); }}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
	<script src="{{ URL::asset('public/assets/js/top.js'); }}"></script>
	<script src="{{ URL::asset('public/assets/js/wow.min.js'); }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
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
        $(document).ready(function()
        {
            $(".search-trigger").on('click', function(e)
            {
                $(".search-form-wrapper").toggleClass('open');
            });

           var fileupload = $("#dp");
           var filePath = $(".display_text");
           var image = $("#OpenImgUpload");
           image.click(function (ev) {
                ev.preventDefault();
               fileupload.click();
           });
           fileupload.change(function () {
               var fileName = $(this).val().split('\\')[$(this).val().split('\\').length - 1];
               filePath.html("<b>Selected File: </b>" + fileName);
           });
           $("#success-alert").hide();
           $("#error-alert").hide();
           $("#registration").on('submit', function(e)
           {
               $(".loading-overlay").addClass("is-active");

                e.preventDefault();
                $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                  }
                });
                $.ajax({
                    url: "{{ route('register.post') }}",
                    type:'POST',
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response)
                    {
                        if(response == 1)
                        {
                            $(".loading-overlay").removeClass("is-active");
                            let timerInterval
                            Swal.fire({
                              title: 'OTP sent on your email & phone number.',
                              html: 'Please Verify your email and phone number',
                              timer: 2000,
                              timerProgressBar: true,
                              didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                  b.textContent = Swal.getTimerLeft()
                                }, 100)
                              },
                              willClose: () => {
                                clearInterval(timerInterval)
                              }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) 
                                {
                                    window.location.href = "{{route('auth.verifyotp')}}";
                                }
                            })
                        }else{
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Something went wrong!',
                              footer: 'Please contact with administrator!'
                            })
                        }
                    }
                });
           });
            $("#verifyotp").on('submit', function(e)
            {
                e.preventDefault();
                $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
                });
                $.ajax({
                    url: "{{ route('auth.checkotp') }}",
                    type:'POST',
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response)
                    {
                        console.log(response);
                        if(response == 0)
                        {
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'OTP not matched!',
                              footer: 'Please check once again or you can resend it!'
                            })
                        }else{
                            let timerInterval
                            Swal.fire({
                              title: 'Phone number & email varified successfully.',
                              html: 'Please set your password.',
                              timer: 2000,
                              timerProgressBar: true,
                              didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                  b.textContent = Swal.getTimerLeft()
                                }, 100)
                              },
                              willClose: () => {
                                clearInterval(timerInterval)
                              }
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) 
                                {
                                    window.location.href = "{{route('auth.setpassword')}}";
                                }
                            })
                        }
                    }
                });
            });

            $("#setpassword").on('submit', function(e)
            {
                e.preventDefault();
                $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
                });
                $.ajax({
                    url: "{{ route('auth.updatepassword') }}",
                    type:'POST',
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response)
                    {
                        console.log(response);
                        if(response == 0)
                        {
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Somehting went wrong!',
                              footer: 'Please check your password same or contact with administrator!'
                            })
                        }else{
                            Swal.fire(
                              'Account Created.',
                              'You can login now.',
                              'success'
                            ).then((result) => {
                              // Reload the Page
                              window.location.href = "{{route('login')}}";
                            });
                        }
                    }
                });
            });

            $("#forgotbutn").on('submit', function(e)
            {
                e.preventDefault();
                $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
                });
                $.ajax({
                    url: "{{ route('auth.forgotpassword') }}",
                    type:'POST',
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response)
                    {
                        if(response == 0)
                        {
                            $("#error-alert").fadeTo(3000, 1000).slideUp(1000, function()
                            {
                                $("#error-alert").slideUp(1000);
                            });
                        }else{
                            $("#success-alert").fadeTo(3000, 1000).slideUp(1000, function()
                            {
                                $("#success-alert").slideUp(1000);
                                //window.location.href = "{{route('login')}}";
                            });
                        }
                    }
                });

                return false;
            });

            $(".usertype").on('click', function(e)
            {
                e.preventDefault();
                var usertype = $(this).attr("data-user-type");
                var user_id = $(this).attr("data-user");
                $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
                });
                $.ajax({
                    url: "{{ route('auth.updaterole') }}",
                    type:'POST',
                    data:  {user_type:usertype, id:user_id},
                    success: function(response)
                    {
                        window.location.href = "{{route('auth.creator')}}";
                    }
                });

                return false;
            });
            
            $("#creatorbtn").on('click', function(e)
            {
                $(".loading-overlay").addClass("is-active");
                var formdata = new FormData(document.getElementById("creatorform"))
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "{{route('auth.storecreator')}}",
                    data: formdata,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response)
                    { 
                        $(".loading-overlay").removeClass("is-active");
                        if(response == 1)
                        {
                            Swal.fire(
                              'Thanks for providing us Information!',
                              'Your account is ready.',
                              'success'
                            ).then((result) => {
                              window.location.href = "{{route('auth.dashboard')}}";
                            });
                            
                        }else if(response == 2){
                            Swal.fire(
                              'Become a creator request sent successfully!',
                              'Your account is ready. Create your first NFT',
                              'success'
                            ).then((result) => {
                              window.location.href = "{{route('nft.create')}}";
                            });
                        }else{
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Somehting went wrong!',
                              footer: 'Please contact with administrator!'
                            })
                        }
                    }
                });
                
                return false;
            });
            
            $("#emailId").on('change', function(e)
            {
                var email = $(this).val();
                $.ajaxSetup({
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
                });
                $.ajax({
                    url: "{{ route('useremailexists') }}",
                    type:'POST',
                    data:  {email:email},
                    success: function(response)
                    {
                        if(response == 1)
                        {
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Email Already Regsitered',
                              footer: 'Please try with another email!'
                            });
                        }else{
                            return true;
                        }
                    }
                });

                return false;
            });
            
            $("#phoneId").on('change', function(e)
            {
                var phone = $(this).val();
                $.ajaxSetup({
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
                });
                $.ajax({
                    url: "{{ route('userphoneexists') }}",
                    type:'POST',
                    data:  {phone:phone},
                    success: function(response)
                    {
                        if(response == 1)
                        {
                            Swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Phone Number Already Regsitered',
                              footer: 'Please try with another phone number!'
                            });
                        }else{
                            return true;
                        }
                    }
                });

                return false;
            });
            
            document.getElementById("vfile").onchange = function(event) 
            {
                $("#vfilnm").hide();
                //$("#vlable").hide();
                $("#preview").show();
                let file = event.target.files[0];
                let blobURL = URL.createObjectURL(file);
                document.querySelector("video").src = blobURL;
            }
        });

        jQuery( document ).ready( function($){
            setTimeout(function(){
                $('body').addClass('loaded');
            }, 3000);
        });
        
        $("#sfile").on("change", function(){
            $(".js-fileName").hide();
            $("#previewImg").show();
        });
        
        function checkOnlyDigits(e) 
        {
			e = e ? e : window.event;
			var charCode = e.which ? e.which : e.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57)) {
				//document.getElementById('errorMsg').style.display = 'block';
				//document.getElementById('errorMsg').style.color = 'red';
				//document.getElementById('errorMsg').innerHTML = 'OOPs! Only digits allowed.';
				return false;
			} else {
				//document.getElementById('errorMsg').style.display = 'none';
				return true;
			}
		}
    </script>
  </body>
</html>
