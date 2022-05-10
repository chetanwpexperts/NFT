 <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ URL::asset('public/assets/dashboard/plugins/jquery/jquery.min.js'); }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ URL::asset('public/assets/dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js'); }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<!-- overlayScrollbars -->
<script src="{{ URL::asset('public/assets/dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); }}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('public/assets/dashboard/dist/js/adminlte.js'); }}"></script>

<script src="{{ URL::asset('public/assets/dashboard/plugins/dateplugin/datepicker.js'); }}" type="text/javascript"></script>
<script>
	$(document).on('click', '.nav-link', function(){
		if($('body').hasClass('sidebar-collapse')) {
			$('.brand-link .brand-image').hide();
			$('.brand-link .nav-link').addClass('nav-link-collapse');
		} else {
			$('.brand-link .brand-image').show();
			$('.brand-link .nav-link').removeClass('nav-link-collapse');
		}
	});
	$(document).on("mouseover", ".main-sidebar", function(){
		if($('body').hasClass('sidebar-collapse')) {
			$('.brand-link .brand-image').show();
			$('.brand-link .nav-link').removeClass('nav-link-collapse');
		}
	});
	$(document).on("mouseout", ".main-sidebar", function(){
		if($('body').hasClass('sidebar-collapse')) {
			$('.brand-link .brand-image').hide();
			$('.brand-link .nav-link').addClass('nav-link-collapse');
		}
	});
</script>
<script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap'
    });

    $('#timepicker').timepicker({
        
        onHourShow: function( hour ) { 
            var now = new Date();
            // compare selected date with today
            if ( $('#datepicker').val() == $.datepicker.formatDate ( 'Y-m-ds', now ) ) {
                if ( hour <= now.getHours() ) {
                    alert("Pleae choose greater then now");
                    return false;
                }
            }
        }
    });
    </script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
jQuery( document ).ready( function($) 
{
    $('body').on('click','#rzp-button1',function(e)
    {
        e.preventDefault();
        var amount = $('.amount').val();
        var creator_id = $(this).attr("data-creator-id");
        var total_amount = parseFloat(amount * 100).toFixed(2);
        var options = {
            "key": "{{ env('RAZORPAY_KEY') }}", // Enter the Key ID generated from the Dashboard
            "amount": total_amount, // Amount is in currency subunits. Default currency is INR. Hence, 10 refers to 1000 paise
            "currency": "INR",
            "name": "NFTX",
            "description": "Test Transaction",
            "image": "{{ URL::asset('public/assets/img/logo.png'); }}",
            "order_id": "", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
            "handler": function (response){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:'POST',
                    url:"{{ route('wallet.updatewallet') }}",
                    data:{razorpay_payment_id:response.razorpay_payment_id,amount:amount, user_id:creator_id},
                    success:function(data)
                    {
                        $('.success-message').text(data.success);
                        $('.success-alert').fadeIn('slow', function(){
                           $('.success-alert').delay(5000).fadeOut(); 
                            location.reload();
                        });
                        $('.amount').val('');
                    }
                });
            },
            "prefill": {
                "name": "{{$user->name}}",
                "email": "{{$user->email}}",
                "contact": "{{$user->phone}}"
            },
            "notes": {
                "address": "test test"
            },
            "theme": {
                "color": "#F37254"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    });
    
    
    $("#clearall").on("click", function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'POST',
            url:"{{ route('nft.clearnotifications') }}",
            success:function(data)
            {
                $(".noification").remove();
            }
        });
        
        return false;
        
    });
    
    setInterval(function(){
        checkpending();
        checkwinnerwallets();
        checkexpirednfts();
        accountactivities();
        countniti();
    },10000);
    
    function checkpending()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'GET',
            url:"{{ route('auth.pendingpayments') }}",
            success:function(data)
            {
                return true;
            }
        });
    }
    
    function checkwinnerwallets()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'GET',
            url:"{{ route('auction.checkwinnerwallets') }}",
            success:function(data)
            {
                return true;
            }
        });
    }
    
    function checkexpirednfts()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'GET',
            url:"{{ route('auction.checkexpirednfts') }}",
            success:function(data)
            {
                return true;
            }
        });
    }
    
    function accountactivities()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'GET',
            url:"{{ route('auction.checklogs') }}",
            success:function(data)
            {
                $(".logs").html(data);
            }
        });
    }
    
    function countniti()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'GET',
            url:"{{ route('auction.countnotifications') }}",
            success:function(data)
            {
                $(".logcount").html(data);
            }
        });
    }
    
    $( document ).on("click", ".notif", function(e){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'POST',
            url:"{{ route('offers.notificationststus') }}",
            data: {nid: $(this).attr('data-id')},
            success:function(data)
            {
                console.log(data);
            }
        });
    });
    
    $('html, body').animate({
        scrollTop: $(".alert-danger").offset().top
    }, 2000);
    
    setTimeout( function(){ $(".alert-danger").remove() }, 3000);
    
    
});
    
function PreviewAudio(inputFile, previewElement) {

    if (inputFile.files && inputFile.files[0] && $(previewElement).length > 0) {

        $(previewElement).stop();

        var reader = new FileReader();

        reader.onload = function (e) {

            $(previewElement).attr('src', e.target.result);
            var playResult = $(previewElement).get(0).play();

            if (playResult !== undefined) {
                playResult.then(_ => {
                    // Automatic playback started!
                    // Show playing UI.

                    $(previewElement).show();
                })
                    .catch(error => {
                        // Auto-play was prevented
                        // Show paused UI.

            $(previewElement).hide();
                        alert("File Is Not Valid Media File");
                    });
            }
        };

        reader.readAsDataURL(inputFile.files[0]);
    }
    else {
        $(previewElement).attr('src', '');
        $(previewElement).hide();
        alert("File Not Selected");
    }
}
    
document.getElementById("file").onchange = function(event) 
{
    var category_type = $("#category").val();

    if(category_type == "video")
    {

        $("#vpreview").show();
        let file = event.target.files[0];
        let blobURL = URL.createObjectURL(file);
        document.querySelector("video").src = blobURL;
        $(".js-fileName").css({"opacity":"-0.1"});
        $(".duration").css({"opacity":"-0.1"});
        $(".imgpreviewsection").hide();
        $(".videopreviewsection").show();
        $(".audiopreviewsection").hide();
    }else if(category_type == "audio"){
        $("#apreview").show();
        let file = event.target.files[0];
        let blobURL = URL.createObjectURL(file);
        document.querySelector("audio").src = blobURL;
        $(".js-fileName").css({"opacity":"-0.1"});
        $(".duration").css({"opacity":"-0.1"});
        $(".imgpreviewsection").hide();
        $(".videopreviewsection").hide();
        $(".audioicon").attr("src", "{{ URL::asset('public/assets/img/audio_tow.gif'); }}");
        $(".audiopreviewsection").show();
    }else{
        var imageID = document.getElementById('blah');
        imageID.src = URL.createObjectURL(this.files[0]);
        imageID.onload = function() {
            URL.revokeObjectURL(imageID.src) 
        }
        $(".js-fileName").css({"opacity":"-0.1"});
        $(".duration").css({"opacity":"-0.1"});
        $(".imgpreviewsection").show();
        $(".previewimg").show();
        $(".videopreviewsection").hide();
        $(".audiopreviewsection").hide();
    }
}
</script>
</body>
</html>
