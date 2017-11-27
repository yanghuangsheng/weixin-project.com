<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>缴费管理</title>
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
            搜索ID：
            <div class="layui-inline">
                <input class="layui-input" name="id" id="demoReload" autocomplete="off">
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
                , {field: 'order_number', title: '订单号', width: 280}
                , {field: 'cont_money', title: '实付金额', width: 180}
                , {field: 'user_id', title: '会员ID', width: 90}
                , {field: 'name', title: '实名', width: 150}
                , {field: 'system_time', title: '下单时间', width: 180, sort: true}
            ]]
            , id: 'testReload'
            , page: true
            , height: 'full-78'
            , even: true
        });

        var $ = layui.$, active = {
            reload: function () {
                var demoReload = $('#demoReload');

                table.reload('testReload', {
                    where: {
                        key: {
                            id: demoReload.val()
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