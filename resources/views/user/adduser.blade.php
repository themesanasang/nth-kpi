@extends('app')

@section('content')

<div class="row">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('user') }}">ผู้ใช้งาน</a></li>
        <li class="breadcrumb-item active">เพิ่มผู้ใช้งาน</li>
    </ol>
</div>

 <div class="row">
    <div class="col-xs-12 col-md-10"><h1 id="content" class="bd-title">เพิ่มผู้ใช้งาน</h1></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('user') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
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

    {!! Form::open( array('route' => 'user.store', 'class' => '') ) !!}
        <div class="form-group">           
            @if($errors->has('username'))
                <label for="username" class="text-danger">{!! $errors->first('username') !!} ชื่อผู้ใช้งาน</label>
            @else
                <label for="username">ชื่อผู้ใช้งาน</label>
            @endif	
            <input type="text" class="form-control" name="username" required="" placeholder="ชื่อผู้ใช้งาน">
        </div>
        <div class="form-group">
            @if($errors->has('password'))
                <label for="password" class="text-danger">{!! $errors->first('password') !!} รหัสผ่าน</label>
            @else
                <label for="password">รหัสผ่าน</label>
            @endif	           
            <input type="password" class="form-control" name="password" required="" placeholder="รหัสผ่าน">
        </div>
        <div class="form-group">
             @if($errors->has('fullname'))
                <label for="fullname" class="text-danger">{!! $errors->first('fullname') !!} ชื่อ-นามสกุล</label>
            @else
                <label for="fullname">ชื่อ-นามสกุล</label>
            @endif	
            <input type="text" class="form-control" name="fullname" required="" placeholder="ชื่อ-นามสกุล">
        </div>
        <div class="form-group">
             @if($errors->has('phone'))
                <label for="phone" class="text-danger">{!! $errors->first('phone') !!} เบอร์โทร</label>
            @else
                <label for="phone">เบอร์โทร</label>
            @endif	
            <input type="text" class="form-control" name="phone" placeholder="เบอร์โทร">
        </div>
        <div class="form-group">
            <label for="email">อีเมล์</label>
            <input type="text" class="form-control" name="email"  placeholder="อีเมล์">
        </div>
        <div class="form-group">
            <label for="dep_id">แผนก</label>
            {!! Form::select('dep_id', $dep, null, ['class'=> 'form-control']) !!}
        </div>
        <fieldset class="form-group">
            <label>ทีม:</label>
            <div class="form-check">
            <label class="form-check-label">
                <input type="radio" name="team" value="ทีมหน่วยงาน" checked="">
                ทีมหน่วยงาน
            </label>
            </div>
            <div class="form-check">
            <label class="form-check-label">
                <input type="radio" name="team" value="ทีมคร่อมสายงาน">
                ทีมคร่อมสายงาน
            </label>
            </div>
        </fieldset>
        <fieldset class="form-group">
            <label>สิทธิ์:</label>
            <div class="form-check">
            <label class="form-check-label">
                <input type="radio" name="level" value="0" checked="">
                ผู้ใช้ทั่วไป
            </label>
            </div>
            <div class="form-check">
            <label class="form-check-label">
                <input type="radio" name="level" value="1">
                ผู้ดูแลระบบ
            </label>
            </div>
        </fieldset>
        <fieldset class="form-group">
            <label>สถานะ:</label>
            <div class="form-check">
            <label class="form-check-label">
                <input type="radio" name="status" value="0" checked="">
                ปิด
            </label>
            </div>
            <div class="form-check">
            <label class="form-check-label">
                <input type="radio" name="status" value="1">
                เปิด
            </label>
            </div>
        </fieldset>
        <button type="submit" class="btn btn-success">บันทึก</button>
    {!! Form::close() !!}<!-- form -->

    </div>
 </div>
 <hr />
<div class="row">
    <div class="col-xs-12 col-md-12"><a href="{{ url('user') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>

@endsection
