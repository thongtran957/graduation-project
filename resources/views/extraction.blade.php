@extends('templates.master')
@section('content')
    <div class="adminx-main-content">
        <div class="container-fluid">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb adminx-page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Extraction</li>
                </ol>
            </nav>
            <div class="row" style="margin-bottom: 15px">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-header-title">Extraction</div>
                        </div>
                        <div class="card-body collapse show" id="card1">
                            <form enctype="multipart/form-data" action="{{ route('extraction.uploadfile') }}"
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
            @if(isset($msg))
                <div class="row" style="margin-bottom: 15px">
                    <div class="col-lg-12">
                        {{$msg}}
                    </div>
                </div>
            @endif
            @if(isset($duration))
                <div class="row" style="margin-bottom: 15px">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="card-header-title">Execution Time: {{$duration}} </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($content))
                <div class="row" style="margin-bottom: 15px">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="card-header-title" data-toggle="collapse" data-target="#collapseExample"
                                     aria-expanded="false" aria-controls="collapseExample">Content resumes
                                </div>
                            </div>
                            <div class="collapse" id="collapseExample">
                                <div class="card card-body">
                                    <pre>{!! $content !!}</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($result))
                <div class="row" style="margin-bottom: 15px">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="card-header-title">Result from NER model</div>
                            </div>
                            <div class="card-body collapse show" id="card1">
                                <form method="post" action="{{ route('extraction.savedb') }}">
                                    @csrf
                                    @foreach($result as $key=>$value)
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label form-label">{{$key}}</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" value="{{$value}}"
                                                       name="{{$key}}">
                                            </div>
                                        </div>
                                    @endforeach
                                    <input type="text" class="form-control" value="{{$content}}"
                                           name="content" hidden>
                                    <div class="form-group row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-10">
                                            <input type="submit" class="btn-sm btn-primary" value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection()

