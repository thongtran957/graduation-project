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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-grid">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-header-title">Resumes are not annotated</div>
                        </div>
                        <div class="table-responsive-md">
                            <table class="table table-actions table-striped table-hover mb-0">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="custom-control custom-checkbox m-0 p-0">
                                            <input type="checkbox" class="custom-control-input table-select-all">
                                            <span class="custom-control-indicator"></span>
                                        </label>
                                    </th>
                                    <th scope="col">File Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list_file as $value)
                                    <tr>
                                        <th scope="row">
                                            <label class="custom-control custom-checkbox m-0 p-0">
                                                <input type="checkbox" class="custom-control-input table-select-row">
                                                <span class="custom-control-indicator"></span>
                                            </label>
                                        </th>
                                        <td>{{ explode('/', $value['file_name'])[7] }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                    onclick="window.location='{{ route("annotation.uploadfile2", explode('/', $value['file_name'])[7] )}}'">
                                                Annotate
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()

