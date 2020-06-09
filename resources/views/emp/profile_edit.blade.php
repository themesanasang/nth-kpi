@extends('app')

@section('content')

<div class="row">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('profile') }}/{{ Crypt::encrypt(Session::get('user_id')) }}">ข้อมูลส่วนตัว</a></li>
        <li class="breadcrumb-item active">แก้ไขข้อมูลส่วนตัว</li>
    </ol>
</div>

 <div class="row">
    <div class="col-xs-12 col-md-10"><h1 id="content" class="bd-title">แก้ไขข้อมูลส่วนตัว {{ $user->username }}</h1></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('profile') }}/{{ Crypt::encrypt(Session::get('user_id')) }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>
 <hr />
 <div class="row">
    <div class="col-md-offset-4 col-md-4 col-center">

    {!! Form::open( array('route' => ['emp.update', Crypt::encrypt($user['id'])], 'class' => '', 'method' => 'PATCH') ) !!}
        <label for="password">รหัสผ่านใหม่</label>
        <div class="form-group">          
            <input type="password" class="form-control" name="password" placeholder="รหัสผ่านใหม่">
        </div>
        <div class="form-group">
             @if($errors->has('fullname'))
                <label for="fullname" class="text-danger">{!! $errors->first('fullname') !!} ชื่อ-นามสกุล</label>
            @else
                <label for="fullname">ชื่อ-นามสกุล</label>
            @endif	
            <input type="text" class="form-control" name="fullname" required="" placeholder="ชื่อ-นามสกุล" value="{{ $user->fullname }}">
        </div>
        <div class="form-group">
             @if($errors->has('phone'))
                <label for="phone" class="text-danger">{!! $errors->first('phone') !!} เบอร์โทร</label>
            @else
                <label for="phone">เบอร์โทร</label>
            @endif	
            <input type="text" class="form-control" name="phone" placeholder="เบอร์โทร" value="{{ $user->phone }}">
        </div>
        <div class="form-group">
            <label for="email">อีเมล์</label>
            <input type="text" class="form-control" name="email"  placeholder="อีเมล์" value="{{ $user->email }}">
        </div>
        
        <button type="submit" class="btn btn-success">บันทึก</button>
    {!! Form::close() !!}<!-- form -->

    </div>
 </div>
 <hr />
<div class="row">
    <div class="col-xs-12 col-md-12"><a href="{{ url('profile') }}/{{ Crypt::encrypt(Session::get('user_id')) }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>

@endsection
