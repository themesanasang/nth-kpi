
<div class="row">
    <div class="col-md-12 col-center">

       <div class="table-responsive">
            <table class="table-kpi table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>รหัส</th>
                        <th>ชื่อไทย</th>
                        <th>#</th>
                        <th>รอบ</th>
                        <th>ตัวตั้ง</th>
                        <th>ตัวหาร</th>
                        <th>ตัวคูณ</th>
                        <th>ผล</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $value)

                    <tr>
                        <td>{{ $value->code }}</td>
                        <td>{{ $value->kpi_name_th }}</td>
                        <td>{{ $value->around_name }}</td>
                        <td>รอบที่ {{ $value->around }}</td>
                        <td>{{ $value->fraction }}</td>
                        <td>{{ $value->section }}</td>
                        <td>{{ $value->multiply }}</td>
                        <td>{{ $value->result }}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>       
            </div>

    </div>
</div>