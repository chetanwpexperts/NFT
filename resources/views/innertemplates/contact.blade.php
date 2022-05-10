@extends('layouts.innerlayout')

@section('content')

<section id="filters">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12">
					<div class="filter_canvas text-center whitetext">
						<img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive" style="width: 10%;margin: auto;padding-top: 1rem;"/>
                        BY
                        <h4 class="whitetext">INVI INDIA PRIVATE LIMITED </h4>
					</div>
					
				</div>
			</div>
		</div>
	</section>
	
    <!--Celebs Section-->
	<section id="trending-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 whitetext">
                    <div class="pagecontent text-center"> 
                        <h4>ADDRESS: </h4>
                        <p>INVI INDIA PRIVATE LIMITED</p>
                        <p>31 Shalimar Enclave, Zirakpur, 160104</p>
                        <h4>E-MAIL:</h4>
                        <p>CUSTOMERSUPPORT@NFT-X.IN</p>
                        <h4>CHAT WITH US:</h4>
                        <p>
                        <div onclick="location.href='https://api.whatsapp.com/send?phone=+9181466 74291&amp;text=Hello';" align="center" class="whatsappbutton"><img src="{{ URL::asset('public/assets/img/whatsapp.png'); }}" style="width:5%;border-radius: 50%;box-shadow: 0px 4px 13px -8px #f9f9f9;"></div>
                        </p>
                    </div>
				</div>
			</div>
		</div>
	</section>
@endsection