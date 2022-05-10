@extends('layouts.innerlayout')

@section('content')
<style>
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }

    .panel-heading [data-toggle="collapse"]:after {
        font-family: 'Glyphicons Halflings';
        content: "\e072"; /* "play" icon */
        float: right;
        color: #F58723;
        font-size: 18px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
</style>
<section id="filters">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12">
					<div class="filter_canvas text-center whitetext">
						<img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive" style="width: 10%;margin: auto;padding-top: 1rem;"/>
						<h2>FAQ</h2>
					</div>
					
				</div>
			</div>
		</div>
	</section> 
	
    <!--Celebs Section-->
	<section id="trending-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
                    <div class="pagecontent"> 
                        <div class="panel-group" id="accordion">
                            <div class="faqHeader whitetext">General questions</div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">WHAT IS NFT?</a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                       	<p>•	NON-FUNGIBLE TOKEN.</p>
                                        <p>•	NON-FUNGIBLE: means that it is one of a kind and the same cannot be interchanged with anything else.</p>
                                        <p>•	NFT means at NFT-X means conversion of Digital contents into marketable Non-Fungible Digital Tokens.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen">How to create NFT on NFT-X?</a>
                                    </h4>
                                </div>
                                <div id="collapseTen" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>•	Creation of NFT on NFT-X does not need any coding language.</p>
                                        <p>•	User has to signup on the platform and become a creator.</p>
                                        <p>•	As soon as the user has become a creator, he/she can simply click on ‘New Creation’ tab and add any Audio/Music, Image, Video/Movie, or Text.</p>
                                        <p>•	Give the said creation a title, set your base price for the same, add description and your NFT will be ready.</p>
                                        <p>•	You can also preview your NFT by clicking on Preview button, or post is for Auction or Demand Supply or save it as a Draft for future changes.</p>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEleven">Do I need coding knowledge for creating NFT?</a>
                                    </h4>
                                </div>
                                <div id="collapseEleven" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>•	NO, NFT-X provides users automated matrix which allows you to create and sell NFT’s with 0, coding knowledge.</p>
                                        <p>•	Process of creating NFT on NFT-X is very simple by just uploading your digital creation (any Music/Audio, Image, Video or Text) and we will create the NFT for you of the same.</p>

                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Does NFT-X work on Cryptocurrencies?</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        	<p>•	NFT-X works currently only in INR. NFT-X might add other currencies on our platform in future or cryptocurrencies. But the platform will always continue to have INR as an Exchange medium on our platform.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">How can I Sell an NFT on NFT-X?</a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>•	Selling an NFT can be done by the creator of NFT or by Buyer of NFT who wants to further sell the same.</p>
                                        <p>•	Sale can be made by either putting the NFT for Auction on Marketplace or by putting NFT for Demand and Supply quotes.</p>
                                        
                                        <h4>Auction on Marketplace: </h4>
                                        <p>•	Auction process requires users to provide a minimum auction price and time and date on which auction will end.</p>
                                        <p>•	The bidders can bid on the NFT at a price more than the Base price or the highest bid on the said NFT at the time of bidding. The highest bid at the time of Auction ending will selected as buyer of the NFT.</p>
                                        <p>•	The bidders must have at least 10% of the bid amount as freehold money in their wallet to bid on an NFT. The said 10% will be put on hold as soon as bid has been placed as EMD for the bid on NFT. </p>
                                        <p>•	The selected Buyer will get a notification for their bid being selected and will get 2 days’ grace period for making sure the amount they bid on the NFT is available in their Wallet.</p>
                                        <p>•	As soon as the amount of bid or part of the bid is available in the buyer’s wallet being the freehold money the same will be deducted for payment of the bid.</p>
                                        <p>•	As soon as the amount of bid is collected from the buyer’s wallet (within 2 days of selection of wallet) the said amount will be transferred to seller of NFT and the transfer of NFT will take place.</p>
                                        <p>•	If the said amount is not put into wallet within 2 days, then the amount deducted till completion of 2 days grace period inclusive of EMD will be charged as penalty charges.</p>
                                        
                                        <h4>Demand and Supply:</h4>
                                        
                                        <p>•	Demand and Supply requires creators/sellers to provide a minimum bid price on the NFT.
                                        <p>•	In demand and supply NFT’s in the market place, the prospective buyers can bid an amount on NFT at any price being equal to or higher than the base price of NFT.</p>
                                        <p>•	The offeror’s offer will be valid for 2 days for acceptance.</p>
                                        <p>•	The offeror’s need to have at least 10% of the offer amount in their wallet as freehold money. The said 10% will be put on hold from wallet of the offeror as EMD towards the bid amount. If your offer is not accepted withing 2 days of making the offer, the same will be refunded to your freehold wallet as soon as your offer expires.</p>
                                        <p>•	The offeror can only increase the offer made by him/her before in which case the differential amount of EMD (being 10% of the new offer made less 10% of the previous offer) will be charged as EMD from the freehold wallet of the offeror. If your new offer is not accepted withing 2 days of making the new offer, the total EMD will be refunded to your freehold wallet after expiry of the said 2 days.</p>
                                        <p>•	The valid offers made by the Offeror’s will be available for acceptance by the sellers within 2 days only from the date of offer or increased offer is made.</p>
                                        <p>•	As soon as an offer is accepted by the seller, the sale of NFT will execute and the accepted bidder will be designated as buyer of NFT. Rest of the bidders will get the refund of EMD/total EMD amount in their freehold wallet.</p>
                                        <p>•	The Buyer of NFT will get 2 days grace period to have the offered amount in their freehold wallet.</p>
                                        <p>•	Any amount in the Buyers freehold wallet from the time of acceptance of offer till expiry of offer will be deducted for completing purchase of the subject NFT.</p>
                                        <p>•	As soon as the amount of deduction of amount from freehold wallet of the buyer equals the bid amount, the NFT will be designated as sold to the buyer and the amount of offer will be credited to the seller.</p>
                                        <p>•	If within 2 days of acceptance of offer of an NFT, the Offeror does not provide the offered amount in their wallet for deduction towards the subject buy or the amount deducted towards offer from the said buyer is less than the amount of offer made, then the sale of NFT will lapse and amount if any deducted from the buyers freehold account inclusive of the EMD for offer made will be charged as penalty from the buyer.</p>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">What is process of NFT Auction on NFT-X?</a>
                                    </h4>
                                </div>
                                <div id="collapseFive" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>•	Auction process requires users to provide a minimum auction price and time and date on which auction will end.</p>
                                        <p>•	The bidders can bid on the NFT at a price more than the Base price or the highest bid on the said NFT at the time of bidding. The highest bid at the time of Auction ending will selected as buyer of the NFT.</p>
                                        <p>•	The bidders must have at least 10% of the bid amount as freehold money in their wallet to bid on an NFT. The said 10% will be put on hold as soon as bid has been placed as EMD for the bid on NFT. </p>
                                        <p>•	The selected Buyer will get a notification for their bid being selected and will get 2 days’ grace period for making sure the amount they bid on the NFT is available in their Wallet.</p>
                                        <p>•	As soon as the amount of bid or part of the bid is available in the buyer’s wallet being the freehold money the same will be deducted for payment of the bid.</p>
                                        <p>•	As soon as the amount of bid is collected from the buyer’s wallet (within 2 days of selection of wallet) the said amount will be transferred to seller of NFT and the transfer of NFT will take place.</p>
                                        <p>•	If the said amount is not put into wallet within 2 days, then the amount deducted till completion of 2 days grace period inclusive of EMD will be charged as penalty charges.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix">What is the process of NFT Demand and Supply on NFT-X?</a>
                                    </h4>
                                </div>
                                <div id="collapseSix" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>•	Demand and Supply requires creators/sellers to provide a minimum bid price on the NFT.</p>
                                        <p>•	In demand and supply NFT’s in the market place, the prospective buyers can bid an amount on NFT at any price being equal to or higher than the base price of NFT.</p>
                                        <p>•	The offeror’s offer will be valid for 2 days for acceptance.</p>
                                        <p>•	The offeror’s need to have at least 10% of the offer amount in their wallet as freehold money. The said 10% will be put on hold from wallet of the offeror as EMD towards the bid amount. If your offer is not accepted withing 2 days of making the offer, the same will be refunded to your freehold wallet as soon as your offer expires.</p>
                                        <p>•	The offeror can only increase the offer made by him/her before in which case the differential amount of EMD (being 10% of the new offer made less 10% of the previous offer) will be charged as EMD from the freehold wallet of the offeror. If your new offer is not accepted withing 2 days of making the new offer, the total EMD will be refunded to your freehold wallet after expiry of the said 2 days.</p>
                                        <p>•	The valid offers made by the Offeror’s will be available for acceptance by the sellers within 2 days only from the date of offer or increased offer is made.</p>
                                        <p>•	As soon as an offer is accepted by the seller, the sale of NFT will execute and the accepted bidder will be designated as buyer of NFT. Rest of the bidders will get the refund of EMD/total EMD amount in their freehold wallet.</p>
                                        <p>•	The Buyer of NFT will get 2 days grace period to have the offered amount in their freehold wallet.</p>
                                        <p>•	Any amount in the Buyers freehold wallet from the time of acceptance of offer till expiry of offer will be deducted for completing purchase of the subject NFT.</p>
                                        <p>•	As soon as the amount of deduction of amount from freehold wallet of the buyer equals the bid amount, the NFT will be designated as sold to the buyer and the amount of offer will be credited to the seller.</p>
                                        <p>•	If within 2 days of acceptance of offer of an NFT, the Offeror does not provide the offered amount in their wallet for deduction towards the subject buy or the amount deducted towards offer from the said buyer is less than the amount of offer made, then the sale of NFT will lapse and amount if any deducted from the buyers freehold account inclusive of the EMD for offer made will be charged as penalty from the buyer.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</section>
@endsection