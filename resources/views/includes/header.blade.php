<?php
  $urlcheck =  explode("/", Request::path());
  //$activeurl = $urlcheck[0].'/'.$urlcheck[1];
  $activeurl = Request::path();

  if( count($urlcheck) == 1 ){
      $activeurl = Request::path();
  }
  if( count($urlcheck) > 1 ){
      $activeurl = $urlcheck[0];
  }
?>

<header class="Header">
    <nav class="Navigation">
        <div class="Navigation__top">
            <h1 class="logo">
                @if(Session::get('level') == 1)
                    <a href="{{ url('admin') }}"><span class="l">N</span>TH-KPI</a>
                @else
                    <a href="{{ url('emp') }}"><span class="l">N</span>TH-KPI</a>
                @endif
            </h1>    
            <nav class="nav-collapse">
                <ul>
                    @if(Session::get('level') == 1)
                        <li class="{{ (($activeurl == 'admin') ? 'active' : '') }} {{ (($activeurl == 'viewkpidep') ? 'active' : '') }} "><a href="{{ url('admin') }}"><i class="fa fa-home fa-sm" aria-hidden="true"></i> หน้าหลัก</a></li>
                        <li class="{{ (($activeurl == 'report') ? 'active' : '') }}"><a href="{{ url('report') }}"><i class="fa fa-bar-chart fa-sm" aria-hidden="true"></i> รายงาน</a></li>
                        <li class="{{ (($activeurl == 'depkpi') ? 'active' : '') }}"><a href="{{ url('depkpi') }}"><i class="fa fa-object-group fa-sm" aria-hidden="true"></i> จัดสรร KPI</a></li>
                        <li class="{{ (($activeurl == 'kpi') ? 'active' : '') }}"><a href="{{ url('kpi') }}"><i class="fa fa-book fa-sm" aria-hidden="true"></i> KPI</a></li>
                        <li class="{{ (($activeurl == 'kpigroup') ? 'active' : '') }}"><a href="{{ url('kpigroup') }}"><i class="fa fa-book fa-sm" aria-hidden="true"></i> KPI Group</a></li>
                        <li class="{{ (($activeurl == 'diseasegroup') ? 'active' : '') }}"><a href="{{ url('diseasegroup') }}"><i class="fa fa-book fa-sm" aria-hidden="true"></i> กลุ่มโรค</a></li>
                        <li class="{{ (($activeurl == 'user') ? 'active' : '') }}"><a href="{{ url('user') }}"><i class="fa fa-users fa-sm" aria-hidden="true"></i> ผู้ใช้งาน</a></li>
                        <li class="{{ (($activeurl == 'department') ? 'active' : '') }}"><a href="{{ url('department') }}"><i class="fa fa-building fa-sm" aria-hidden="true"></i> แผนก</a></li>
                        <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out fa-sm" aria-hidden="true"></i> ออก</a></li>                       
                    @else
                       <li class="{{ (($activeurl == 'emp') ? 'active' : '') }} {{ (($activeurl == 'keykpi') ? 'active' : '') }}"><a href="{{ url('emp') }}"><i class="fa fa-home fa-sm" aria-hidden="true"></i> หน้าหลัก</a></li>
                       <!--<li><a href="#"><i class="fa fa-book fa-sm" aria-hidden="true"></i> ประวัติการบันทึก KPI</a></li>-->
                       <li class="{{ (($activeurl == 'profile') ? 'active' : '') }} {{ (($activeurl == 'profileEdit') ? 'active' : '') }}"><a href="{{ url('profile') }}/{{ Crypt::encrypt(Session::get('user_id')) }}"><i class="fa fa-user fa-sm" aria-hidden="true"></i> ข้อมูลส่วนตัว</a></li>
                       <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out fa-sm" aria-hidden="true"></i> ออก</a></li> 
                    @endif                
                </ul>
            </nav>        
        </div>      
    </nav>
</header>