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
                content: attr(data-label);
                float: left;
                text-transform: uppercase;
                font-weight: bold;
            }
        }
    </style>
</head>
<body>
<!-- Swiper -->
<div class="swiper-container swiper-container-initialized swiper-container-vertical">
    <div class="swiper-wrapper"">
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
            </tr>
            </thead>
            <tbody>
            @foreach ($data as $key=>$val)
            <tr>
                <td align="center" data-label="服务IP">{{$val['service']}}</td>
                <td align="center" data-label="端口">{{$val['port']}}</td>
                <td align="center" data-label="密码">{{$val['password']}}</td>
                <td align="center" data-label="加密方式">{{$val['method']}}</td>
                <td align="center" data-label="更新时间">{{$val['check_at']}}</td>
                <td align="center" data-label="国家">{{$val['country']}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Add Pagination -->
<div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 1"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 5"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 6"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 7"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 8"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 9"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 10"></span></div>
<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>

<!-- Swiper JS -->
<script src="https://i-song.cc/statics/js/swiper.min.js"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.swiper-container', {
        direction: 'vertical',
        slidesPerView: 1,
        spaceBetween: 30,
        mousewheel: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>


</body></html>