@extends('templates.master')
@section('content')
    <div class="adminx-main-content">
        <div class="container-fluid">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb adminx-page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Annotation</li>
                </ol>
            </nav>
            @if(isset($msg))
                <div class="row" style="margin-bottom: 15px">
                    <div class="col-lg-12">
                        {{$msg}}
                    </div>
                </div>
            @endif
            <div class="row" style="margin-bottom: 15px">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-header-title">Annotation</div>
                        </div>
                        <div class="card-body collapse show" id="card1">
                            <form enctype="multipart/form-data" action="{{ route('annotation.uploadfile') }}"
                                  method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Upload file resume here: (only support .pdf)</label>
                                    <input type="file" class="form-control-file" name="file">
                                </div>
                                <input type="submit" class="btn-sm btn-primary" value="Submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()

