<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>系统设置</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="Public/Admin/plugins/layui/css/layui.css" media="all"/>
    <link rel="stylesheet" href="Public/Admin/plugins/font-awesome/css/font-awesome.min.css">
</head>

<body>
<style>
</style>
<div style="margin: 15px;">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
        <legend>系统设置</legend>
    </fieldset>

    <form class="layui-form" action="">
        <input type="hidden" name="id" value="<?php echo ($data['id']); ?>">
        <div class="layui-form-item">
            <label class="layui-form-label">系统名称：</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="name" autocomplete="off" placeholder="输入公众号名称"
                       value="<?php echo ($data['name']); ?>" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block" style="position: relative;">
                <div id="showLogoImages"
                     style="width:300px;height:135px;border: 1px dashed #e2e2e2;display: inline-block;">
                    <img src="<?php echo ($data['logo']); ?>" width="300px" height="135px"
                         style="<?php echo ($data['logo']?'display:block':'display: none'); ?>">
                    <input type="hidden" name="logo" value="<?php echo ($data['logo']); ?>">
                </div>
                <button type="button" class="layui-btn" id="uploadLogoImage"
                        style="position: absolute;left:310px;top:98px">
                    <i class="layui-icon">&#xe67c;</i>上传LOGO
                </button>

            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">介绍：</label>
            <div class="layui-input-block">
                <textarea name="content" placeholder="输入简介、地址、联系方式 ..."
                          class="layui-textarea"><?php echo ($data['content']); ?></textarea>
            </div>
        </div>
        <fieldset class="layui-elem-field layui-field-title">
            <legend>报名预付费用 （<font color="red">预付费用必填</font>）</legend>
        </fieldset>
        <div class="layui-form-item">
            <label class="layui-form-label">预付费用：</label>
            <div class="layui-input-block">
                <input type="text" name="baoming_money" lay-verify="ad_url" autocomplete="off" placeholder="多个费用之间以空格分开：100.00 300.00 3000.00"
                       value="<?php echo ($data['baoming_money']); ?>" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">报名说明：</label>
            <div class="layui-input-block">
                <input type="text" name="baoming_explain" lay-verify="ad_url" autocomplete="off" placeholder=""
                       value="<?php echo ($data['baoming_explain']); ?>" class="layui-input">
            </div>
        </div>

        <fieldset class="layui-elem-field layui-field-title">
            <legend>广告设置 （<font color="#006400">如不设置，请留空</font>）</legend>
        </fieldset>
        <div class="layui-form-item">
            <div class="layui-input-block" style="position: relative;">
                <div id="showAdImages"
                     style="width:300px;height:135px;border: 1px dashed #e2e2e2;display: inline-block;">
                    <img src="<?php echo ($data['ad_image']); ?>" width="300px" height="135px"
                         style="<?php echo ($data['ad_image']?'display:block':'display: none'); ?>">
                    <input type="hidden" name="ad_image" value="<?php echo ($data['ad_image']); ?>">
                </div>
                <button type="button" class="layui-btn" id="uploadAdImage"
                        style="position: absolute;left:310px;top:98px">
                    <i class="layui-icon">&#xe67c;</i>上传广告图片
                </button>

            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">广告地址：</label>
            <div class="layui-input-block">
                <input type="text" name="ad_url" lay-verify="ad_url" autocomplete="off" placeholder="http://"
                       value="<?php echo ($data['ad_url']); ?>" class="layui-input">
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
            },
            pass: [/(.+){6,12}$/, '密码必须6到12位'],
            content: function (value) {
                layedit.sync(editIndex);
            }
        });

        //拖拽上传
        upload.render({
            elem: '#uploadLogoImage',
            url: '<?php echo U("Upload/Index");?>',
            done: function (res) {
                console.log(res)
                if (res.code) {
                    layer.alert(res.msg);
                    return false;
                }
                $("#showLogoImages").find('input').val(res.data.src);
                $("#showLogoImages").find('img').attr('src', res.data.src).show();
                layer.msg(res.msg);
            }
        });
        upload.render({
            elem: '#uploadAdImage',
            url: '<?php echo U("Upload/Index");?>',
            done: function (res) {
                console.log(res)
                if (res.code) {
                    layer.alert(res.msg);
                    return false;
                }
                $("#showAdImages").find('input').val(res.data.src);
                $("#showAdImages").find('img').attr('src', res.data.src).show();
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