<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body class="home">
    
    <div id="root" class="page-wrap ">
    
        <header class="Header">
            <nav class="Navigation">
                <div class="Navigation__top">
                    <h1 class="logo"><a href="./"><span class="l">N</span>TH-KPI</a></h1>            
                </div>
            </nav>
        </header>

        <div class="container">
                     
          <div class="login-mask">
          <div class="login-container">
                <div class="login-header">
                    <div slot="header">
                        <h3>เข้าสู่ระบบ NTH-KPI</h3>
                    </div>
                </div>
                <div class="login-body">
                    <div slot="body">

                        @if(Session::has('error'))			
                        <div class="alert alert-dismissable alert-danger">         			  
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ e(Session::get('error')) }}
                        </div>
                        @endif
                        
                        {!! Form::open( array('route' => 'login.store', 'class' => '') ) !!}
                            <div class="form-group">
                                <label for="username">ชื่อผู้ใช้งาน</label>
                                <input class="form-control" id="username" name="username" placeholder="ชื่อผู้ใช้งาน" required="" type="text">
                            </div>
                            <div class="form-group">
                                <label for="password">รหัสผ่าน</label>
                                <input class="form-control" id="password" name="password" placeholder="รหัสผ่าน" required="" type="password">
                            </div>
                            <div class="form-group">
                                <button class="Button Button--Callout btn-block">เข้าสู่ระบบ</button>
                            </div>
                        {!! Form::close() !!}<!-- form -->
                    </div>
                </div>
                <div class="login-footer">
                    <div slot="footer">
                        <footer>
                            <!--<a class="utility-muted-link utility-right" href="#">สมัครสมาชิก</a>-->
                        </footer>
                    </div>
                </div>
            </div>
            </div> 

        </div><!-- End Container -->

    </div><!-- End Root page-wrap -->

    @include('includes.footer')    
    @include('includes.script') 

</body>
</html>




