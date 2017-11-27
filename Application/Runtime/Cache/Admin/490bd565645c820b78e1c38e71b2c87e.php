<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>报名管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">

    <link rel="stylesheet" href="Public/Admin/plugins/layui/css/layui.css" media="all"/>
    <link rel="stylesheet" href="Public/Admin/plugins/font-awesome/css/font-awesome.min.css">

</head>

<body style=" background-color: gainsboro;">
<style>
    .layui-table-view {
        margin: 10px 0 0 0;
    }
</style>
<div style="margin:0px; background-color: white; margin:0 3px;">
    <blockquote class="layui-elem-quote">
        <!--<button type="button" class="layui-btn layui-btn-small" id="getAll">-->
        <!--<i class="fa fa-plus" aria-hidden="true"></i> 添加-->
        <!--</button>-->

        <div class="demoTable">
            手机：
            <div class="layui-inline">
                <input class="layui-input" name="phone" id="demoReloadPhone" autocomplete="off">
            </div>
            姓名：
            <div class="layui-inline">
                <input class="layui-input" name="name" id="demoReloadName" autocomplete="off">
            </div>

            <button class="layui-btn" data-type="reload">搜索</button>
        </div>

    </blockquote>


    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>

</div>

<script type="text/javascript" src="Public/Admin/plugins/layui/layui.all.js"></script>
<script>
    layui.use('table', function () {
        var table = layui.table;
        //方法级渲染
        table.render({
            elem: '#LAY_table_user'
            , url: window.location.search + '&_format_=json'
            , cols: [[
                {checkbox: true, fixed: true}
                , {field: 'id', title: 'ID', width: 80, sort: true, fixed: true}
                , {field: 'name', title: '实名', width: 280}
                , {field: 'phone', title: '手机号码', width: 180}
                , {field: 'pay_money', title: '已付费用', width: 180}
                , {field: 'system_time', title: '报名时间', width: 180, sort: true}
            ]]
            , id: 'testReload'
            , page: true
            , height: 'full-78'
            , even: true
        });

        var $ = layui.$, active = {
            reload: function () {
                var demoReloadPhone = $('#demoReloadPhone');
                var demoReloadName = $('#demoReloadName');
                table.reload('testReload', {
                    where: {
                        key: {
                            phone: demoReloadPhone.val(),
                            name: demoReloadName.val()
                        }
                    }
                });
            }
        };
        $('.demoTable .layui-btn').on('click', function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</body>

</html>