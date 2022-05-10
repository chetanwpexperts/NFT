@include('layouts.dashboard.header')
@include('layouts.dashboard.sidebar')

<style>
div#apreview {
    position: relative;
}
audio {
   top: 4rem !important;
    width: 25%;
    height: 41px;
    left: 14rem;
}
img.img-responsive.audioicon {
    width: 15%;
    position: absolute;
    top: -60px;
    left: 16rem;
}
@media (max-width:768px)  
{     
    img.img-responsive.audioicon {
        width: 25%;
        position: absolute;
        top: -4rem;
        left: 7rem;
    }
    
    audio {
        top: 4rem !important;
        width: 81%;
        height: 41px;
        left: 2rem;
    }
}
</style>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-7 col-12">
            @if (Session::get('success'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{ session('status') }}
            </div>
            @elseif(session('failed'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{ session('failed') }}
            </div>
            @endif
			<div class="new-creation">
				<div class="creation-title">
					<div class="creation_txt">
						<h3>Add New Creation <span>for AUCTION</span></h3>
					</div>
					<form id="createnft" action="{{ route('nft.store') }}" method="POST" enctype="multipart/form-data">
				        @csrf
                        <input type="hidden" name="creator_id" value="{{$user->creator_id}}" />
                        <input type="hidden" id="storeAs" name="store_as" value="auction" />
					  <div class="form-group">
						<label for="nfttitle">Creation title</label>
						<input type="text" name="title" class="form-control" id="nfttitle" placeholder="Enter creation title" required>
					  </div>
                        <div class="form-group">
						<label for="exampleInputEmail1">Choose Creation Category</label>
						<select name="category" class="form-control" id="category" required>
						  <option>Choose Category</option>
                          <option value="image">Image</option>
						  <option value="music">Music</option>
						  <option value="video">Video</option>
						  <option value="audio">Audio</option>
						  <option value="script">Script</option>
                          <option value="lyrics">Song Lyrics</option>
						</select>
					  </div>
					  <div class="form-group">
						<label for="exampleInputPassword1">Upload creation</label>
						  <input type="file" name="video" id="file" class="input-file" onchange="PreviewAudio(this, $('#apreview'))" required />
                          
						  <label for="file" class="btn btn-tertiary js-labelFile">
							<img src="{{ URL::asset('public/assets/dashboard/images/upload.png'); }}" class="img-responsive" />
                            <div class="imgpreviewsection" style="display:none;">
                                <div class="previewimg">
                                    <img src="" class="img-responsive" id="blah" style="display:none;" />
                                </div>
                            </div>
                            <div class="videopreviewsection" style="display:none;">
                                <div id="vpreview" style="display:none;">
                                    <video width="268" height="150" controls></video>
                                </div>
                            </div>
                            <div class="audiopreviewsection" style="display:block;">
                                <div id="apreview" style="display:none;">
                                    <img src="" class="img-responsive audioicon" />
                                    <audio width="100%" height="100%" controls></audio>
                                </div>
                            </div>
							<span class="js-fileName"><p>Upload Audio/Video/Image</p></span>
							<span class="duration">file size (Max 50 mb)</span>
						  </label>
					  </div>
					  
					  <div class="form-group">
						<label for="tags">Add Description <span style="color:#FF5E5B;font-size:12px;"> Limit 500 Words</span></label>
						<textarea rows="5" name="tags" class="form-control" maxlength="500" placeholder="Add Nft Description"></textarea>
					  </div>
					  <div class="row">
						<div class="col-lg-6 col-sm-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Auction End Time</label>
								<input type="text" name="time" class="form-control" id="timepicker" placeholder="hh/mm" required>
							</div>
						</div>
						<div class="col-lg-6 col-sm-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Auction End Date</label>
								<input id="datepicker" name="date" class="form-control" placeholder="yy-mm-dd" required />
							</div>
						</div>
					  </div>
					  <div class="form-group">
						<label for="price">Min Price <span style="color:#FF5E5B;font-size:12px;">INR</span></label>
						<input type="text" name="price" class="form-control" id="price" placeholder="Enter Min Price">
					  </div>
					   <div class="post-btn-create">
                          <button class="btnpreview" type="submit" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-eye" aria-hidden="true"></i> Preview</button> 
                           
                          <br />
                           <br />
                               
                          <button type="submit" name="submit" class="post-auction"><i class="fa fa-bullhorn" aria-hidden="true"></i>Post for Auction</button>
                          
                          <button type="submit" name="submit" class="post-demand"><i class="fa fa-bullhorn" aria-hidden="true"></i>Post for demand supply</button>
					  </div>
					  <div class="back_link draft_line">
						<button type="submit" name="submit" class="no_background"><i class="fas fa-clock"></i> Save Draft</button> 
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

<!--- NFT preview -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:9999999999999999999;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">NFT Preview</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body float-center">
           <div id="mynftpreview"></div>
      </div>
    </div>
  </div>
</div>

<!--- End preview model-->


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
    $( ".no_background" ).mouseover(function() 
    {
        $("#storeAs").val("draft");
    });
    $("#file").on("change", function(){
        $("#blah").show();
    });
    
    $("#category").on("change", function()
    {
        var category_type = $(this).val();
        
        if(category_type == "image" || "music" || "script" || "lyrics")
        {
            $(".imgpreviewsection").show();
            $(".videopreviewsection").hide(); 
            $(".audiopreviewsection").hide();
        }
        
        if(category_type == "video")
        {
            $(".imgpreviewsection").hide();
            $(".videopreviewsection").show();
            $(".audiopreviewsection").hide();
        }
        
        if(category_type == "audio")
        {
            $(".imgpreviewsection").hide();
            $(".videopreviewsection").hide();
            $(".audiopreviewsection").show();
        }
    });
    
    $(".btnpreview").on('click', function(e)
    {
        $(".loading-overlay").addClass("is-active");
        var formdata = new FormData(document.getElementById("createnft"))
        $.ajax({
            type: 'POST',
            url: "{{ route('nft.preview') }}",
            data: formdata,
            contentType: false,
            cache: false,
            processData:false,
            success: function(response)
            {
                $(".loading-overlay").removeClass("is-active");
                $("#exampleModal").modal('show');
                $("#mynftpreview").html(response);
                
            }
        });

        return false;
    });
})
</script>
