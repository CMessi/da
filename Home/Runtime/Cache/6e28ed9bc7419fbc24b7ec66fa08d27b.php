<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>大数据监测指挥中心 - 数据分析平台</title>

    <!-- Bootstrap Core CSS -->
    <link href="__PUBLIC__/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="__PUBLIC__/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="__PUBLIC__/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="__PUBLIC__/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--datetimepicker Css-->
    <!-- <link href="__PUBLIC__/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"> -->
</head>

<body>

    <div id="wrapper">

      <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
          <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<!--<title>大数据监测指挥中心 - 数据分析平台</title>-->
    <link href="__PUBLIC__/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="__PUBLIC__/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="__PUBLIC__/dist/css/sb-admin-2.css" rel="stylesheet">

    <link href="__PUBLIC__/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <link href="__PUBLIC__/dist/css/page.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div id="wrapper">

      <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--<a class="navbar-brand" href="javascript:void(0)">大数据监测指挥中心</a>-->
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
               

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="__APP__/login/loginOut"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
          <!-- /.navbar-top-links -->
          <div class="navbar-default sidebar" role="navigation" id="menu">
                             <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search text-center" style="height:50px; ">
                           尊敬的<span class="text-primary"><?php echo $_SESSION['username']?></span>，欢迎登陆
                        </li>
                        <li> <a href="__APP__/Index/user_main.html" class="active"><i class="fa fa-windows fa-fw"></i> 管理中心</a> </li>
                    <?php
 foreach($node as $k1=>$v1){ ?>                    
                        <li >
                            <a href="javascript:void(0)" class="<?php echo $v1['name']?>" onclick="al(this)" ><i class="fa fa-stack-exchange fa-fw" ></i> <?php echo $v1['title']?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse "  >
                                <?php
 foreach($v1['node'] as $v2){ ?> 
                                    <li>
                                         <a class="<?php echo $v1['name'].$v2['name']?>" href="__ROOT__/<?php echo $v1['name']?>/<?php echo $v2['name']?>.html"><?php echo $v2['title']?></a>
                                    </li>
                                <?php } ?>   
                            </ul>
                        </li>
                    <?php } ?>
                    </ul>
                </div>

<script>
function al(e){

    var cl = $(e).attr('class');

    $("#menu ul li ul  ").removeClass("in");
    
    $('#menu ul li  .'+cl+'').next().addClass("in");


}
</script>
          <!-- /.navbar-static-side -->
          </div>
      </nav>

        <!-- Page Content -->
      <div id="page-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <h1 class="page-header">添加任务 </h1>
            </div>
          </div>
        
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>任务名称(必填*)</label>
                <input class="form-control" name="task_name" placeholder="请输入一个方便识别的任务名称">
              </div>
              <div class="form-group">
                  <label>核心关键词(必填*)</label>
                  <input class="form-control" name="kwds" placeholder="请输入监测的核心关键词">
                  <p class="help-block">核心关键词为监测的主关键词</p>
              </div>
              <div class="form-group">
                <label>并列关键词</label>
                <input class="form-control" name="more_kwds" placeholder="请输入监测的并列关键词">
                <p class="help-block">并列关键词为主关键词的一个补充，在核心关键词监控完毕后，再执行的一个任务，其任务结果会并入采集任务中，相当于核心关键词的同义词，使用“空格”可分割关键词，最多只能输入3个</p>
              </div>
              <div class="form-group">
                <label>排除关键词</label>
                <input class="form-control" name="del_kwds" placeholder="请输入排除的关键词">
                <p class="help-block">在核心关键词检测时如内容有排除的关键词则不会监测，使用“空格”可分割关键词，最多只能输入3个</p>
              </div>  
              <div class="form-group">
                <label>数据来源(必填*)&nbsp;&nbsp;</label>
                <?php if(is_array($list)): foreach($list as $key=>$v): ?><label class="checkbox-inline">
                        <input name="site_id" type="checkbox" value="<?php echo ($v["id"]); ?>"><?php echo ($v["site_name"]); ?>
                    </label><?php endforeach; endif; ?>
              </div>
              <div class="form-group">
                <label>监测频率</label>
                <select name="search_type"  class="form-control" >
                  <option value="1">始终</option>
                  <option value="2">仅一次</option>
                </select>
              </div>
              <label>监测时间段(必填*)</label>
              <div class="form-group quickchangedate">
                <div class="input-group date form_date " data-date=""  data-date-format="yyyy-mm-dd" data-link-field="dtp_input1" data-link-format="yyyy-mm-dd">
                  <input class="form-control" size="16" name="start_time" type="text" value="" readonly>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                <input type="hidden" id="dtp_input1" value="" /><br/>
              </div>
              <div class="form-group quickchangedate">
                <div class="input-group date form_date " data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" name="end_time" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                <input type="hidden" id="dtp_input2" value="" /><br/>
              </div>
              <button type="submit" class="btn btn-default" onclick="getTaskInfo()">确定</button><br/><br/>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="__PUBLIC__/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="__PUBLIC__/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="__PUBLIC__/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="__PUBLIC__/dist/js/sb-admin-2.js"></script>

  <script type="text/javascript" src="__PUBLIC__/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
  <script type="text/javascript" src="__PUBLIC__/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>

</body>
<script>
      //加载菜单栏
      $(function(){
        $.post('__APP__/common/ajaxGetMenu',function(data){
          $("#menu").html(data);
          $("#menu ul li ul li a ").removeClass("active");
          var c = "<?php echo MODULE_NAME.ACTION_NAME; ?>";
          var d = "<?php echo MODULE_NAME?>";
          //$('#menu ul li .'+d+'').addClass("active");
          $('#menu ul li ul li .'+c+'').addClass("active");
          $('#menu ul li ul li .'+c+'').parent().parent().addClass("in");
          $('#menu ul li ul li .'+c+'').parent().parent().attr("aria-expanded","true");

        })
      })


        $('.form_date').datetimepicker({
          language:  'zh-CN',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          minView: 2,
          forceParse: 0
        });
</script>

<script>
  function getTaskInfo(){
    var task_name = $("input[name='task_name']").val();
    var kwds = $("input[name='kwds']").val();
    var more_kwds = $("input[name='more_kwds']").val();
    var del_kwds = $("input[name='del_kwds']").val();
    var search_type = $("select[name='search_type']").val();
    var start_time = $("input[name='start_time']").val();
    var end_time = $("input[name='end_time']").val();
    //console.info(search_type);
    var site_id=""; 
    $("input[type='checkbox']:checkbox:checked").each(function(){ site_id+=$(this).val()+","; });
    if(task_name=='' || kwds=='' || start_time=='' || end_time==''){
      alert("带*为必填字段");return false;
    }
    if(site_id==''){
      alert("数据来源不可以为空！");return false;
    }
    $.post("__URL__/ajaxAddTaskHandle",{task_name:task_name,kwds:kwds,search_type:search_type,start_time:start_time,end_time:end_time,site_id:site_id,more_kwds:more_kwds,del_kwds:del_kwds},function(data){
      if(data==='ok'){
        alert("添加成功");location.href="__URL__/mng_main_misson";
      }else{
        alert("添加失败");return false;
      }
    })
  }



</script>
</html>