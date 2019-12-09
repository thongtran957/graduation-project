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
            <div class="row">
                <div class="col-lg-12" style="margin-bottom: 15px">
                    @foreach($labels as $label)
                        <span class="badge"
                              style="background-color: {{$label->color}}; font-size: 14px">{{$label->name}}</span>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-header-title">Annotation</div>
                        </div>
                        <div class="card-body collapse show" id="card1">
                            <pre id="editor" contenteditable="true">{{$content}}</pre>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" >
                    <div class="card" style="margin-bottom: 15px">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-header-title">Label</div>
                        </div>
                        <div class="card-body collapse show" id="card1">
                            <div class="dropdown" style="margin-bottom: 10px">
                                <select class="form-control form-control-sm" id="label">
                                    @foreach($labels as $label)
                                        <option style="color: {{$label->color}}">{{$label->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button onclick="GetSelectedText()" class="btn btn-pill btn-sm btn-primary">Label
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="margin-bottom: 15px">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-header-title">Card After Label</div>
                        </div>
                        <div class="card-body collapse show" id="card1">
                            <div id="list-badge">
                            </div>
                        </div>
                    </div>

                    <div>
                        <button onclick="Submit()" class="btn btn-pill btn-sm btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var annotation = []

        function GetSelectedText() {
            var label = document.getElementById("label").value;
            if (document.getSelection) {
                var text_selection = document.getSelection().toString();

                var selectedRange = window.getSelection().getRangeAt(0);
                if (selectedRange) {
                    var sc = selectedRange.startContainer,
                        so = selectedRange.startOffset,
                        ec = selectedRange.endContainer,
                        eo = selectedRange.endOffset;
                    var editable = document.getElementById('editor');
                    var start = rootOffset(editable, {node: sc, offset: so});
                    var end = rootOffset(editable, {node: ec, offset: eo});
                }

                var obj = {
                    label: label,
                    text_selection: text_selection,
                    start: start.offset,
                    end: end.offset
                }

                this.annotation.push(obj)
                var content_annotations = ""
                this.annotation.forEach(function (ele) {
                        @foreach($labels as $label)
                        if (ele.label == "{{ $label->name }}") {
                            var content_annotation = '<div><span class="badge" style="background-color:{{$label->color}}; font-size:14px">' + ele.text_selection + '</span></div>'
                        }
                        @endforeach
                            content_annotations += content_annotation
                    }
                )
                document.getElementById("list-badge").innerHTML = content_annotations
            }
        }

        function Submit() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            $.ajax({
                url: '/annotation-data',
                type: 'POST',
                data: {
                    data: annotation,
                    file_name: '{{ $file_name }}',
                    CSRF: '{{ csrf_token() }}'
                },
                success: function (data) {
                    if (data.status == "success") {
                        window.location.href = "{{URL::to('/annotation')}}"
                    }
                },
                error: function (data) {
                    console.log('fail')
                }
            });
        }

        var rootOffset = function (root, point) {
            if (point.node === root) {
                return point;
            }
            var previousSibling = point.node.previousSibling;
            if (previousSibling) {
                return {
                    node: point.node,
                    offset: rootOffset(root, {
                        node: previousSibling,
                        offset: nodeLength(previousSibling)
                    }).offset + point.offset
                };
            } else {
                var parentNode = point.node.parentNode;
                if (parentNode) {
                    return rootOffset(root, {node: parentNode, offset: point.offset});
                }
            }
            return point;
        };

        var isText = function (node) {
            return node && node.nodeType === 3;
        };

        var nodeLength = function (node) {
            if (isText(node)) {
                return node.nodeValue.trim().length;
            }
            var length = 0;
            var childNodes = node.childNodes;
            if (childNodes) {
                for (var i = 0; i < childNodes.length; i++) {
                    length += nodeLength(childNodes[i]);
                }
            }
            return length;
        };
    </script>
@endsection()

