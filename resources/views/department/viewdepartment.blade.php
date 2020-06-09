@extends('app')

@section('content')

<div class="row">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('department') }}">แผนก</a></li>
        <li class="breadcrumb-item active">ข้อมูลแผนก</li>
    </ol>
</div>

 <div class="row">
    <div class="col-xs-12 col-md-10"><h1 id="content" class="bd-title">ข้อมูลแผนก {{ $dep->dep_name }}</h1></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('department') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>
 <hr />
 <div class="row">
    <div class="col-md-offset-4 col-md-4 col-center">
        <ul class="list-group">
            <li class="list-group-item"><span class="tag tag-info">ชื่อแผนก:</span> {{ $dep->dep_name }}</li>
            <li class="list-group-item"><span class="tag tag-info">ผู้ควบคุม:</span> {{ $dep->manager }}</li>
            <li class="list-group-item"><span class="tag tag-info">เบอร์โทร:</span> {{ $dep->phone }}</li>
            <li class="list-group-item"><span class="tag tag-info">สร้างโดย:</span> {{ $dep->created_by }}</li>
            <li class="list-group-item"><span class="tag tag-info">วันที่สร้าง:</span> {{ date("d", strtotime($dep->created_at)).'-'.date("m", strtotime($dep->created_at)).'-'.(date("Y", strtotime($dep->created_at))+543)  }}</li>
        </ul>
    </div>
 </div>
 <hr />
<div class="row">
    <div class="col-xs-12 col-md-12"><a href="{{ url('department') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>

@endsection
