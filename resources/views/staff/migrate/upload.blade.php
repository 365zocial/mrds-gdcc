@extends('layouts.app')

@section('css')
    @include('base_wording_css')
    <style>
	.checkbox {
		padding-top: 20px;
	}
    </style>

    <!-- For Select2 Script -->
    <link rel="stylesheet" href="{{ URL::asset('assets/script/select2/css/select2.css') }}" media="screen" charset="utf-8">

@endsection

@section('script')
    @include('base_wording_js')
    <script type="text/javascript" src="{{ url('assets/script/bootstrap-filestyle.min.js') }}"></script>
    <script type="text/javascript">
        $(":file").filestyle({buttonText: "Select file to upload"});
    </script>
@endsection

@section('use_setup')

@endsection

@section('contain')
<div class="row">
    <div class="col-md-8 col-md-offset-2" style="border: 1px solid; border-color: #337ab7;">
        <div class="row">
            <div class="col-md-12">
                <h2>Upload File TemplateData</h2>
                <p>*โปรดอย่าทำการ Upload ไฟล์เดิมเข้าระบบ <a href="{{ url('template_migrate_master.zip') }}">ลิ้งขอรับไฟล์ต้นฉบับสำหรับการ Migrate</a></p>

            </div> <!-- /.col-md-12 -->
        </div> <!-- /.row -->

        <div class="row">
            <form action="{{ url('staff/migdata/uploadsourcedata') }}" method="post" id="form" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="cur_sci_name">Upload File <font style="color:red;"><em>(Accept Only File Type .CSV)</em><font></label>
                        <input type="file" name="csv_file" value="" accept=".csv" required>
                    </div>
                    <div class="form-group" style="text-align: center;">
                        <input type="submit" class="btn btn-success" name="" value="Upload">
                    </div>
                </div> <!-- /.col-md-12 -->
            </form> <!-- /.form -->
        </div> <!-- /.row -->
    </div> <!-- /.col-md-8 -->
</div> <!-- /.row -->

@endsection
