@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')


<style>.mg-0{margin:0 !important;}.member-details {
    padding-top: 80px;
    padding-bottom: 80px
}

@media (min-width:992px) {
    .member-details {
        padding-top: 20px;
        padding-bottom: 100px
    }
}

.member-details .member_designation {
    margin-bottom: 30px
}

.member-details .member_designation h2 {
    margin-bottom: 5px;
    margin-top: 25px
}

@media (min-width:768px) {
    .member-details .member_designation h2 {
        margin-top: 0
    }
}

.member-details .member_designation span {
    font-style: italic
}

.member-details .member_desc li {
    display: block;
    float: unset;
    width: 100%
}

.member-details .member_desc li i {
    color: #0cc652;
    font-size: 14px
}

.member-details .member_desc h4 {
    margin-top: 40px
}

.member-details .member_desc p {
    margin-top: 10px
}

.member-details .member_desc .progress-holder {
    margin-top: 30px
}

.member-details .media-box {
    margin-bottom: 20px
}

@media (min-width:992px) {
    .member-details .media-box {
        margin-bottom: 0
    }
}

.member-details .member_contact {
    padding: 40px;
    position: relative;
    margin-top: 40px
}

.member-details .member_contact .media-icon {
    font-size: 32px;
    color: #dae0e6;
    position: relative;
    width: 30px;
    text-align: center;
    float: left;
    margin-right: 15px
}

.member-details .member_contact .media-content {
    padding-left: 0;
    float: left
}

.member-details .member_contact .media-content h5 {
    font-size: 15px
}

.member-details .member_contact .media-content h5,
.member-details .member_contact .media-content a {
    color: #dae0e6
}

@media (min-width:992px) {
    .member-details .member_contact .social-icons {
        text-align: right
    }
}

.member-details .member_contact .social-icons .btn-social {
    width: 100%;
    height: auto;
}

.member-details .member_contact .social-icons .btn {
    background-color: transparent;
    border: 1px solid;
    border-color: #999;
    color: #dae0e6
}

.member-details .member_contact .social-icons .btn:hover {
    background-color: #0cc652;
    border-color: #0cc652;
    opacity: 1
}

.bg-image-holder,
.bg-image {
    background-size: cover!important;
    background-position: 50% 0!important;
    transition: all .3s linear;
    background: #f5f5f6;
    position: relative
}

.bg-image:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, .7)
}

.bg-fixed {
    background-attachment: fixed
}

.bg-image .overlay-content {
    position: relative;
    z-index: 5
}


.progress-holder {
    margin-top: 50px
}

.progress-holder .barWrapper .progressText {
    font-size: 15px;
    color: #222
}

.progress-holder .progress {
    margin-bottom: 25px;
    margin-top: 10px;
    overflow: visible;
    background-color: #f5f5f6
}

.progress-holder .progress .progress-bar {
    position: relative
}

.progress-holder .progress .progress-bar:after {
    position: absolute;
    content: '';
    width: 1px;
    height: 33px;
    background-color: #0cc652;
    top: -8px;
    right: 0;
    z-index: 55
}

.img-full {
    width: 100%;
}

p {
    color: #8b8e93;
    font-weight: 300;
    margin-bottom: 0;
    font-size: 14px;
    line-height: 26px;
}


.styled_list {
    margin-top: 15px;
    position: relative;
    display: inline-block
}

@media (min-width:768px) {
    .styled_list {
        margin-top: 15px
    }
}

.styled_list li {
    font-size: 14px;
    line-height: 30px
}

@media (min-width:768px) {
    .styled_list li {
        font-size: 14px;
        float: left;
        width: 50%
    }
}

.styled_list li i {
    margin-right: 10px;
    font-size: 12px
}

.styled_list li a {
    color: #8b8e93
}

@media (min-width:768px) {
    .styled_list li a {
        font-size: 12px
    }
}

@media (min-width:992px) {
    .styled_list li a {
        font-size: 14px
    }
}

ol.styled_list {
    margin-left: 15px
}

ol.styled_list li {
    padding-left: 10px
}</style>
<div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->getTranslatedAttribute('display_name_plural') }}
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        @if (Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        
                        <div class="container">
                            <section class="member-details">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3">
                                            <?php 
                                            //echo "<pre>";
                                            //print_r($dataTypeContent->name);
                                            ?>
                                            <div class="img-container">
                                                @php
                                                $avatar = $dataTypeContent->dp;
                                                if($avatar == "")
                                                {
                                                    $avatar = $dataTypeContent->avatar;
                                                }
                                                $user_avatar = asset("storage/app/public/".$avatar);
                                                @endphp
                                                <img src="{{$user_avatar}}" alt="team member" class="img-full" style="border-radius:15%;border:5px solid #e8dede;">
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            <div class="member_designation">
                                                <h2>{{ucfirst($dataTypeContent->name)}}</h2>
                                                <span>{{$dataTypeContent->user_type}}</span>
                                            </div>

                                            <div class="bg-image " style="background-image: url('https://www.bootdey.com/img/Content/bg_element.jpg');">
                                                <div class="member_contact">
                                                    <div class="row">
                                                        <div class="col-lg-4  mb-3 mb-lg-0">
                                                            <div class="media-box">
                                                                <div class="media-icon">
                                                                    <i class="fa fa-tablet" aria-hidden="true"></i>
                                                                </div>
                                                                <div class="media-content">
                                                                    <h5>Phone</h5>
                                                                    <p><a href="callto">{{$dataTypeContent->phone}}</a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4  mb-3 mb-lg-0">
                                                            <div class="media-box">
                                                                <div class="media-icon">
                                                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                                                </div>
                                                                <div class="media-content">
                                                                    <h5>Email</h5>
                                                                    <p><a href="mailto">{{$dataTypeContent->email}}</a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="social-icons">
                                                                @php
                                                                $social_media_accounts = explode(",", $dataTypeContent->social_media_accounts);
                                                                // print_r($social_media_accounts);
                                                                foreach($social_media_accounts as $links)
                                                                {
                                                                    @endphp
                                                                    <a href="https://{{$links}}" class="btn btn-social outlined">{{$links}}</a> <br />
                                                                    @php
                                                                }
                                                                @endphp
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="member_desc">
                                                <h4>Persional Information</h4>
                                                <p>
                                                    @php
                                                    if($dataTypeContent->about == "")
                                                    {
                                                        echo "No Bio";
                                                    }else{
                                                        echo $dataTypeContent->about;
                                                    }
                                                    @endphp
                                                </p>
                                            </div>
                                            <form name="varifyuser" action="{{route('auth.verify')}}" method="post">
                                                @csrf
                                                <div class="row ">
                                                    <div class="col-lg-12 member_desc">
                                                        <h4>Video</h4>
                                                        <p>
                                                            @php
                                                            $video = $dataTypeContent->video;
                                                            if($video != "")
                                                            {
                                                            $user_video = asset("storage/app/public/".$video);
                                                            @endphp
                                                            <video controls autoplay width="100%" height="100%">
                                                              <source src="{{$user_video}}" type="video/mp4">
                                                            </video>
                                                            @php
                                                            }else{
                                                                echo "Creator Id Not available";
                                                            }
                                                            @endphp

                                                            
                                                        </p>
                                                    </div>
                                                    <!-- <div class="col-lg-12 member_desc">
                                                        <h4>Signatue</h4>
                                                        <p>
                                                            @php
                                                            $signature = $dataTypeContent->signature;
                                                            if($signature != "")
                                                            {
                                                            $user_signature = asset("storage/app/public/".$signature);
                                                            @endphp
                                                            <img src="{{$user_signature}}" style="width:35%;">
                                                            @php
                                                            }else{
                                                                echo "No Signature Uploaded";
                                                            }
                                                            @endphp
                                                        </p>
                                                    </div> -->
                                                    
                                                </div>
                                                <h3>Badges</h3>
                                                <div class="row">
                                                    <input type="radio" name="badges" value="purple" <?php echo ($dataTypeContent->badges == "purple") ? "checked" : "";?> /> 
                                                    <span>
                                                    Purple
                                                    </span>
                                                </div>
                                                <div class="row">
                                                    <input type="radio" name="badges" value="gold" <?php echo ($dataTypeContent->badges == "gold") ? "checked" : "";?> /> 
                                                    <span>
                                                    Gold
                                                    </span>
                                                </div>
                                                <div class="row">
                                                    <input type="checkbox" name="status" value="1" <?php if($dataTypeContent->status == 1){ echo "checked"; }else{ echo "required"; } ?> /> &nbsp;
                                                    <span>
                                                    <?php if($dataTypeContent->status == 1){ echo "<strong> User Verified Already. Uncehck to Unverify if soemthing wrong!</strong>"; }else{ echo "<strong> Verify This User To Check This Checkbox. </strong>"; } ?>
                                                    </span>
                                                </div>
                                                <div class="row">
                                                    <p>&nbsp;</p>
                                                    <input type="hidden" name="id" value="{{$dataTypeContent->id}}" >
                                                    <button type="submit" name="submit" class="btn btn-success"> Update User</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endif
@stop

@section('javascript')
    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        $(document).ready(function () {
            $('#examplefdf').DataTable();
        });
    </script>
@stop