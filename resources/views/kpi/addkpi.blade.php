@extends('app')

@section('content')

<div class="row">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('kpi') }}">KPI</a></li>
        <li class="breadcrumb-item active">เพิ่ม KPI</li>
    </ol>
</div>

 <div class="row">
    <div class="col-xs-12 col-md-10"><h1 id="content" class="bd-title">เพิ่ม KPI</h1></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('kpi') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>
 <hr />
 <div class="row">
    <div class="col-md-offset-2 col-md-8 col-center">

    @if(Session::has('error_kpi_no'))
        <div class="alert alert-dismissable alert-danger">         			  
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ Session::get('error_kpi_no') }}
        </div>
    @endif

    {!! Form::open( array('route' => 'kpi.store', 'id' => 'kpiform') ) !!}
        <div class="form-group row">
             @if($errors->has('group_id'))
                <label for="group_id" class="col-sm-2 col-form-label text-danger">{!! $errors->first('code') !!} กลุ่ม KPI</label>
            @else
                <label for="group_id" class="col-sm-2 col-form-label"> กลุ่ม KPI</label>
            @endif	
            <div class="col-sm-8 col-md-5">
                {!! Form::select('group_id', ['' => 'กรุณาเลือก']+$kpigroup, null, ['class'=> 'form-control', 'required' => '']) !!}
            </div>
        </div>
        <div class="form-group row">           
            @if($errors->has('code'))
                <label for="code" class="col-sm-2 col-form-label text-danger">{!! $errors->first('code') !!} รหัส KPI</label>
            @else
                <label for="code" class="col-sm-2 col-form-label"> รหัส KPI</label>
            @endif	
            <div class="col-sm-8 col-md-3">
                <input type="text" class="form-control" name="code" required="" placeholder=" รหัส KPI">
            </div>
        </div>
        <div class="form-group row">           
            @if($errors->has('kpi_name_th'))
                <label for="kpi_name_th" class="col-sm-2 col-form-label text-danger">{!! $errors->first('kpi_name_th') !!} ชื่อไทย</label>
            @else
                <label for="kpi_name_th" class="col-sm-2 col-form-label"> ชื่อไทย</label>
            @endif	
            <div class="col-sm-10">
                <input type="text" class="form-control" name="kpi_name_th" required="" placeholder=" ชื่อไทย">
            </div>
        </div>
        <div class="form-group row">           
            @if($errors->has('kpi_name_en'))
                <label for="kpi_name_en" class="col-sm-2 col-form-label text-danger">{!! $errors->first('kpi_name_en') !!} ชื่ออังกฤษ</label>
            @else
                <label for="kpi_name_en" class="col-sm-2 col-form-label"> ชื่ออังกฤษ</label>
            @endif	
            <div class="col-sm-10">
                <input type="text" class="form-control" name="kpi_name_en" placeholder=" ชื่ออังกฤษ">
            </div>
        </div>
        <div class="form-group row">           
            @if($errors->has('meta'))
                <label for="meta" class="col-sm-2 col-form-label text-danger">{!! $errors->first('meta') !!} นิยาม</label>
            @else
                <label for="meta" class="col-sm-2 col-form-label"> นิยาม</label>
            @endif	
            <div class="col-sm-10">
                <textarea class="form-control" name="meta" rows="2"></textarea>
            </div>
        </div>

       <div class="form-group row">
            <label for="group_id" class="col-sm-2 col-form-label"> ความถี่</label>	
            <div class="col-sm-8 col-md-5">
                {!! Form::select('around_id', $around, null, ['class'=> 'form-control']) !!}
            </div>
        </div>

        <div class="form-group row">           
            @if($errors->has('objective'))
                <label for="objective" class="col-sm-2 col-form-label text-danger">{!! $errors->first('objective') !!} วัตถุประสงค์</label>
            @else
                <label for="objective" class="col-sm-2 col-form-label"> วัตถุประสงค์</label>
            @endif	
            <div class="col-sm-10">
                <input type="text" class="form-control" name="objective" placeholder=" วัตถุประสงค์">
            </div>
        </div>
        <fieldset class="form-group row">
        <label class="col-form-legend col-sm-2">ตัวหาร:</label>
            <div class="col-sm-10">
                <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" name="has_section" value="1" checked="">
                    มี
                </label>
                </div>
                <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" name="has_section" value="0">
                    ไม่มี
                </label>
                </div>
            </div>
        </fieldset>
         <div class="form-group row">           
            @if($errors->has('multiply'))
                <label for="multiply" class="col-sm-2 col-form-label text-danger">{!! $errors->first('multiply') !!} ตัวคูณในสูตร</label>
            @else
                <label for="multiply" class="col-sm-2 col-form-label"> ตัวคูณในสูตร</label>
            @endif	
            <div class="col-sm-8 col-md-3">
                <input type="number" class="form-control" name="multiply" value="0" />
            </div>
        </div>
        <div class="form-group row">
            <label for="group_id" class="col-sm-2 col-form-label"> กลุ่มโรค</label>	
            <div class="col-sm-8 col-md-5">
                {!! Form::select('disease_group', ['' => 'กรุณาเลือก']+$disease, null, ['class'=> 'form-control', 'required' => '']) !!}
            </div>
        </div>
        <div class="form-group row">           
            <label for="code" class="col-sm-2 col-form-label"> ค่ามาตรฐาน</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="zi" placeholder=" ค่ามาตรฐาน">
            </div>
        </div>
        <fieldset class="form-group row">
        <label class="col-form-legend col-sm-2">สถานะ:</label>
            <div class="col-sm-10">
                <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" name="status" value="1" checked="">
                    เปิด
                </label>
                </div>
                <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" name="status" value="0">
                    ปิด
                </label>
                </div>
            </div>
        </fieldset>

        <button type="submit" class="btn btn-success">บันทึก</button>
    {!! Form::close() !!}<!-- form -->

    </div>
 </div>
 <hr />
<div class="row">
    <div class="col-xs-12 col-md-12"><a href="{{ url('kpi') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>

@endsection
