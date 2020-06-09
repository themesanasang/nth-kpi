@extends('app')

@section('content')

<div class="row">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('department') }}">แผนก</a></li>
        <li class="breadcrumb-item active">แก้ไขแผนก</li>
    </ol>
</div>

 <div class="row">
    <div class="col-xs-12 col-md-10"><h1 id="content" class="bd-title">แก้ไขแผนก {{ $dep->dep_name }}</h1></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('department') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>
 <hr />
 <div class="row">
    <div class="col-md-offset-4 col-md-4 col-center">

    @if(Session::has('error_dep_no'))
        <div class="alert alert-dismissable alert-danger">         			  
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ Session::get('error_dep_no') }}
        </div>
    @endif

   {!! Form::open( array('route' => ['department.update', Crypt::encrypt($dep['id'])], 'class' => '', 'method' => 'PATCH') ) !!}	
        <div class="form-group">           
            @if($errors->has('dep_name'))
                <label for="dep_name" class="text-danger">{!! $errors->first('dep_name') !!} ชื่อแผนก</label>
            @else
                <label for="dep_name">ชื่อแผนก</label>
            @endif	
            <input type="text" class="form-control" name="dep_name" required="" placeholder="ชื่อแผนก" value="{{ $dep->dep_name }}">
        </div>
        <div class="form-group">
            @if($errors->has('manager'))
                <label for="manager" class="text-danger">{!! $errors->first('manager') !!} ผู้ควบคุม</label>
            @else
                <label for="manager">ผู้ควบคุม</label>
            @endif	           
            <input type="text" class="form-control" name="manager"  placeholder="ผู้ควบคุม" value="{{ $dep->manager }}">
        </div>
        <div class="form-group">
             @if($errors->has('phone'))
                <label for="phone" class="text-danger">{!! $errors->first('phone') !!} เบอร์โทร</label>
            @else
                <label for="phone">เบอร์โทร</label>
            @endif	
            <input type="text" class="form-control" name="phone" placeholder="เบอร์โทร" value="{{ $dep->phone }}">
        </div>
        <button type="submit" class="btn btn-success">บันทึก</button>
    {!! Form::close() !!}<!-- form -->

    </div>
 </div>
 <hr />
<div class="row">
    <div class="col-xs-12 col-md-12"><a href="{{ url('department') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>

@endsection
