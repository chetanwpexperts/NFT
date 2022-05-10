@extends('layouts.authlayout')

@section('content')
    
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-logo">
                        <img src="{{ URL::asset('public/assets/img/logo.png'); }}" class="img-responsive"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="user_sec_title">
                        <h3>How would you like to make money?</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <a href="javascript:void(0);" data-user-type="creator" data-user="{{$user_id}}" class="usertype">
                    <div class="col-lg-4 col-sm-6 col-md-offset-2">
                        <div class="creator-boxx">
                            <div class="creator-info">
                                <p>Being a</p>
                                <h3>CREATOR</h3>
                                <h4>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h4>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="javascript:void(0);" data-user-type="vendor" data-user="{{$user_id}}" class="usertype">
                    <div class="col-lg-4 col-sm-6">
                        <div class="creator-boxx-1">
                            <div class="creator-info">
                                <p>Being a</p>
                                <h3>BUYER & SELLER</h3>
                                <h4>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

@endsection
