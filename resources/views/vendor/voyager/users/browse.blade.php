@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
<style>.mg-0{margin:0 !important;}</style>
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
                            <?php
                            $rowId = 1;
                            $avatar = "";
                            foreach( $dataTypeContent as $data ) :
                                $avatar = $data['dp'];
                                if($avatar == "")
                                {
                                    $avatar = $data['avatar'];
                                }
                                $user_avatar = asset("storage/app/public/".$avatar);
                                if($data['role_id'] != 1)
                                {
                                    ?>
                                    <tr>
                                        <td>{{$rowId}}</td>
                                        <td style="width:10%;"><img src="{{$user_avatar}}" style="width:65%;border-radius: 7px;border:4px solid #cab5b545;"></td>
                                        <td><?php echo ucfirst($data['name']);?></td>
                                        <td><?php echo $data['user_type'];?></td>
                                        <td><?php echo $data['email'];?></td>
                                        <td><?php echo $data['phone'];?></td>
                                        <td><?php echo ($data['status'] == 0) ? "Not Varified" : "Varified";?></td>
                                        <td>
                                            <div class="row mg-0">
                                                <div class="col-md-2 mg-0">
                                                    <a href="{{route('user.view', [$data['id']])}}"><i class="icon voyager-eye" style="font-size:20px;"></i></a>
                                                </div>
                                                <div class="col-md-2 mg-0">
                                                    <i class="icon voyager-edit" style="font-size:20px;"></i>
                                                </div>
                                                <div class="col-md-2 mg-0">
                                                    <i class="icon voyager-trash" style="font-size:20px;"></i>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php 
                                    $rowId++;
                                }
                                
                            endforeach;
                            ?>
                        </tbody>
                        
                    </table>
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