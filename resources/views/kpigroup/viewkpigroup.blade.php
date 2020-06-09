@extends('app')

@section('content')

<div class="row">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('kpigroup') }}"> KPI Group</a></li>
        <li class="breadcrumb-item active">ข้อมูล KPI Group</li>
    </ol>
</div>

 <div class="row">
    <div class="col-xs-12 col-md-10"><h1 id="content" class="bd-title">ข้อมูล KPI Group {{ $kpigroup->group_name }}</h1></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('kpigroup') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>
 <hr />
 <div class="row">
    <div class="col-md-offset-3 col-md-6 col-center">
        <ul class="list-group">
            <li class="list-group-item"><span class="tag tag-info">ชื่อกลุ่ม KPI:</span> {{ $kpigroup->group_name }}</li>
            <li class="list-group-item"><span class="tag tag-info">วันที่สร้าง:</span> {{ date("d", strtotime($kpigroup->created_at)).'-'.date("m", strtotime($kpigroup->created_at)).'-'.(date("Y", strtotime($kpigroup->created_at))+543)  }}</li>
        </ul>
    </div>
 </div>
 <hr />
<div class="row">
    <div class="col-xs-12 col-md-12"><a href="{{ url('kpigroup') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>

@endsection
