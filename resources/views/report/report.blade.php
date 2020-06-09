@extends('app')

@section('content')

 <div class="row">
     <h1 id="content" class="bd-title"><i class="fa fa-bar-chart" aria-hidden="true"></i> รายงาน</h1>
     <hr />
 </div>
 
 <div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="card">
        <div class="card-block">
            <h3 class="card-title">รายงาน KPI</h3>
            <p class="card-text">ส่งออกรายงาน KPI ทั้งหมด</p>
            <a href="{{ url('report/kpiall') }}" class="btn btn-success">ดูรายงาน</a>
        </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
         
    </div>
 </div>

@endsection
