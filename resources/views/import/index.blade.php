@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">CSV Import</h1>

            <form method="post">

                @csrf

                <div class="form-group">
                    <label>File input</label>
                    <input type="file" name="file">
                </div>

                <button type="submit" class="btn btn-success">Upload!</button>
            </form>
        </div>
    </div>
</div>

@stop