<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <script src="{{URL::asset('weChatNews/js/flexible.js')}}"></script>
    {{--<script src="js/flexible.js"></script>--}}
    <title>重邮“一学一做”微网站</title>
    <link rel="stylesheet" href="{{URL::asset('weChatNews/css/dropload.css')}}">
    <link rel="stylesheet" href="{{URL::asset('weChatNews/css/index.css')}}">
    {{--<link rel="stylesheet" href="css/index.css">--}}
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div class="swiper">
                <div class="banner">
                    <img src="{{URL::asset('weChatNews/imgs/study.jpg')}}" alt="" class="banner-img">
                </div>
            </div>
            <div class="indicator">
            </div>
        </div>
        <div class="content">
            <nav class="tab">
                <div class="active" id="studyMaterial">学习资料</div>
                <div id="news">基层动态</div>
                <div id="online">线上互动</div>
            </nav>
            <div class="study area"></div>
            <div class="news area"></div>
            <div class="online area"></div>
        </div>
    </div>
<script src="{{URL::asset('weChatNews/js/support.js')}}"></script>
<script src="{{URL::asset('weChatNews/js/jquery.min.js')}}"></script>
{{--<script src="{{URL::asset('weChatNews/js/swiper.js')}}"></script>--}}
<script src="{{URL::asset('weChatNews/dist/dropload.js')}}"></script>
<script src="{{URL::asset('weChatNews/js/notice.js')}}"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="http://hongyan.cqupt.edu.cn/wx-api/share.js"></script>

    {{--<!-- <script src="./js/weixin.js"></script>--}}
    <script>
            var title = '重邮“一学一做”微网站';
            var desc = '重邮共青团“学总书记讲话 做合格共青团员”微网站上线啦！';
            var link = "http://hongyan.cqupt.edu.cn/cqupt-wechatNews/public/index.php";
            var imgUrl = "{{URL::asset('weChatNews/imgs/leagueBadge.png')}}";

            WXSHARE.config({debug: true});
            WXSHARE.ready(function() {
                var option = {
                    title: title, // 分享标题
                    desc: desc, // 分享描述
                    link: link,
                    imgUrl: imgUrl, // 分享图标
                    type: '', // 分享类型,music、video或link，不填默认为link
                    success: function () {
                        // 用户确认分享后执行的回调函数
                         console.log('分享成功');
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                         console.log('取消分享');
                    }
                };
                 wx.onMenuShareTimeline(option);
                 wx.onMenuShareAppMessage(option);
                 wx.onMenuShareQQ(option);
                 wx.onMenuShareWeibo(option);
                 wx.onMenuShareQZone(option);

            });
    </script>
</body>
</html>