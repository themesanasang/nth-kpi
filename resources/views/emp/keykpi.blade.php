@extends('app')

@section('content')


<div class="row">
     <h1 id="content" class="bd-title">
        <i class="fa fa-book" aria-hidden="true"></i> 
        ลงข้อมูล KPI รหัส {{ $kpi->code }} 
     </h1>
     <hr />
</div>

<div class="row">
    <h1 id="content" class="bd-title">
        <i class="fa fa-book" aria-hidden="true"></i> 
        รายละเอียด
     </h1>
     <p>
        {{ $kpi->meta }} 
     </p>
     <hr />
</div>

<div class="row">
    <div class="col-xs-12 col-md-10"></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('emp') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
</div>

<div class="row">
    <div class="col-md-12 col-center">
        <form id="keykpi">
            
           <div class="table-responsive">
            <table class="table-keykpi table table-sm">
                <thead>
                    <tr>
                        <th></th>
                        <th>ตัวตั้ง</th>
                         @if($kpi->has_section == 1)<th>ตัวหาร</th>@endif
                         @if($kpi->multiply > 0)<th>ตัวคูณ</th>@endif
                        <th>ผลลัพธ์</th> 
                        <th>ค่ามาตรฐาน</th>
                        <th>หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>
            
                   <input type="hidden" name="idold" value="{{ $idold }}"  />
                   <input type="hidden" name="around_id" value="{{ $kpi->around_id }}"  />
                   <input type="hidden" name="kpi_id" value="{{ $kpi->id }}"  />
                   <input type="hidden" name="multiply" value="{{ $kpi->multiply }}"  />             
                   
                   <?php 
                        $row=0; 
                        $status_row = '';
                        $status_ap = '';
                        $keyclose = 0;
                    ?>
                    @for($i = 0; $i<=$r-1; $i++ )

                        <?php 
                            $row++; 
                            
                            /*if($row <= count($kpiresult)) {
                                //echo $row;
                                if($kpiresult[$i]['approve'] == '1'){ 
                                   $status_row = 'readonly'; 
                                   $status_ap = '1';
                                }else{
                                    $status_row = '';
                                    $status_ap = '0';
                                }
                            }else{
                                if(count($kpiresult) > 0){
                                    if(($row - count($kpiresult)) == 1 && $status_ap == '1'){
                                        //echo $row;
                                        $status_row = '';
                                    }else{
                                        $status_row = 'readonly';
                                    }
                                }else{
                                    //echo $row;
                                    if(($row - count($kpiresult)) == 1){
                                         $status_row = '';
                                    }else{
                                        $status_row = 'readonly';
                                    }
                                }
                            }*/

                            if(count($kpiresult) == $r){
                                $keyclose = $kpiresult[count($kpiresult)-1]['approve'];
                            }else{
                                $keyclose = 0;
                            }

                            $status_row = '';
                            foreach ($statuskpi as $k => $v) {
                                if($v->around == $row){
                                    echo $v->around;
                                    $status_row = 'readonly';
                                }
                            }

                            
                        ?>

                        <tr>
                        <input type="hidden" name="result_id[]" value="<?php if($row <= count($kpiresult)) {echo $kpiresult[$i]['id'];} ?>"  />
                        <input type="hidden" name="around[]" value="<?php echo $row; ?>" />
                        <td class="keykpi-c1">รอบ {{ $txtAround[$row] }}</td>
                        <td class="keykpi-c2">
                            <div class="col-md-12">
                                <input <?php echo $status_row; ?> type="text" class="form-control" name="fraction[]" value="<?php if($row <= count($kpiresult)) {echo $kpiresult[$i]['fraction'];} ?>" />
                            </div>
                        </td>

                        <!-- ตัวหาร -->
                         @if($kpi->has_section == 1)
                        <td class="keykpi-c3">
                            <div class="col-md-12">
                                <input <?php echo $status_row; ?> type="text" class="form-control" name="section[]" value="<?php if($row <= count($kpiresult)) {echo $kpiresult[$i]['section'];} ?>" />
                            </div>
                        </td>
                         @endif

                         <!-- ตัวคูณ -->
                         @if($kpi->multiply > 0)
                         <td class="keykpi-c4">
                            <div class="col-md-12">
                               {{ $kpi->multiply }}
                            </div>
                         </td>
                         @endif 

                         <td class="keykpi-c4">
                            <div class="col-md-12">
                                <?php if($row <= count($kpiresult)) {echo $kpiresult[$i]['result'];}else{ echo '-'; } ?>
                            </div>
                         </td> 

                         <td class="keykpi-c4">
                            <div class="col-md-12">
                               <?php if($kpi->zi != '') {echo $kpi->zi;}else{ echo '-'; } ?>
                            </div>
                         </td>

                        <td class="keykpi-c5">
                            <div class="col-md-12">
                                <input <?php echo $status_row; ?> type="text" class="form-control" name="comment[]" value="<?php if($row <= count($kpiresult)) {echo $kpiresult[$i]['comment'];} ?>" />
                            </div>
                        </td>
                    </tr>

                    @endfor
                </tbody>
            </table>   
            </div>

            <div class="row center-block">
                <?php 
                    if($keyclose == 1){ 
                        $closebtn = 'disabled';
                    }else{
                         $closebtn = '';
                    }
                ?>
                <a href="javascript:void(0)" id="save_kpi" class="btn btn-success {{ $closebtn }}">บันทึกข้อมูล</a>
            </div>
            
        </form>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-10"></div>
    <div class="col-xs-12 col-md-2"><a href="{{ url('emp') }}" class="btn btn-link btn-sm pull-right">กลับหน้าหลัก</a></div>
</div>

@endsection
