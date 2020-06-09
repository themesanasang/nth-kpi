@extends('app')

@section('content')

<div class="row">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('diseasegroup') }}">กลุ่มโรค</a></li>
        <li class="breadcrumb-item active">เพิ่ม กลุ่มโรค</li>
    </ol>
</div>

 <div class="row">
    <div class="col-xs-12 col-md-10"><h1 id="content" class="bd-title">เพิ่ม กลุ่มโรค</h1></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('diseasegroup') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>
 <hr />
 <div class="row">
    <div class="col-md-offset-3 col-md-6 col-center">

    @if(Session::has('error_diseasegroup_no'))
        <div class="alert alert-dismissable alert-danger">         			  
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ Session::get('error_diseasegroup_no') }}
        </div>
    @endif

    {!! Form::open( array('route' => 'diseasegroup.store', 'class' => '') ) !!}
        <div class="form-group">           
            @if($errors->has('disease'))
                <label for="disease" class="text-danger">{!! $errors->first('disease') !!} กลุ่มโรค</label>
            @else
                <label for="disease"> กลุ่มโรค</label>
            @endif	
            <input type="text" class="form-control" name="disease" required="" placeholder=" กลุ่มโรค">
        </div>
        <div class="form-group">  
            <label for="detail"> รายละเอียด</label> 
            <textarea class="form-control" name="detail" rows="2"></textarea>
        </div>
        <button type="submit" class="btn btn-success">บันทึก</button>
    {!! Form::close() !!}<!-- form -->

    </div>
 </div>
 <hr />
<div class="row">
    <div class="col-xs-12 col-md-12"><a href="{{ url('diseasegroup') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>

@endsection
