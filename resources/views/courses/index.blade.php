@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Vakken</h1>
        </div>
        <div style="width:75%;">
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
                            <th scope="col">Naam</th>
                            <th scope="col">Vakcode</th>
                            <th scope="col">Periode</th>
                            <th scope="col">Opties</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <th scope="row">{{$course->name}}</th>
                                <th>{{$course->course_code}}</th>
                                <th>{{$course->period}}</th>
                                <th><a href="/course/{{$course->course_code}}" >Open</a> <a href="/course/destroy/{{$course->course_code}}" >Verwijder</a></th>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    {{$courses->links()}}
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
    <!-- /.row -->

    <!-- /#page-wrapper -->
@stop