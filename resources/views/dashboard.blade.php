@extends('templates.master')
@section('content')
    <div class="adminx-main-content">
        <div class="container-fluid">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb adminx-page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-6 col-lg-3 d-flex">
                    <div class="card mb-grid w-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="card-title mb-0">
                                    Resumes
                                </h5>
                                <div class="card-title-sub">
                                    {{ $count_resume }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 d-flex">
                    <div class="card mb-grid w-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="card-title mb-0">
                                    Labels
                                </h5>
                                <div class="card-title-sub">
                                    {{ $count_label }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('dashboard.search') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="Search here" id="search"
                                       name="search">
                            </div>
                            <div class="col-sm-3 multiselect">

                                <div class="form-control selectBox" onclick="showCheckboxes()">
                                    <select>
                                        <option>Select labels</option>
                                    </select>
                                    <div class="overSelect"></div>
                                </div>
                                <div id="checkboxes" class="form-control">
                                    @foreach($labels as $label)
                                        <label style="color: {{$label->color}}; font-weight: bold">
                                            <input type="checkbox"
                                                   id="labels{{$label->id}}"
                                                   name="{{$label->id}}"/>{{$label->name}}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                <input class="btn btn-primary btn-sm" type="button"
                                       onclick="location.href='{{route("dashboard.index")}}';"
                                       value="Reset"/>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-grid">
                    <div class="table-responsive-md">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Text</th>
                                <th>Label</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Resume ID</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $result)
                                <tr class="sub-container">
                                    <td>{{$result->id}}</td>
                                    <td>{{$result->text}}</td>
                                    <td>
                                        <span>{{ $result->name }}</span>
                                    </td>
                                    <td>{{$result->start}}</td>
                                    <td>{{$result->end}}</td>
                                    <td>{{$result->resume_id}}</td>
                                    <td>
                                        <button type="button" class="btn btn-success exploder btn-sm">
                                            Content
                                        </button>
                                    </td>

                                </tr>
                                <tr class="explode hide">
                                    <td colspan="7" style="background: #CCC; display: none;">
                                        <pre>{!!$result->content!!}</pre>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{ $results->links() }}
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

