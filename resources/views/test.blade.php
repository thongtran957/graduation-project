@extends('templates.master')
@section('content')
    <?php $i = 1?>
    @foreach($arr as $value)
        <div class="adminx-main-content">
            <div class="container-fluid">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb adminx-page-breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{$i}}Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Train</li>
                    </ol>
                </nav>
                <div class="row">
                    <div class="col-lg-12">
                        <pre>{{$value}}</pre>
                    </div>
                </div>
            </div>
            <?php $i++ ?>
        </div>
    @endforeach
@endsection()

