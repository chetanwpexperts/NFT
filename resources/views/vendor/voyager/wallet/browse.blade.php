@extends('voyager::master')

@section('page_header')
<style>.mg-0{margin:0 !important;}</style>
<div class="container-fluid">
        <h1 class="page-title">
           NFT-X Escrow Panel
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
                                <th>NFT</th>
                                <th>NFT Owner</th>
                                <th>Bid Amount</th>
                                <th>Paid Amount</th>
                                <th>Pending Amount</th>
                                <th>Bid From</th>
                                <th>New Owner</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($escrow as $list)
                            {
                                ?>
                                <tr>
                                    <td>{{$list->id}}</td>
                                    <td>{{$list->nftid}}</td>
                                    <td>{{$list->owner}}</td>
                                    <td>{{$list->amount_pending + $list->amount_paid}}</td>
                                    <td>{{$list->amount_paid}}</td>
                                    <td>{{$list->amount_pending}}</td>
                                    <td>{{$list->bidder}}</td>
                                    <td><a href="" class="btn btn-success">Check</a></td>
                                </tr>
                                <?php 
                            }
                            ?>
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