@extends('voyager::master')

@section('page_header')
<style>.mg-0{margin:0 !important;}</style>
<div class="container-fluid">
        <h1 class="page-title">
           All Auction Bids
        </h1>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table id="examplefdf" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>#Id</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('javascript')
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#examplefdf').DataTable();
        });
    </script>
@stop