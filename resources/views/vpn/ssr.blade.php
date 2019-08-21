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
    </div>

<!-- Swiper JS -->
<script src="https://i-song.cc/statics/js/swiper.min.js"></script>
<script src="https://i-song.cc/statics/js/qrcode.js"></script>

<!-- Initialize Swiper -->
<script>
    eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('3 4=o p(\'.4-q\',{r:\'s\',t:1,u:v,w:e,f:{x:\'.4-f\',y:e,},});5 z(a){3 b=a;3 c=0.A();6.7().g();c.B(b);6.7().C(c);3 d=0.D(\'E\');F(d){h(\'复制成功！\')}6.7().g()}5 h(a){0.i(\'2\').G.H(j);8 2=0.i("2");8 9=0.I("j");8 k=0.J(a);9.l(k);2.l(9);2.m.n=\'K\';L(5(){2.m.n=\'M\'},N)}',50,50,'document||dialog|var|swiper|function|window|getSelection|let|frame|||||true|pagination|removeAllRanges|alerts|getElementById|span|addText|appendChild|style|display|new|Swiper|container|direction|vertical|slidesPerView|spaceBetween|30|mousewheel|el|clickable|copyText|createRange|selectNode|addRange|execCommand|copy|if|parentNode|removeChild|createElement|createTextNode|block|setTimeout|none|1500'.split('|'),0,{}));
    eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('l m(b,7,c){d["\\3\\5\\6\\8\\4\\0\\1\\2"][\'\\n\\0\\2\\e\\9\\0\\4\\0\\1\\2\\o\\p\\q\\3\'](7)[\'\\a\\1\\1\\0\\f\\r\\s\\t\\u\']=\'\';g h=v w(7,{x:i,y:i});g j=d["\\3\\5\\6\\8\\4\\0\\1\\2"][\'\\3\\5\\6\\8\\4\\0\\1\\2\\e\\9\\0\\4\\0\\1\\2\'][\'\\6\\9\\a\\0\\1\\2\\z\\a\\3\\2\\k\'];A(j<=B){C[\'\\k\\f\\0\\D\']=c}E{h[\'\\4\\F\\G\\0\\H\\5\\3\\0\'](b)}}',44,44,'x65|x6e|x74|x64|x6d|x6f|x63|vaAiXPFCS2|x75|x6c|x69|C1|KMw3|window|x45|x72|var|WZKQ4|160|RK5|x68|function|qrcode|x67|x42|x79|x49|x48|x54|x4d|x4c|new|QRCode|width|height|x57|if|600|location|x66|else|x61|x6b|x43'.split('|'),0,{}));
</script>
</body></html>