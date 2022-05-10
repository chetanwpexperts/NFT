<link href="{{ URL::asset('public/assets/css/preview.css'); }}" rel="stylesheet">
<div class="col-lg-12 col-sm-12">
    <div class="second_boxx_inner">
        <div class="owner-info-list">
            <h3 class="nft_owner">{{$user->name}}</h3>
            <!--fas fa-heart -->
            <label for="favourites_3"><i class="far fa-heart favourite"></i></label>
            <input type="checkbox" class="chk" id="favourites_3" name="favourite" value="0" style="display:none;">
        </div>
        <div class="blog_img">
            <?php 
            $nftfile = asset("storage/app/public/".$nft->file);
            $ext = pathinfo($nftfile, PATHINFO_EXTENSION);
            switch($ext)
            {
                 case "mp4":
                 case "flv":
                 case "mov":
                    ?> 
                    <video controls="" style="width:100%;height:850px;background-color:#000000;" autoplay muted controlsList="nodownload">
                        <source src="{{$nftfile}}" type="video/mp4">
                    </video>
                    <?php
                    break;
                 case "mp3":
                    ?>
                    <img src="{{ URL::asset('public/assets/img/audio.gif'); }}" class="img-responsive" />
                    <audio controls controlsList="nodownload">
                        <source src="{{$nftfile}}" type="audio/mpeg">
                    </audio>
                    <?php
                    break;
                 case "png":
                    ?>
                    <img src="{{$nftfile}}" class="img-responsive" style="height: 300px;" />
                    <?php
                    break;
                case "gif":
                    ?>
                    <img src="{{$nftfile}}" class="img-responsive" style="height: 300px;" />
                    <?php
                    break;
                case "jpeg":
                    ?>
                    <img src="{{$nftfile}}" class="img-responsive" style="height: 300px;" />
                    <?php
                    break;
                case "jpg":
                    ?>
                    <img src="{{$nftfile}}" class="img-responsive" style="height: 300px;" />
                    <?php
                    break;
            }
            ?>
        </div>
        <div class="list_info">
            <div class="id_badge">
                <p>Id_{{$nft->nftid}}</p>
            </div>
            <div class="creater_info_list">
                <h2>{{$nft->title}}</h2>
                <p>{{$user->name}}</p>
                <div class="creator_list">
                    <?php 
                    if($nft->type == "auction")
                    {
                        ?>
                        <ul>
                            <li>
                                <div class="auction_icon">
                                    <img src="{{ URL::asset('public/assets/img/auction-icon.png'); }}"/>
                                </div>
                            </li>
                            <li>
                                <h4 class="auction_view_title">on Auction</h4>
                                <p class="auction_day">2 days left</p>
                            </li>
                            <li>
                                <h4 class="auction_view_title">&#8377;{{$nft->price}}</h4>
                                <p class="auction_day">Current Bid</p>
                            </li>
                        </ul>
                        <?php 
                    }else{
                        ?>
                        <ul>
                            <li>
                                <div class="auction_icon">
                                    <img src="{{ URL::asset('public/assets/img/van.png'); }}"/>
                                </div>
                            </li>
                            <li>
                                <h4 class="auction_view_title">on Demand Supply</h4>
                                <p class="auction_day">Live Now</p>
                            </li>
                        </ul>
                        <?php 
                    }
                    ?>
                </div>
                    <ul class="tags">
                        @php
                        $tags = explode(",", $nft->tags);
                        foreach($tags as $tag)
                        {
                        @endphp
                        <li>
                            <div class="tag_div_list">	
                                <a>#{{$tag}}</a>
                            </div>
                        </li>
                        @php
                        }
                        @endphp
                    </ul>
            </div>
        </div>
    </div>
</div>