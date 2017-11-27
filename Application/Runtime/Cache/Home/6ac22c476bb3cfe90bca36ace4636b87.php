<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <title><?php echo ($appName); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="Public/Home/css/weui.css">
    <link rel="stylesheet" type="text/css" href="Public/Home/css/example.css">
    <link rel="stylesheet" href="Public/Home/css/style.css">
    <script src="Public/Home/js/jquery-2.1.4.js"></script>
    <script src="Public/Home/js/adaptive.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        adaPtive(); //铺页面调用
        //页面加载时调用
        $(function() { direction(); });
        //用户变化屏幕方向时调用
        $(window).on('orientationchange', function(e) { direction(); });
        //调用adaptive
        function adaPtive(max) {
            window['adaptive'].desinWidth = 760;
            window['adaptive'].baseFont = 24;
            window['adaptive'].scaleType = 1;
            window['adaptive'].maxWidth = max;
            window['adaptive'].init();
        }
        //判断手机屏幕方向
        function direction() { if (window.orientation == 90 || window.orientation == -90) { adaPtive(320); return false; } else if (window.orientation == 0 || window.orientation == 180) { adaPtive(); return false; } }
    </script>
</head>

<body ontouchstart>
<div class="page__hd" style="padding:20px 15px;">
    <h1 class=""><?php echo ($data['title']); ?></h1>
    <p class="page__desc"><span style="margin-right:20px;"><?php echo date('Y-m-d',$data['update_time']);?></span>
        <?php echo ($settings['name']); ?></p>
</div>
<div class="page__bd">
    <article class="weui-article">
        <img src="<?php echo ($settings['logo']); ?>" style="width:100%;max-height:120px;">
    </article>
    <p style="line-height: 25.6px; text-align: center;"><span
            style="line-height: 25.6px; color: rgb(255, 0, 0);">●</span><span
            style="line-height: 25.6px;">&nbsp;●&nbsp;</span><span
            style="line-height: 25.6px; color: rgb(0, 176, 240);">●</span></p>
</div>
<div class="page__bd">
    <article class="weui-article" id="showBody">
        <?php echo htmlspecialchars_decode($data['body_html']);?>
    </article>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        showBodyIframe();
        $(window).resize(function() {
            showBodyIframe();
        });
        function showBodyIframe() {
            var showBody = $('#showBody');
            var showBodyW = showBody.width();//浏览器窗口高度
            //alert(showBodyW);
            showBody.find('iframe').width(showBodyW).height(showBodyW*0.7);
        }


    });
</script>
<script src="Public/Home/js/zepto.min.js"></script>
<script type="text/javascript" src="Public/Home/js/jweixin-1.0.0.js"></script>
<script src="Public/Home/js/weui.min.js"></script>
<script src="Public/Home/js/example.js"></script>
</body>


</body>

</html>