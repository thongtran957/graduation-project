<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Resume Parser</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
<style>
    pre {
        white-space: pre-wrap; /* Since CSS 2.1 */
        white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
        white-space: -o-pre-wrap; /* Opera 7 */
        word-wrap: break-word; /* Internet Explorer 5.5+ */
        line-height: 2rem;
        word-break: keep-all;
    }
</style>
<body>
@include('components.header')
<div id="content">
    <div class="row" id="annotation">
        <div class="col-1"></div>
        <div class="col-2">
            <div class="dropdown">
                <select class="form-control form-control-sm" id="label">
                    <option>Name</option>
                    <option>Graduation Year</option>
                    <option>College Name</option>
                    <option>Skills</option>
                    <option>Degree</option>
                    <option>Designation</option>
                    <option>Email Address</option>
                    <option>Location</option>
                </select>
            </div>
            <div>
                <button onclick="GetSelectedText()" class="btn-sm btn-primary">Choose</button>
            </div>
            <div id="list-badge">
            </div>
            <div>
                <button onclick="Submit()" class="btn-sm btn-primary">Submit</button>
            </div>
        </div>
        <p id="test"></p>
        <div class="col-8">
            <div>
                <span class="badge badge-primary">Name</span>
                <span class="badge badge-secondary">Graduation Year</span>
                <span class="badge badge-success">College Name</span>
                <span class="badge badge-danger">Skills</span>
                <span class="badge badge-warning">Degree</span>
                <span class="badge badge-info">Designation</span>
                <span class="badge badge-light">Email Address</span>
                <span class="badge badge-dark">Location</span>
            </div>
            <pre id="editor" contenteditable="true">{{ $text }}</pre>
        </div>
        <div class="col-1"></div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    var annotation = []

    function GetSelectedText() {
        var label = document.getElementById("label").value;
        if (document.getSelection) {
            var arr_temp = []
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

            arr_temp.push(label, text_selection, start.offset, end.offset)

            this.annotation.push(arr_temp)
            var content_annotations = ""
            this.annotation.forEach(function (ele) {
                switch (ele[0]) {
                    case "Name":
                        var content_annotation = '<div><span class="badge badge-primary">' + ele[1] + '</span></div>'
                        break;
                    case "Graduation Year":
                        var content_annotation = '<div><span class="badge badge-secondary">' + ele[1] + '</span></div>'
                        break;
                    case "College Name":
                        var content_annotation = '<div><span class="badge badge-success">' + ele[1] + '</span><div>'
                        break;
                    case "Skills":
                        var content_annotation = '<div><span class="badge badge-danger">' + ele[1] + '</span></div>'
                        break;
                    case "Degree":
                        var content_annotation = '<div><span class="badge badge-warning">' + ele[1] + '</span></div>'
                        break;
                    case "Designation":
                        var content_annotation = '<div><span class="badge badge-info">' + ele[1] + '</span></div>'
                        break;
                    case "Email Address":
                        var content_annotation = '<div><span class="badge badge-dark">' + ele[1] + '</span></div>'
                        break;
                    case "Location":
                        var content_annotation = '<div><span class="badge badge-warning">' + ele[1] + '</span></div>'
                        break;
                }
                content_annotations += content_annotation
            });
            document.getElementById("list-badge").innerHTML = content_annotations
        }
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

    function Submit() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        var formdata = new FormData();
        formdata.append('CSRF', '<?php echo @csrf_token() ?>'),
            formdata.append('annotation', this.annotation)
        $.ajax({
            url: '/test',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log('ok')
            },
            error: function (data) {
                console.log('fail')
            }
        });
    }
</script>
