@extends('templates.master')
@section('content')
    <div class="adminx-main-content">
        <div class="container-fluid">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb adminx-page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Train</li>
                </ol>
            </nav>
            @if(isset($msg))
                <div class="row" style="margin-bottom: 15px">
                    <div class="col-lg-12">
                        {{$msg}}
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-grid">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-header-title">Train NER model</div>
                        </div>
                        <div class="table-responsive-md">
                            <table class="table table-actions table-striped table-hover mb-0">
                                <thead>
                                <tr>
                                    <th style="text-align: center">File Name</th>
                                    <th style="text-align: center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($list_file))
                                    @foreach($list_file as $value)
                                        <tr>
                                            <td>{{ explode('/', $value['file_name'])[7] }}</td>
                                            <td>
                                                <button type="button" class="btn btn-success exploder btn-sm">
                                                    Content
                                                </button>
                                                <button class="btn btn-sm btn-warning"
                                                        onclick="window.location='{{ route("train.delete",  $value['id'] )}}'">
                                                    Delete
                                                </button>
                                                <button class="btn btn-sm btn-primary"
                                                        onclick="window.location='{{ route("train.uploadfile",   explode('/', $value['file_name'])[7])}}'">
                                                    Train
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="explode hide">
                                            <td colspan="2" style="background: #CCC; display: none;">
                                                <div class="row">
                                                    <div class="col-lg-8" style="text-align: left">
                                                        <pre>{!! $value['content'] !!}</pre>
                                                    </div>
                                                    <div class="col-lg-4" style="text-align: left">
                                                        @foreach($value['content_file_trains'] as $a)
                                                            <div>
                                                                <span class="badge"
                                                                      style="background-color: {{$a->color}}; font-size: 14px">
                                                                    {{$a->name}} : {{$a->text}}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>NO DATA SHOW HERE</td>
                                        <td></td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".exploder").click(function () {
            $(this).toggleClass("btn-success btn-danger");
            $(this).closest("tr").next("tr").toggleClass("hide");
            if ($(this).closest("tr").next("tr").hasClass("hide")) {
                $(this).closest("tr").next("tr").children("td").slideUp(50);
            } else {
                $(this).closest("tr").next("tr").children("td").slideDown(50);
            }
        });

        var expanded = false;

        function showCheckboxes() {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }
    </script>
@endsection()

