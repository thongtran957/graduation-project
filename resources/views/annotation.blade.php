@include('components.header')
<div id="content">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <form enctype="multipart/form-data" action="{{ route('annotation.uploadfile') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>Upload file CV here:</label>
                    <input type="file" class="form-control-file" name="file">
                </div>
                <input type="submit" class="btn-sm btn-primary" value="Submit">
            </form>
        </div>
        <div class="col-1"></div>
    </div>
</div>
</body>
</html>
