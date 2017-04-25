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
    <title>Document</title>
    <link rel="stylesheet" href="{{URL::asset('weChatNews/css/dropload.css')}}">
    <link rel="stylesheet" href="{{URL::asset('weChatNews/css/index.css')}}">
    {{--<link rel="stylesheet" href="css/index.css">--}}
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div class="swiper">
                <div class="banner">
                </div>
            </div>
            <div class="indicator">
            </div>
        </div>
        <div class="content">
            <nav class="tab">
                <div class="active" id="studyMaterial">学习资料</div>
                <div id="notice">通知公告</div>
                <div id="news">基层动态</div>
            </nav>
            <div class="study area"></div>
            <div class="notice area"></div>
            <div class="news area"></div>
        </div>
    </div>
<script src="{{URL::asset('weChatNews/js/support.js')}}"></script>
<script src="{{URL::asset('weChatNews/js/jquery.min.js')}}"></script>
<script src="{{URL::asset('weChatNews/js/swiper.js')}}"></script>
<script src="{{URL::asset('weChatNews/dist/dropload.js')}}"></script>
<script src="{{URL::asset('weChatNews/js/notice.js')}}"></script>

{{--<script src="./js/support.js"></script>--}}
{{--<script src="./js/jquery.min.js"></script>--}}
{{--<script src="./js/swiper.js"></script>--}}
{{--<script src="./dist/dropload.js"></script>--}}
{{--<script src="./js/notice.js"></script>--}}
<!-- <script src="./js/weixin.js"></script>
<script>
        var title = '一大波学霸来袭，全新图书馆查询上线。';
        var desc = '期末复习缺资料吗？快来全新图书馆查询系统看看吧。';
        var link = "{$ticket.url}";
        var imgUrl = "http://hongyan.cqupt.edu.cn/MagicLoop/Addons/Book/View/default/Public/images/share.jpg";

        wx.config({
            debug: false,
            appId: "{$appid}",
            timestamp: "{$ticket.time}",
            nonceStr: "{$ticket.nonceStr}",
            signature: "{$ticket.signature}",
            jsApiList: [
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'hideAllNonBaseMenuItem'
            ]
        });
        wx.ready(function () {
            wx.onMenuShareTimeline({
                title: title, // 分享标题
                link: link,
                imgUrl: imgUrl,
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareAppMessage({
                title: title, // 分享标题
                desc: desc, // 分享描述
                link: link,
                imgUrl: imgUrl, // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareQQ({
                title: title, // 分享标题
                desc: desc, // 分享描述
                link: link,
                imgUrl: imgUrl, // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
        });
</script> -->
</body>
</html>