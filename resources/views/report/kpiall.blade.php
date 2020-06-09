@extends('app')

@section('content')

 <div class="row">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('report') }}"> รายงาน</a></li>
        <li class="breadcrumb-item active">รายงาน KPI</li>
    </ol>
</div>

 <div class="row">
    <div class="col-xs-12 col-md-10"><h1 id="content" class="bd-title">รายงาน KPI</h1></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('report') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>
 <hr />
 <div class="row">
    <div class="col-md-offset-3 col-md-6 col-center">
   <?php
        if(count($yearAll) == 0){
              echo '- ไม่มีข้อมูล';  
        }else{
   ?>
        
        {!! Form::open( array('url' => 'report/kpiall', 'id' => '') ) !!}
        <div class="form-group row">
            @if($errors->has('yearAllKpi'))
                <label for="yearAllKpi" class="col-sm-4 col-form-label text-danger">{!! $errors->first('yearAllKpi') !!} เลือกปีงบประมาณ:</label>
            @else
                 <label for="yearAllKpi" class="col-sm-4 col-form-label"> เลือกปีงบประมาณ: </label>
            @endif	
           	
            <div class="col-sm-8 col-md-8">
                {!! Form::select('yearAllKpi', ['' => 'กรุณาเลือก']+$yearAll, null, ['class'=> 'form-control', 'id' => 'yearAllKpi']) !!}               
            </div>
        </div>
        <button type="submit" class="btn btn-success pull-right" id="exportKpiResult">ส่งออก</button>
        {!! Form::close() !!}<!-- form -->

   <?php } ?>
   </div>
</div>
  <hr />
<div class="row">
    <div class="col-xs-12 col-md-12"><a href="{{ url('report') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>

@endsection
