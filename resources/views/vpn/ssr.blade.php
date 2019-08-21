<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Share Free Ssr--ISong</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://i-song.cc/statics/css/swiper.min.css">

    <!-- Demo styles -->
    <style>
        html, body {
            position: relative;
            height: 100%;
        }
        body {
            background: #eee;
            color:#000;
            margin: 0;
            padding: 0;
        }
        .swiper-container {
            width: 100%;
            height: 100%;
            margin-left: auto;
            margin-right: auto;
        }
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }
        table tr {
            padding: 5px;
        }

        table th, table td {
            padding: 0 20px;
        }

        table th {
            padding: 20px;
        }

        @media screen and (max-width: 600px) {
            table {
                width: 90%;
                margin:0;
                padding:0;
                border-collapse: collapse;
                border-spacing: 0;
                margin: 0 auto;
            }

            table {
                border: 0;
            }

            table thead {
                display: none;
            }

            table tr {
                margin-bottom: 10px;
                display: block;
            }

            table td {
                display: block;
                text-align: right;
            }

            table td:last-child {
                border-bottom: 0;
            }

            table td:before {
                display: block;
                content: attr(data-label);
                float: left!important;
                text-transform: uppercase;
                font-weight: bold;
            }
            table td:after{
                display: block;
                content: '';
                clear: both;
            }
        }
        .qr {
            position: absolute;
            top: 60%;
        }
        .dialog-copy {
            position: fixed;
            left: 50%;
            top: 20%;
            transform: translate(-50%,-50%);
            padding: 20px;
            background: #fff;
            box-shadow: 3px 3px 5px 0 rgba(0,0,0,.2);
            z-index: 999
        }
    </style>
</head>
<body>
<!-- Swiper -->
<div class="swiper-container swiper-container-initialized swiper-container-vertical">
    <div class="swiper-wrapper">
        @foreach ($data as $key=>$val)
            <div class="swiper-slide" style="height: 812px; margin-bottom: 30px;">
                <table>
                    <thead>
                    <tr>
                        <th align="center">服务IP</th>
                        <th align="center">端口</th>
                        <th align="center">密码</th>
                        <th align="center">加密方式</th>
                        <th align="center">更新时间</th>
                        <th align="center">国家</th>
                        <th align="center">二维码</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="center" data-label="服务IP" onclick="copyText(content{!! $key !!}{!! $key+1 !!});" title="点击复制" id="content{{ $key }}{{$key+1}}">{{$val['service']}}</td>
                        <td align="center" data-label="端口" onclick="copyText(content{!! $key !!}{!! $key+2 !!});" title="点击复制" id="content{{ $key }}{{$key+2}}">{{$val['port']}}</td>
                        <td align="center" data-label="密码" onclick="copyText(content{!! $key !!}{!! $key+3 !!});" title="点击复制" id="content{{ $key }}{{$key+3}}">{{$val['password']}}</td>
                        <td align="center" data-label="加密方式" onclick="copyText(content{!! $key !!}{!! $key+4 !!});" title="点击复制" id="content{{ $key }}{{$key+4}}">{{$val['method']}}</td>
                        <td align="center" data-label="更新时间">{{$val['check_at']}}</td>
                        <td align="center" data-label="国家">{{$val['country']}}</td>
                        <td align="center" data-label="二维码" onclick="qrcode('{{$val['ssLink']}}','qr{{$key}}','{{$val['ssrLink']}}')">点击查看</td>
                    </tr>
                    </tbody>
                </table>
                <div class="qr" id="qr{{$key}}"></div>
            </div>
        @endforeach
    </div>

    <!-- Add Pagination -->
    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 5"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 6"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 7"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 8"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 9"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 10"></span></div>
    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>

    {{--Dialog--}}
    <div class="dialog-copy" id="dialog" style="display: none">
        <img src="//img.alicdn.com/tfs/TB10YifXKT2gK0jSZFvXXXnFXXa-32-32.png" alt="" style="width: 14px;">
        <span>复制成功</span>
    </div>

<!-- Swiper JS -->
<script src="https://i-song.cc/statics/js/swiper.min.js"></script>
<script src="https://i-song.cc/statics/js/qrcode.js"></script>

<!-- Initialize Swiper -->
<script>
    eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('m G=H I(\'\\v\\g\\w\\9\\f\\0\\h\\x\\8\\4\\2\\3\\5\\9\\2\\0\\h\',{J:\'\\n\\0\\h\\3\\9\\8\\5\\6\',K:1,L:M,N:y,O:{P:\'\\v\\g\\w\\9\\f\\0\\h\\x\\f\\5\\i\\9\\2\\5\\3\\9\\4\\2\',Q:y,},});r R(a){m b=a;m c=j["\\7\\4\\8\\l\\e\\0\\2\\3"][\'\\8\\h\\0\\5\\3\\0\\o\\5\\2\\i\\0\']();j[\'\\i\\0\\3\\s\\0\\6\\0\\8\\3\\9\\4\\2\']()[\'\\h\\0\\e\\4\\n\\0\\z\\6\\6\\o\\5\\2\\i\\0\\g\']();c[\'\\g\\0\\6\\0\\8\\3\\A\\4\\7\\0\'](b);j[\'\\i\\0\\3\\s\\0\\6\\0\\8\\3\\9\\4\\2\']()[\'\\5\\7\\7\\o\\5\\2\\i\\0\'](c);m d=j["\\7\\4\\8\\l\\e\\0\\2\\3"][\'\\0\\B\\0\\8\\t\\4\\e\\e\\5\\2\\7\'](\'\\8\\4\\f\\k\');S(d){C(\'\\T\\U\\V\\W\')}j[\'\\i\\0\\3\\s\\0\\6\\0\\8\\3\\9\\4\\2\']()[\'\\h\\0\\e\\4\\n\\0\\z\\6\\6\\o\\5\\2\\i\\0\\g\']()}r C(a){u p=j["\\7\\4\\8\\l\\e\\0\\2\\3"][\'\\i\\0\\3\\D\\6\\0\\e\\0\\2\\3\\X\\k\\Y\\7\']("\\7\\9\\5\\6\\4\\i");u q=j["\\7\\4\\8\\l\\e\\0\\2\\3"][\'\\8\\h\\0\\5\\3\\0\\D\\6\\0\\e\\0\\2\\3\']("\\g\\f\\5\\2");u E=j["\\7\\4\\8\\l\\e\\0\\2\\3"][\'\\8\\h\\0\\5\\3\\0\\Z\\0\\B\\3\\A\\4\\7\\0\'](a);q[\'\\5\\f\\f\\0\\2\\7\\t\\F\\9\\6\\7\'](E);p[\'\\5\\f\\f\\0\\2\\7\\t\\F\\9\\6\\7\'](q);p[\'\\g\\3\\k\\6\\0\'][\'\\7\\9\\g\\f\\6\\5\\k\']=\'\\10\\6\\4\\8\\11\';12(r(){p[\'\\g\\3\\k\\6\\0\'][\'\\7\\9\\g\\f\\6\\5\\k\']=\'\\2\\4\\2\\0\';q[\'\\h\\0\\e\\4\\n\\0\']()},13)}',62,66,'x65||x6e|x74|x6f|x61|x6c|x64|x63|x69|||||x6d|x70|x73|x72|x67|window|x79|x75|var|x76|x52|dialog|frame|function|x53|x43|let|x2e|x77|x2d|true|x41|x4e|x78|alerts|x45|addText|x68|G1|new|Swiper|direction|slidesPerView|spaceBetween|30|mousewheel|pagination|el|clickable|copyText|if|u590d|u5236|u6210|u529f|x42|x49|x54|x62|x6b|setTimeout|600'.split('|'),0,{}));
    eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('l m(b,7,c){d["\\3\\5\\6\\8\\4\\0\\1\\2"][\'\\n\\0\\2\\e\\9\\0\\4\\0\\1\\2\\o\\p\\q\\3\'](7)[\'\\a\\1\\1\\0\\f\\r\\s\\t\\u\']=\'\';g h=v w(7,{x:i,y:i});g j=d["\\3\\5\\6\\8\\4\\0\\1\\2"][\'\\3\\5\\6\\8\\4\\0\\1\\2\\e\\9\\0\\4\\0\\1\\2\'][\'\\6\\9\\a\\0\\1\\2\\z\\a\\3\\2\\k\'];A(j<=B){C[\'\\k\\f\\0\\D\']=c}E{h[\'\\4\\F\\G\\0\\H\\5\\3\\0\'](b)}}',44,44,'x65|x6e|x74|x64|x6d|x6f|x63|vaAiXPFCS2|x75|x6c|x69|C1|KMw3|window|x45|x72|var|WZKQ4|160|RK5|x68|function|qrcode|x67|x42|x79|x49|x48|x54|x4d|x4c|new|QRCode|width|height|x57|if|600|location|x66|else|x61|x6b|x43'.split('|'),0,{}));
</script>
</body></html>