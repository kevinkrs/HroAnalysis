@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{$course["name"]}}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">

    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Verdeling cijfers
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    {!! $chartjs->render() !!}
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Gemiddelde
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <h1 style="text-align: center">{{$average}}</h1>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
    <!-- /.row -->
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Positieve feedback
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Feedback</th>
                            <th scope="col">Cijfer</th>
                            <th scope="col">Opties</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($feedbackbest as $feedback)
                            <tr>
                                <th scope="row">{{$feedback["feedback"]}}</th>
                                <th>{{$feedback["grade"]}}</th>
                                <th><a href="/feedback/destroy/{{$feedback["id"]}}/{{$course->course_code}}/">Verwijder</a></th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$feedbackbest->links()}}
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Negatieve feedback
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table">
                        Slechste Feedback
                        <thead>
                        <tr>
                            <th scope="col">Feedback</th>
                            <th scope="col">Cijfer</th>
                            <th scope="col">Opties</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($feedbackworst as $feedback)
                            <tr>
                                <th scope="row">{{$feedback["feedback"]}}</th>
                                <th>{{$feedback["grade"]}}</th>
                                <th><a href="/feedback/destroy/{{$feedback["id"]}}/{{$course->course_code}}/">Verwijder</a></th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$feedbackworst->links()}}
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
    <!-- /.row -->
    <!-- /#page-wrapper -->
@stop