<footer class="site-footer">
<div class="Footer-Secondary">
    <div class="container">
        <div class="utility-left">
            <p class="copyright"> © Themesanasang 2017. All rights reserved. </p>
            @if(Session::get('fullname') != '')
                <div class="hosting">   
                    ยินดีตอนรับผู้ใช้งานคุณ
                <a href="#">{{ Session::get('fullname') }}</a>
                    </div>
            @endif
        </div>
    </div>
</div>
</footer>