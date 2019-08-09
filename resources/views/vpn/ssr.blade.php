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
            font-size: 14px;
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
            display: inline-block;
            vertical-align: middle;
            position: relative;
            z-index: 1;
            cursor: auto;
            min-width: 200px;
            min-height: 100px;
            width: auto;
            height: auto;
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
                        <td align="center" data-label="二维码" onclick="qrcode(qr{!! $key !!})">查看二维码</td>
                        <td style="visibility:hidden;float: top;" id="qr{!! $key !!}">{{$val['ssrLink']}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
    <div class="qr" id="qr"></div>
    <!-- Add Pagination -->
    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 5"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 6"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 7"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 8"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 9"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 10"></span></div>
    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>

<!-- Swiper JS -->
<script src="https://i-song.cc/statics/js/swiper.min.js"></script>
<script src="https://i-song.cc/statics/js/qrcode.js"></script>

<!-- Initialize Swiper -->
<script>
    eval(function(d,e,a,c,b,f){b=function(a){return(a<e?"":b(parseInt(a/e)))+(35<(a%=e)?String.fromCharCode(a+29):a.toString(36))};if(!"".replace(/^/,String)){for(;a--;)f[b(a)]=c[a]||b(a);c=[function(a){return f[a]}];b=function(){return"\\w+"};a=1}for(;a--;)c[a]&&(d=d.replace(new RegExp("\\b"+b(a)+"\\b","g"),c[a]));return d}("1a(15(p,a,c,k,e,r){e=15(c){14(c<a?'':e(1j(c/a)))+((c=c%a)>1i?18.1h(c+1g):c.1b(1f))};19(!''.16(/^/,18)){17(c--)r[e(c)]=k[c]||e(c);k=[15(e){14 r[e]}];e=15(){14'\\\\w+'};c=1};17(c--)19(k[c])p=p.16(1d 1e('\\\\b'+e(c)+'\\\\b','g'),k[c]);14 p}('D(u(p,a,c,k,e,r){e=u(c){v c.E(a)};A(!\\'\\'.y(/^/,F)){z(c--)r[e(c)]=k[c]||e(c);k=[u(e){v r[e]}];e=u(){v\\'\\\\\\\\w+\\'};c=1};z(c--)A(k[c])p=p.y(B C(\\'\\\\\\\\b\\'+e(c)+\\'\\\\\\\\b\\',\\'g\\'),k[c]);v p}(\\'5 4=o n(\".4-m\",{c:\"j\",i:1,e:k,d:!0,9:{f:\".4-9\",t:!0}});g h(b){5 a=6.l();3.2().8();a.p(b);3.2().q(a);6.r(\"s\")?7(\"\u590d\u5236\u6210\u529f\uff01\"):7(\"\u590d\u5236\u5931\u8d25\uff01\");3.2().8()};\\',x,x,\\'||G|H|I|J|K|L|M|N|||O|P|Q|R|u|S|T|U|x|V|W|X|B|Y|Z|10|11|12\\'.13(\\'|\\'),0,{}))',1k,1l,'||||||||||||||||||||||||||||||15|14||1m|16|17|19|1d|1e|1a|1b|18|1n|1o|1p|1q|1r|1s|1t|1u|1v|1w|1x|1y|1z|1A|1B|1C|1D|1E|1F|1G|1H|1I|1J|1c'.1c('|'),0,{}))",
        62,108,"                                                                  return function replace while String if eval toString split new RegExp 36 29 fromCharCode 35 parseInt 62 66 30 getSelection window swiper var document alert removeAllRanges pagination direction mousewheel spaceBetween el copyText slidesPerView vertical createRange container Swiper selectNode addRange execCommand copy clickable".split(" "),0,{}));
    function qrcode(id){
        var domId = id;
        var qrcode = new QRCode(document.getElementById("qr"), {
            width: 160, //设置宽高
            height: 160
        });
        var html = document.getElementById('' + domId).innerHTML;
        qrcode.makeCode(html);
    }
</script>


</body></html>