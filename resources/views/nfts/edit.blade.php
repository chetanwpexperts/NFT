@include('layouts.dashboard.header')
@include('layouts.dashboard.sidebar')
<style>
    @media (min-width: 320px){
        div#vpreview {
            top: 20rem !important;
        }
    }
    label audio {
        position: absolute;
        top: 22rem;
        left: 10rem;
    }
    .form-control:disabled, .form-control[readonly] {
        background-color: #562a4394 !important;
        opacity: 1;
    }
    label.btn.btn-tertiary.js-labelFile {
        background-color: #462544a6;
        border-radius: 10px;
        padding: 30px 0;
    }
</style>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-7 col-12">
            @include('flash-message')
			<div class="new-creation">
				<div class="creation-title">
					<div class="creation_txt">
						<h3>Edit Creation</h3>
					</div>
					<form action="{{ route('nft.publish') }}" method="POST" enctype="multipart/form-data">
				        @csrf
                        <input type="hidden" id="id" name="id" value="{{$nfts->id}}" />
                        <input type="hidden" id="nftid" name="nftid" value="{{$nfts->nftid}}" />
                        <input type="hidden" id="storeAs" name="store_as" value="auction" />
                        <?php 
                        if(isset($_GET['action']) && $_GET['action'] == "resale")
                        {
                            ?>
                            <input type="hidden" id="resale" name="resale" value="1" />
                            <input type="hidden" id="purchase_id" name="purchaseId" value="{{$_GET['purchase_id']}}" />
                            <?php 
                        }
                        ?>
					  <div class="form-group">
						<label for="nfttitle">Creation title</label>
						<input type="text" name="title" class="form-control" id="nfttitle" placeholder="Enter creation title" value="{{ $nfts->title }}" readonly>
					  </div>
                      <div class="form-group">
						<label for="exampleInputEmail1">Choose Creation Category</label>
						<select name="category" class="form-control" id="category" readonly onfocus="this.oldIndex=this.selectedIndex" onchange="this.selectedIndex=this.oldIndex">
						  <option>Choose Category</option>
                          <option value="image" <?php echo ($nfts->category == "image") ? "selected" : ""; ?>>Image</option>
						  <option value="music" <?php echo ($nfts->category == "music") ? "selected" : ""; ?>>Music</option>
                          <option value="audio" <?php echo ($nfts->category == "audio") ? "selected" : ""; ?>>Audio</option>
						  <option value="video" <?php echo ($nfts->category == "video") ? "selected" : ""; ?>>Video</option>
                          
						  <option value="script" <?php echo ($nfts->category == "script") ? "selected" : ""; ?>>Script</option>
                          <option value="lyrics" <?php echo ($nfts->category == "lyrics") ? "selected" : ""; ?>>Song Lyrics</option>
						</select>
					  </div>
                      <div class="form-group">
						<label for="exampleInputPassword1">Upload creation</label>
						  <input type="file" name="video" id="file" class="input-file" readonly disabled />
                          
						  <label for="file" class="btn btn-tertiary js-labelFile" readonly disabled>
                            <?php 
                            $file = $nfts->file;
                            $nftfile = asset("storage/app/public/".$file);
                            ?>
                            <?php 
                            $ext = pathinfo($nftfile, PATHINFO_EXTENSION);
                            switch($ext)
                            {
                                 case "mp4":
                                 case "flv":
                                 case "mov":
                                    ?> 
                                    <div class="videopreviewsection">
                                        <div id="vpreview">
                                            <video src="{{$nftfile}}" width="268" height="150" controls></video>
                                        </div>
                                    </div>
                                    
                                    <?php
                                    break;
                                case "mp3":
                                    ?>
                                    <audio controls controlsList="nodownload">
                                        <source src="{{$nftfile}}" type="audio/mpeg">
                                    </audio>
                                    <?php
                                    break;
                                 case "png":
                                    ?>
                                    <div class="imgpreviewsection">
                                        <div class="previewimg">
                                            <img src="{{$nftfile}}" class="img-responsive" id="blah" />
                                        </div>
                                    </div>
                                    
                                    <?php
                                    break;
                                case "jpeg":
                                    ?>
                                    <div class="imgpreviewsection">
                                        <div class="previewimg">
                                            <img src="{{$nftfile}}" class="img-responsive" id="blah" />
                                        </div>
                                    </div>
                                    <?php
                                    break;
                                case "jpg":
                                    ?>
                                      <div class="imgpreviewsection">
                                        <div class="previewimg">
                                            <img src="{{$nftfile}}" class="img-responsive" id="blah" />
                                        </div>
                                    </div>
                                    
                                    <?php
                                    break;
                            }

                            ?>
						  </label>
					  </div>

					  <div class="form-group">
						<label for="tags">Add Description <span style="color:#FF5E5B;font-size:12px;">Limit 500 words</span></label>
						<textarea rows="5" name="tags" class="form-control" placeholder="Add Tags" readonly>{{$nfts->tags}}</textarea>
					  </div>
					  <div class="row">
						<div class="col-lg-6 col-sm-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Auction End Time</label>
								<input type="text" name="time" class="form-control" id="timepicker" placeholder="hh:mm" value="{{$hour}}:{{$minute}}" required>
							</div>
						</div>
						<div class="col-lg-6 col-sm-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Auction End Date</label>
								<input id="datepicker" name="date" class="form-control" placeholder="yy-mm-dd" value="{{$auction_date}}" required />
							</div>
						</div>
					  </div>
					  <div class="form-group">
						<label for="price">Min Price <span style="color:#FF5E5B;font-size:12px;">INR</span></label>
						<input type="text" name="price" class="form-control" id="price" placeholder="Enter Min Price" value="{{$nfts->price}}" required>
					  </div>
					  <div class="post-btn-create">
                          <?php 
                          if(isset($_GET['action']) && $_GET['action'] == "resale")
                          {
                                ?>
                                <button type="submit" name="submit" class="post-auction"><i class="fa fa-bullhorn" aria-hidden="true"></i>Re-sale for Auction</button>
                          
                                <button type="submit" name="submit" class="post-demand"><i class="fa fa-bullhorn" aria-hidden="true"></i>Re-sale for demand supply</button>
                                <?php 
                          }else{
                              ?>
                              <button type="submit" name="submit" class="post-auction"><i class="fa fa-bullhorn" aria-hidden="true"></i>Post for Auction</button>

                              <button type="submit" name="submit" class="post-demand"><i class="fa fa-bullhorn" aria-hidden="true"></i>Post for demand supply</button>
                              <?php 
                          }
                          ?>
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
    $( ".post-auction" ).mouseover(function() 
    {
        $("#storeAs").val("auction");
    });
    $( ".post-demand" ).mouseover(function() 
    {
        $("#storeAs").val("demand");
    });
    
    $("#category").on("change", function()
    {
        var category_type = $(this).val();
        if(category_type == "image" || "music" || "script" || "lyrics")
        {
            $(".imgpreviewsection").show();
            $(".previewimg").show();
            $(".videopreviewsection").hide();
            $("#vpreview").hide();
        }
        if(category_type == "video")
        {
            $(".imgpreviewsection").hide();
            $("#vpreview").show();
            $(".videopreviewsection").show();
            $(".previewimg").hide();
        }
    });
    
    $('#category').on('mousedown', function(e) {
       e.preventDefault();
       this.blur();
       window.focus();
    });
})
</script>