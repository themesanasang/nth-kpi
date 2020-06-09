@extends('app')

@section('content')

 <div class="row">
     <h1 id="content" class="bd-title"><i class="fa fa-object-group" aria-hidden="true"></i> จัดสรร KPI ให้กับแผนก</h1>
     <hr />
 </div>
 
 
<div class="row">
    <div class="col-sm-12 col-md-5">
        <div class="content-box-drag">
            <form>
                 <div class="form-group">
                    <label for="selectgroupkpi">เลือกกลุ่ม KPI</label>
                    {!! Form::select('group_id', ['none' => 'กรุณาเลือก']+$kpigroup, null, ['class'=> 'form-control', 'id' => 'selectgroupkpi']) !!}
                </div>
            </form>
            <div id="show-kpi" class="detail-box"></div>
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="content-box-drag-center">
            <form class="center-block">
                <a id="btntranferkpi" href="javascript:void(0)" class="btn btn-primary">จัดสรร</a>
            </form>
        </div>
    </div>
    <div class="col-sm-12 col-md-5">
        <div class="content-box-drag">
            <form>
                 <div class="form-group">
                    <label for="selectdepkpi">เลือกแผนก</label>
                    {!! Form::select('dep_id', ['none' => 'กรุณาเลือก']+$dep, null, ['class'=> 'form-control', 'id' => 'selectdepkpi']) !!}
                </div>
            </form>
            <div id="show-kpitodep" class="detail-box"></div>
        </div>
    </div>
</div>
 

@endsection
