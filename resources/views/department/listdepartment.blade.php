@extends('app')

@section('content')

 <div class="row">
     <h1 id="content" class="bd-title"><i class="fa fa-building" aria-hidden="true"></i> แผนก</h1>
     <hr />
 </div>
 
 <div class="row">
    <div class="col-sm-6 col-md-9">
        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
            <a href="{{ route('department.create') }}" class="btn btn-primary"><i class="fa fa-plus-square" aria-hidden="true"></i> เพิ่มข้อมูล</a>           
            <a href="{{ url('department') }}" class="btn btn-warning"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            <a href="#" id="dep-del" class="btn btn-danger disabled" ><i class="fa fa-minus-square" aria-hidden="true"></i> ลบข้อมูล</a>
        </div>
    </div>
    <div class="col-sm-6 col-md-3 offset-md-0">
        {{ Form::open( array( 'url' => 'department/search', 'class' => 'search-box' ) ) }}
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
        <table id="table-dep" class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>
                        <div class="form-check-table">
                        <label class="form-check-label">
                            <input class="form-check-input check-depall" type="checkbox" >    
                        </label>
                        </div>
                    </th>
                    <th>ลำดับ</th>
                    <th>แผนก</th>
                    <th>ผู้ควบคุม</th>
                    <th>เบอร์โทร</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dep as $key => $value)
                <tr data-id="{{ $value->id }}">
                    <td class="form-check-table">
                        <label class="form-check-label">
                            <input class="form-check-input check-dep" name="keydep[]" type="checkbox" id="{{ $value->id }}" value="{{ $value->id }}">    
                        </label>
                    </td>
                    <th scope="row">{{ ($dep->currentpage()-1) * $dep->perpage() + $key + 1 }}</th>
                    <td>{{ $value->dep_name }}</td>
                    <td>{{ $value->manager }}</td>
                    <td>{{ $value->phone }}</td>
                    <td>
                        <a class="btn btn-link btn-sm" href="{{ route( 'department.show', Crypt::encrypt($value->id) ) }}"><i class="fa fa-search-plus" aria-hidden="true"></i> รายละเอียด</a>
                        <a class="btn btn-link btn-sm" href="{{ route( 'department.edit', Crypt::encrypt($value->id) ) }}"><i class="fa fa-pencil-square" aria-hidden="true"></i> แก้ไข</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>       
        </div>
    </div>
    <div class="center-block"><?php if(count($dep) == 0){ echo '- ไม่มีข้อมูล'; } ?></div>
 </div>
 <div class="row">
     <?php //echo $dep->links(); ?>
    @include('pagination', ['paginator' => $dep, 'interval' => 5])
 </div>

@endsection
