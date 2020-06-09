@extends('app')

@section('content')


<div class="row">
     <h1 id="content" class="bd-title">
        <i class="fa fa-book" aria-hidden="true"></i> 
        KPI 
        ลงข้อมูลวันที่
        {{ date("d", strtotime($dstart)).'-'.date("m", strtotime($dstart)).'-'.(date("Y", strtotime($dstart))+543)  }}
        ถึง
        {{ date("d", strtotime($dend)).'-'.date("m", strtotime($dend)).'-'.(date("Y", strtotime($dend))+543)  }}
     </h1>
     <hr />
</div>
<div class="row">
    <div class="col-md-offset-2 col-md-12 col-center">
        <form>
            
           <div class="table-responsive">
            <table class="table-kpi table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>รหัส</th>
                        <th>ชื่อไทย</th>
                        <th>ครั้ง</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                   <?php 
                        $chk_r=''; 
                   ?>
                    @foreach($data as $key => $value)

                   <?php
                        if($chk_r != $value->around_id){
                            echo '<tr class="h-around"><td colspan="4">';
                            echo 'ความถี่ KPI: '.$value->around_name;
                            if($value->around_id==1){
                                echo ' ลงข้อมูลจำนวน 12 ครั้ง';
                            }else if($value->around_id==2){
                                echo ' ลงข้อมูลจำนวน 4 ครั้ง';
                            }else if($value->around_id==3){
                                echo ' ลงข้อมูลจำนวน 2 ครั้ง';
                            }else{
                                echo ' ลงข้อมูลจำนวน 1 ครั้ง';
                            }
                            echo '</td></tr>';
                        }
                   ?>     

                    <tr>
                        <td>{{ $value->code }}</td>
                        <td class="link-to-kpi"><a href="{{ url('viewkpi') }}/{{ Crypt::encrypt($value->id) }}">{{ $value->kpi_name_th }}</a></td>
                        <td>
                            <center>
                            <?php
                                    if($value->sumall == '' || $value->sumall == null){
                                        echo '-';
                                    }else{
                                        echo $value->sumall;
                                    }
                            ?>
                           </center>
                        </td>
                        <td>
                            <div class="col-md-12">
                            <?php if($value->status == 0){ ?>
                                 <span class="tag tag-danger center-block">ปิดลงข้อมูล</sapn>
                            <?php }else{ ?>
                                <a href="{{ url('keykpi') }}/{{ Crypt::encrypt($value->id) }}" class="btn btn-link">ลงข้อมูล</a>
                            <?php } ?>
                                
                            </div>
                        </td>
                    </tr>

                    <?php
                        $chk_r = $value->around_id;
                    ?>     

                    @endforeach
                </tbody>
            </table>       
            </div>

            
        </form>
    </div>
</div>


@endsection
