@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Vakken</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">

    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Vakken
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Rollback ID</th>
                            <th scope="col">Tijd</th>
                            <th scope="col">Opties</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($imports as $import)
                            <tr>
                                <th scope="row">{{$import->id}}</th>
                                <th>{{$import->created_at}}</th>
                                <th><a href="/import/destroy/{{$import->id}}" >Verwijder</a></th>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    {{$imports->links()}}
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
    <!-- /.row -->

    <!-- /#page-wrapper -->
@stop