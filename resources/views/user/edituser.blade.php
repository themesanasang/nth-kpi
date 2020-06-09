@extends('app')

@section('content')

<div class="row">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ url('user') }}">ผู้ใช้งาน</a></li>
        <li class="breadcrumb-item active">แก้ไขผู้ใช้งาน</li>
    </ol>
</div>

 <div class="row">
    <div class="col-xs-12 col-md-10"><h1 id="content" class="bd-title">แก้ไขผู้ใช้งาน {{ $user->username }}</h1></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('user') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
 </div>
 <hr />
 <div class="row">
    <div class="col-md-offset-4 col-md-4 col-center">

    {!! Form::open( array('route' => ['user.update', Crypt::encrypt($user['id'])], 'class' => '', 'method' => 'PATCH') ) !!}
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
        <div class="form-group">
            <label for="dep_id">แผนก</label>
            {!! Form::select('dep_id', $dep, $user->dep_id, ['class'=> 'form-control']) !!}
        </div>
        <fieldset class="form-group">
            <label>ทีม:</label>
            <div class="form-check">
            <label class="form-check-label">
                {!! Form::radio('team', 'ทีมหน่วยงาน', $user->team == 'ทีมหน่วยงาน', ['class' => '']) !!}
                ทีมหน่วยงาน
            </label>
            </div>
            <div class="form-check">
            <label class="form-check-label">
                {!! Form::radio('team', 'ทีมคร่อมสายงาน', $user->team == 'ทีมคร่อมสายงาน', ['class' => '']) !!}
                ทีมคร่อมสายงาน
            </label>
            </div>
        </fieldset>
        <fieldset class="form-group">
            <label>สิทธิ์:</label>
            <div class="form-check">
            <label class="form-check-label">
                {!! Form::radio('level', '0', $user->level == 0, ['class' => '']) !!}
                ผู้ใช้ทั่วไป
            </label>
            </div>
            <div class="form-check">
            <label class="form-check-label">
               {!! Form::radio('level', '1', $user->level == 1, ['class' => '']) !!}
                ผู้ดูแลระบบ
            </label>
            </div>
        </fieldset>
        <fieldset class="form-group">
            <label>สถานะ:</label>
            <div class="form-check">
            <label class="form-check-label">
                {!! Form::radio('status', '0', $user->status == 0, ['class' => '']) !!}
                ปิด
            </label>
            </div>
            <div class="form-check">
            <label class="form-check-label">
                {!! Form::radio('status', '1', $user->status == 1, ['class' => '']) !!}
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
