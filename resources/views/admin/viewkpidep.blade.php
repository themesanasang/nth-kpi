@extends('app')

@section('content')

 <div class="row">
     <h1 id="content" class="bd-title"><i class="fa fa-home" aria-hidden="true"></i> ข้อมูล KPI แผนก {{ $dep->dep_name }}</h1>
     <hr />
 </div>
 <div class="row">
    <div class="col-xs-12 col-md-10"></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('admin') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
</div>
<br/>

<div class="row">
    <div class="col-md-offset-3 col-md-6 col-center">
   <?php
        if(count($yearAll) == 0){
              echo '- ไม่มีข้อมูล';  
        }else{
   ?>
    
        <form>
        <input type="hidden" id="oldid" value="{{ $oldid }}" />
        <input type="hidden" id="showdep" value="{{ $dep->id }}" />
        <div class="form-group row">
            <label for="group_id" class="col-sm-4 col-form-label"> เลือกปีงบประมาณ: </label>	
            <div class="col-sm-6 col-md-6">
                {!! Form::select('yearAll', ['none' => 'กรุณาเลือก']+$yearAll, null, ['class'=> 'form-control', 'id' => 'getDataKpiDep']) !!}
            </div>
        </div>
        </form>

   <?php } ?>
   </div>
</div>



<div id="show-kpiall-dep">
    <div class="row">
        <div class="col-md-offset-3 col-md-8 col-center">
            <h5>ข้อมูล KPI ปี</h5>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-xs-12 col-md-10"></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('admin') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
</div>

@endsection
