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
            <pre id="editor" contenteditable="true">{{$content}}</pre>
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

            // arr_temp.push(label, text_selection, start.offset, end.offset)
            var obj = {
                label: label,
                text_selection: text_selection,
                start: start.offset,
                end: end.offset
            }

            this.annotation.push(obj)
            var content_annotations = ""
            this.annotation.forEach(function (ele) {
                switch (ele.label) {
                    case "Name":
                        var content_annotation = '<div><span class="badge badge-primary">' + ele.text_selection + '</span></div>'
                        break;
                    case "Graduation Year":
                        var content_annotation = '<div><span class="badge badge-secondary">' + ele.text_selection + '</span></div>'
                        break;
                    case "College Name":
                        var content_annotation = '<div><span class="badge badge-success">' + ele.text_selection + '</span><div>'
                        break;
                    case "Skills":
                        var content_annotation = '<div><span class="badge badge-danger">' + ele.text_selection + '</span></div>'
                        break;
                    case "Degree":
                        var content_annotation = '<div><span class="badge badge-warning">' + ele.text_selection + '</span></div>'
                        break;
                    case "Designation":
                        var content_annotation = '<div><span class="badge badge-info">' + ele.text_selection + '</span></div>'
                        break;
                    case "Email Address":
                        var content_annotation = '<div><span class="badge badge-dark">' + ele.text_selection + '</span></div>'
                        break;
                    case "Location":
                        var content_annotation = '<div><span class="badge badge-warning">' + ele.text_selection + '</span></div>'
                        break;
                }
                content_annotations += content_annotation
            });
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
            },
            success: function (data) {
                console.log('ok')
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
