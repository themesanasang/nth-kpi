@extends('app')

@section('content')

 <div class="row">
     <h1 id="content" class="bd-title"><i class="fa fa-book" aria-hidden="true"></i> KPI Group</h1>
     <hr />
 </div>
 
 <div class="row">
    <div class="col-sm-6 col-md-9">
        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
            <a href="{{ route('kpigroup.create') }}" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> เพิ่มข้อมูล</a>           
            <a href="{{ url('kpigroup') }}" class="btn btn-warning"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <a href="#" id="kpigroup-del" class="btn btn-danger disabled" ><i class="fa fa-minus-square" aria-hidden="true"></i> ลบข้อมูล</a>
        </div>
    </div>
    <div class="col-sm-6 col-md-3 offset-md-0">
        {{ Form::open( array( 'url' => 'kpigroup/search', 'class' => 'search-box' ) ) }}
            <div class="input-group pull-right">
                <input class="form-control" name="search" placeholder="ค้นหา..." type="text">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="submit"><i class="fa fa-search fa-lg" aria-hidden="true"></i></button>
                </span>
            </div>
        {{ Form::close() }}
    </div>     
 </div>
<br />
 <div class="row">
    <div>
        <div class="table-responsive">
        <table id="table-kpigroup" class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>
                        <div class="form-check-table">
                        <label class="form-check-label">
                            <input class="form-check-input check-kpigroupall" type="checkbox" >    
                        </label>
                        </div>
                    </th>
                    <th>ลำดับ</th>
                    <th>ชื่อกลุ่ม</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kpigroup as $key => $value)
                <tr data-id="{{ $value->id }}">
                    <td class="form-check-table">
                        <label class="form-check-label">
                            <input class="form-check-input check-kpigroup" name="keykpigroup[]" type="checkbox" id="{{ $value->id }}" value="{{ $value->id }}">    
                        </label>
                    </td>
                    <th scope="row">{{ ($kpigroup->currentpage()-1) * $kpigroup->perpage() + $key + 1 }}</th>
                    <td>{{ $value->group_name }}</td>
                    <td>
                        <a class="btn btn-link btn-sm" href="{{ route( 'kpigroup.show', Crypt::encrypt($value->id) ) }}"><i class="fa fa-search-plus" aria-hidden="true"></i> รายละเอียด</a>
                        <a class="btn btn-link btn-sm" href="{{ route( 'kpigroup.edit', Crypt::encrypt($value->id) ) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> แก้ไข</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>       
        </div>
    </div>
    <div class="center-block"><?php if(count($kpigroup) == 0){ echo '- ไม่มีข้อมูล'; } ?></div>
 </div>
 <div class="row">
    @include('pagination', ['paginator' => $kpigroup, 'interval' => 5])
 </div>

@endsection
