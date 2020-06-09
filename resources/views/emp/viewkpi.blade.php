@extends('app')

@section('content')

<div class="row">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('emp') }}"> KPI</a></li>
        <li class="breadcrumb-item active">ข้อมูล KPI</li>
    </ol>
</div>

 <div class="row">
    <div class="col-xs-12 col-md-10"><h1 id="content" class="bd-title">ข้อมูล KPI รหัส {{ $kpi->code }}</h1></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('emp') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>
 <hr />
 <div class="row">
    <div class="col-md-offset-2 col-md-8 col-center">
        <ul class="list-group">
            <li class="list-group-item"><span class="tag tag-info">ชื่อกลุ่ม KPI:</span> {{ $kpigroup->group_name }}</li>
            <li class="list-group-item"><span class="tag tag-info">รหัส:</span> {{ $kpi->code }}</li>
            <li class="list-group-item"><span class="tag tag-info">ชื่อไทย:</span> {{ $kpi->kpi_name_th }}</li>
            <li class="list-group-item"><span class="tag tag-info">ชื่ออังกฤษ:</span> {{ $kpi->kpi_name_en }}</li>
            <li class="list-group-item"><span class="tag tag-info">นิยาม:</span> {{ $kpi->meta }}</li>
            <li class="list-group-item"><span class="tag tag-info">วัตถุประสงค์:</span> {{ $kpi->objective }}</li>
            <li class="list-group-item"><span class="tag tag-info">ความถี่:</span> {{ $around->around_name }}</li>
            <li class="list-group-item"><span class="tag tag-info">ค่ามาตรฐาน:</span> {{ $kpi->zi }}</li>
        </ul>
    </div>
 </div>
 <hr />
<div class="row">
    <div class="col-xs-12 col-md-12"><a href="{{ url('emp') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>

@endsection
