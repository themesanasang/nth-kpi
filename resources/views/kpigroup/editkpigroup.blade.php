@extends('app')

@section('content')

<div class="row">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('kpigroup') }}">KPI Group</a></li>
        <li class="breadcrumb-item active">แก้ไข KPI Group</li>
    </ol>
</div>

 <div class="row">
    <div class="col-xs-12 col-md-10"><h1 id="content" class="bd-title">แก้ไข KPI Group</h1></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('kpigroup') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>
 <hr />
 <div class="row">
    <div class="col-md-offset-3 col-md-6 col-center">

    {!! Form::open( array('route' => ['kpigroup.update', Crypt::encrypt($kpigroup['id'])], 'class' => '', 'method' => 'PATCH') ) !!}
        <div class="form-group">           
            @if($errors->has('group_name'))
                <label for="group_name" class="text-danger">{!! $errors->first('group_name') !!} ชื่อกลุ่ม KPI</label>
            @else
                <label for="group_name"> ชื่อกลุ่ม KPI</label>
            @endif	
            <input type="text" class="form-control" name="group_name" required="" placeholder="ชื่อกลุ่ม KPI" value="{{ $kpigroup->group_name }}">
        </div>
        <button type="submit" class="btn btn-success">บันทึก</button>
    {!! Form::close() !!}<!-- form -->

    </div>
 </div>
 <hr />
<div class="row">
    <div class="col-xs-12 col-md-12"><a href="{{ url('kpigroup') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>

@endsection
