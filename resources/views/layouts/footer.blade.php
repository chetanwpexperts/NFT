    <!--jQuery-->
    <script src="{{ URL::asset('public/assets/js/jquery.js'); }}"></script>
    <script src="{{ URL::asset('public/assets/js/bootstrap.min.js'); }}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
	<script src="{{ URL::asset('public/assets/js/top.js'); }}"></script>
	<script src="{{ URL::asset('public/assets/js/wow.min.js'); }}"></script>
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
                       $("#success-alert").fadeTo(2000, 500).slideUp(500, function()
                       {
                         $("#success-alert").slideUp(500);
                         window.location.href = "{{route('auth.verifyotp')}}";
                       });
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
                            $("#error-alert").fadeTo(2000, 500).slideUp(500, function()
                            {
                                $("#error-alert").slideUp(500);
                            });
                        }else{
                            $("#success-alert").fadeTo(2000, 500).slideUp(500, function()
                            {
                                $("#success-alert").slideUp(500);
                                window.location.href = "{{route('auth.setpassword')}}";
                            });
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
                            $("#error-alert").fadeTo(2000, 500).slideUp(500, function()
                            {
                                $("#error-alert").slideUp(500);
                            });
                        }else{
                            $("#success-alert").fadeTo(2000, 500).slideUp(500, function()
                            {
                                $("#success-alert").slideUp(500);
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
                            $("#error-alert").fadeTo(2000, 500).slideUp(500, function()
                            {
                                $("#error-alert").slideUp(500);
                            });
                        }else{
                            $("#success-alert").fadeTo(2000, 500).slideUp(500, function()
                            {
                                $("#success-alert").slideUp(500);
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
                        window.location.href = "{{route('auth.dashboard')}}";
                    }
                });

                return false;
            });
        });

        jQuery( document ).ready( function($){
            setTimeout(function(){
                $('body').addClass('loaded');
            }, 3000);
        });
    </script>
  </body>
</html>
