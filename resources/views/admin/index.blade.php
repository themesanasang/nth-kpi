@extends('app')

@section('content')


<!-- ////////////////////////////// KPI ประจำแผนก /////////////////////////////////////// -->

<div class="row">
     <h1 class="bd-title"><i class="fa fa-home" aria-hidden="true"></i> ข้อมูล KPI ประจำแผนก</h1>
     <hr />
 </div>

<div class="row">
    <div class="col-md-offset-3 col-md-6 col-center">
        
            
           <div class="table-responsive">
            <table class="table-kpi table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>แผนก</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=0; ?>
                    @foreach($data as $key => $value)
                    <?php $i++; ?>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $value->dep_name }}</td>
                        <td>
                            <a href="{{ url('viewkpidep') }}/{{ Crypt::encrypt($value->id) }}" class="btn btn-link">ดูข้อมูล</a>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>       
            </div>

            
    </div>
</div>

@endsection
