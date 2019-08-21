<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Share Free Ssr--ISong</title>
    <meta name="description" content="particles.js is a lightweight JavaScript library for creating particles.">
    <meta name="author" content="Vincent Garreau">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" media="screen" href="https://i-song.cc/statics/css/style.css">
    <link rel="stylesheet" type="text/css" href="https://i-song.cc/statics/css/reset.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>
<body>
<div id="particles-js">
    <div class="login">
        <div class="login-top">
            Share Free Ssr
        </div>
        <div class="login-center clearfix">
            <div class="login-center-img"><img src="https://i-song.cc/statics/img/password.png"></div>
            <div class="login-center-input">
                <input type="text" name="anhao" value="" id="input" placeholder="请输入密码" onfocus="this.placeholder=&#39;&#39;" onblur="this.placeholder=&#39;请输入密码&#39;">
                <div class="login-center-input-text">密码</div>
            </div>
        </div>
        <div class="login-button" >
            确定
        </div>
    </div>
    <div class="sk-rotating-plane"></div>
    <canvas class="particles-js-canvas-el" width="1920" height="969" style="width: 100%; height: 100%;"></canvas></div>
    <div class="dialog-copy" id="dialog" style="display: none">
        <img src="https://i-song.cc/statics/img/go.png" alt="" style="width: 14px;">
    </div>
<script type="text/javascript">
    function hasClass(elem, cls) {
        cls = cls || '';
        if (cls.replace(/\s/g, '').length == 0) return false; //当cls没有参数时，返回false
        return new RegExp(' ' + cls + ' ').test(' ' + elem.className + ' ');
    }

    function addClass(ele, cls) {
        if (!hasClass(ele, cls)) {
            ele.className = ele.className == '' ? cls : ele.className + ' ' + cls;
        }
    }

    function removeClass(ele, cls) {
        if (hasClass(ele, cls)) {
            var newClass = ' ' + ele.className.replace(/[\t\r\n]/g, '') + ' ';
            while (newClass.indexOf(' ' + cls + ' ') >= 0) {
                newClass = newClass.replace(' ' + cls + ' ', ' ');
            }
            ele.className = newClass.replace(/^\s+|\s+$/g, '');
        }
    }
    document.querySelector(".login-button").onclick = function(){
        addClass(document.querySelector(".login"), "active")
        setTimeout(function(){
            addClass(document.querySelector(".sk-rotating-plane"), "active")
            document.querySelector(".login").style.display = "none"
        },800)
        request();
    }
    function request() {
        console.log($("#input").val());
        $.ajax({
            type : "POST",
            url : "/api/validate",
            dataType : "json",
            data : {'anhao':$("#input").val()},
            success : function(res) {
                if (res == '1') {
                    window.location.href="/free-ssr";
                } else {
                    // alerts('看来兄弟非魔教中人！','/fanqiang');
                    alerts('看来兄弟非魔教中人！');
                }
            }
        });
    }
    function alerts (str,url) {
        let dialog = document.getElementById("dialog");
        let frame = document.createElement("span");
        let addText  = document.createTextNode(str);
        frame.appendChild(addText);
        dialog.appendChild(frame);
        dialog.style.display = 'block';
        setTimeout( function(){
            dialog.style.display = 'none';
            frame.remove();
            if (url) {
                window.location.href=url;
            }
        }, 1500 );
    }
</script>

</body></html>