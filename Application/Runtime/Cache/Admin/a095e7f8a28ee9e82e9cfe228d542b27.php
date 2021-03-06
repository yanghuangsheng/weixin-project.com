<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>编辑【<?php echo ($data['title']); ?>】</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="Public/Admin/plugins/layui/css/layui.css" media="all"/>
    <link rel="stylesheet" href="Public/Admin/plugins/font-awesome/css/font-awesome.min.css">
    <script type="text/javascript" charset="utf-8" src="Public/Admin/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="Public/Admin/ueditor/ueditor.all.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="Public/Admin/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>

<body>
<div style="margin: 15px;">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>编辑 【<?php echo ($data['title']); ?>】</legend>
    </fieldset>

    <form class="layui-form" action="">
        <input type="hidden" name="id" value="<?php echo ($data['id']); ?>">
        <div class="layui-form-item">
            <label class="layui-form-label">标题：</label>
            <div class="layui-input-block">
                <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入标题"
                       value="<?php echo ($data['title']); ?>" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block" style="position: relative;">
                <div class="layui-upload-drag" id="uploadImage">
                    <i class="layui-icon">&#xe67c;</i>
                    <p>点击上传，或将文件拖拽到此处</p>
                </div>
                <div id="showImages"
                     style="width:300px;height:135px;border: 1px dashed #e2e2e2;display: inline-block;position: absolute;left:285px;">
                    <img src="<?php echo ($data['show_img']); ?>" width="300px" height="135px"
                         style="<?php echo ($data['show_img']?'display:block':'display: none'); ?>">
                    <input type="hidden" name="show_img" value="<?php echo ($data['show_img']); ?>">
                </div>


            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <script id="editor" type="text/plain" style="width:1024px;height:500px;"><?php echo htmlspecialchars_decode($data['body_html']);?></script>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

</div>
<script type="text/javascript" src="Public/Admin/plugins/layui/layui.all.js"></script>
<script type="text/javascript">


    //实例化编辑器
    var ue = UE.getEditor('editor');
    layui.use(['form', 'layedit', 'laydate', 'upload'], function () {
        var $ = layui.jquery,
            form = layui.form,
            layer = layui.layer,
            layedit = layui.layedit,
            laydate = layui.laydate,
            upload = layui.upload;

        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor');
        //自定义验证规则
        form.verify({
            title: function (value) {
                if (value.length < 5) {
                    return '标题至少得5个字符啊';
                }
            }
        });

        //拖拽上传
        upload.render({
            elem: '#uploadImage',
            url: '<?php echo U("Upload/Index");?>',
            done: function (res) {
                console.log(res)
                if (res.code) {
                    layer.alert(res.msg);
                    return false;
                }
                $("#showImages").find('input').val(res.data.src);
                $("#showImages").find('img').attr('src', res.data.src).show();
                layer.msg(res.msg);
            }
        });

        //监听提交
        form.on('submit(demo1)', function (data) {
            console.log(data);
            $.post(window.location.search, data.field, function (res) {
                //console.log(res);
                if (res.code) {
                    layer.alert(res.msg);
                    return false;
                }
                layer.msg(res.msg);

            }, 'json');
//            layer.alert(JSON.stringify(data.field), {
//                title: '最终的提交信息'
//            })
            return false;
        });
    });
</script>
</body>

</html>