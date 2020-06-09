@extends('app')

@section('content')

<div class="row">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        <li class="breadcrumb-item active">ข้อมูลส่วนตัว</li>
    </ol>
</div>

<div class="row">
    <div class="col-xs-12 col-md-10"><h1 id="content" class="bd-title">ข้อมูลส่วนตัว {{ $user->username }}</h1></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('profileEdit') }}/{{ Crypt::encrypt($user->id) }}" class="btn btn-link btn-sm pull-right">แก้ไขข้อมูล</a></div>
 </div>
 <hr />
 <div class="row">
    <div class="col-md-offset-3 col-md-6 col-center">    
        <ul class="list-group">
            <li class="list-group-item"><span class="tag tag-info">ชื่อผู้ใช้งาน:</span> {{ $user->username }}</li>
            <li class="list-group-item"><span class="tag tag-info">ชื่อ-นามสกุล:</span> {{ $user->fullname }}</li>
            <li class="list-group-item"><span class="tag tag-info">เบอร์โทร:</span> {{ $user->phone }}</li>
            <li class="list-group-item"><span class="tag tag-info">อีเมล์:</span> {{ $user->email }}</li>
            <li class="list-group-item"><span class="tag tag-info">แผนก:</span> {{ $dep->dep_name }}</li>
            <li class="list-group-item"><span class="tag tag-info">ระดับใช้งาน:</span> <span class="text-primary">{{ (($user->level == 1)?"ผู้ดูแลระบบ":'ผู้ใช้งานทั่วไป') }}</span></li>
            <li class="list-group-item"><span class="tag tag-info">สถานะการใช้งาน:</span> <?php echo (($user->status == 0)?"<span class='text-danger'>ปิดใช้งาน</span>":"<span class='text-success'>เปิดใช้งาน</span>") ?></li>
            <li class="list-group-item"><span class="tag tag-info">วันที่สร้าง:</span> {{ date("d", strtotime($user->created_at)).'-'.date("m", strtotime($user->created_at)).'-'.(date("Y", strtotime($user->created_at))+543)  }}</li>
        </ul>
    </div>
 </div>
 <hr />
<div class="row">
    <div class="col-xs-12 col-md-12"><a href="{{ url('profileEdit') }}/{{ Crypt::encrypt($user->id) }}" class="btn btn-link btn-sm pull-right">แก้ไขข้อมูล</a></div>
</div>

@endsection
