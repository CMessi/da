<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>用户登录页面</title>

    <!-- Bootstrap Core CSS -->
    <link href="__PUBLIC__/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="__PUBLIC__/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="__PUBLIC__/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="__PUBLIC__/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/dist/css/login.css" rel="stylesheet" type="text/css">


</head>

<body>

    <div class="top"><i class="fa fa-cloud"></i>网络舆情大数据分析监测系统</div>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1" >
                <div class="login-panel panel panel-default">
                  <div class="panel-body">
                      <form role="form" action="__URL__/doLogin" method="post">
                            <fieldset>
                                <div class="form-group col-xs-6">
                                    <input class="form-control" placeholder="请输入账号" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group col-xs-6">
                                    <input class="form-control" placeholder="请输入密码" name="password" type="password" value="">
                                </div>
                                <div class="clearfix"></div>
                                <div class="checkbox col-xs-2">
                                    <label>
                                        <!-- <input name="remember" type="checkbox" value="记住密码">记住密码 -->
                                    </label>
                                </div>
                                <div class="col-xs-3" style=" margin-top:10px">
                               <label><!--  <a href="">忘记密码？</a> <a href="">注册用户</a> --></div></label>
                              <div class="col-md-2 col-md-offset-5">
                                    <label>
                                        <input value="登录" type="submit" name="login" class="btn btn-lg btn-success btn-block">
                                    </label>
                                </div>
                               
                        </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="__PUBLIC__/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="__PUBLIC__/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="__PUBLIC__/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="__PUBLIC__/dist/js/sb-admin-2.js"></script>

</body>

</html>