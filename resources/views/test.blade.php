<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
</head>
<body>
@include('components.header')
<div id="content">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div id="editor" contenteditable="true">
                <div class="title">Hello Every thing is<span style="font-family: Tahoma;font-size: 20px">Good ! </span>
                </div>
            </div>
            <button type="button" id="btnLog" onclick="selection()">Log Selection</button>
        </div>
        <div class="col-1"></div>
    </div>
</div>
</body>
<script>
    var selection = function () {
        var selectedRange = window.getSelection().getRangeAt(0);
        if (selectedRange) {
            var sc = selectedRange.startContainer,
                so = selectedRange.startOffset,
                ec = selectedRange.endContainer,
                eo = selectedRange.endOffset;
            var editable = document.getElementById('editor');
            var start = rootOffset(editable, {node: sc, offset: so});
            var end = rootOffset(editable, {node: ec, offset: eo});
            console.log(start.offset);
            console.log(end.offset);
        }
    };

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
</html>
