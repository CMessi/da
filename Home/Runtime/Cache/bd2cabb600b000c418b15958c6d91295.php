<?php if (!defined('THINK_PATH')) exit();?>      <!DOCTYPE html>
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
          <h1 class="page-header">管理中心</h1>
        </div>
        <!-- /.col-lg-12 --> 
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-3"> <i class="fa fa-database fa-5x"></i> </div>
                <div class="col-xs-9 text-right">
                  <div class="huge"><?php echo ($fwqCount); ?>台</div>
                  <div>当前分配服务器</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="panel panel-green">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-3"> <i class="fa fa-tasks fa-5x"></i> </div>
                <div class="col-xs-9 text-right">
                  <div class="huge"><?php echo ($taskCount); ?>条</div>
                  <div>当前运行采集任务</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="panel panel-yellow">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-3"> <i class="fa fa-file-text-o fa-5x"></i> </div>
                <div class="col-xs-9 text-right">
                  <div class="huge"><?php echo ($articleCount); ?></div>
                  <div>当前数据记录</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="dataTable_wrapper">
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading"> 监测任务 </div>
              <!-- /.panel-heading -->
              <div class="panel-body">
                <div class="dataTable_wrapper">
                  <div  class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <div class="row">
                      <div class="col-sm-12">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                          <thead>
                            <tr role="row">
                              <th class="center">名称</th>
                              <th class="center">渠道</th>
                              <th class="center">采集数</th>
                              <th class="center">时段</th>
                              <th class="center">状态</th>
                              <th class="center">操作</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr class="gradeA odd" role="row">
                                <td class="center"><?php echo ($v[task_name]); ?></td>
                                <td class="center">
                                  <?php if(strlen($v['fid'])>2){?>
                                    <img src="__PUBLIC__/images/1.jpg" height="20">
                                    <img src="__PUBLIC__/images/2.jpg" height="20">
                                  <?php }else{ echo "<img src='__PUBLIC__/images/$v[fid].jpg' height='20'>"; }?>
                                </td>
                                <td class="center"><?php echo ($v["article_count"]); ?></td>
                                <td class="center">
                                  <?php echo (substr($v["start_time"],0,10)); ?>---<?php echo (substr($v["end_time"],0,10)); ?>
                                </td>
                                <td class="center">
                                  <?php if(($v["status"] == 0)): ?>等待处理
                                  <?php elseif(($v["status"] == 1)): ?>正在运行
                                  <?php elseif(($v["status"] == 2)): ?>成功
                                  <?php elseif(($v["status"] == 3)): ?>失败
                                  <?php elseif(($v["status"] == 4)): ?>失败
                                  <?php elseif(($v["status"] == 5)): ?>暂停
                                  <?php else: ?>执行超时<?php endif; ?>
                                </td>
                              <td class="center">
                              <!--如果状态为暂停    显示开始  否则显示暂停-->
                                <?php if(($v["status"] > 2)): ?><button type="button" id="start" class="btn btn-outline btn-primary btn-xs" onclick="mission_start(<?php echo ($v["id"]); ?>)">开始</button>  
                                <?php else: ?>                          
                                  <button type="button" id="stop" class="btn btn-outline btn-primary btn-xs" onclick="mission_stop(<?php echo ($v["id"]); ?>)">停止</button><?php endif; ?>
                                <a href="__APP__/Task/task_detail?id=<?php echo ($v["id"]); ?>&task_name=<?php echo ($v["task_name"]); ?>">
                                  <button type="button" class="btn btn-outline btn-primary btn-xs">详情</button>
                                </a>
                                <a href="__APP__/Analysis/mng_misson_analysis?id=<?php echo ($v["id"]); ?>&kwds=<?php echo ($v["kwds"]); ?>">
                                  <button type="button" class="btn btn-outline btn-primary btn-xs">分析</button>
                                </a>
                              </td>
                            </tr><?php endforeach; endif; ?>
                          </tbody>
                        </table>
                        <div class='showPage'><?php echo ($show); ?></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.table-responsive --> 
              </div>
              <!-- /.panel-body --> 
            </div>
            <!-- /.panel --> 
          </div>
          <!-- /.col-lg-12 --> 
        </div>
        <!-- /.container-fluid --> 
      </div>
  <!-- /#page-wrapper --> 
</div>

</body>

    <!-- jQuery -->
    <script src="__PUBLIC__/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="__PUBLIC__/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="__PUBLIC__/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="__PUBLIC__/dist/js/sb-admin-2.js"></script>

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
    </script>

<script>
//加载菜单栏
  $(function(){
    $("#addCatSubmit").click(function(){
      var search_name = $("input[name=search_name]").val();
      $.post("__URL__/ajaxAddTaskCategoryHandle",{search_name:search_name},function(data){
        if(data=='ok'){
            $(".category .alert-success").removeClass("hidden");
        }else{
            $(".category .alert-danger").removeClass("hidden");
        }
      })
    });
  })
//关闭任务
  function mission_stop(id){
    $("#stop").hide();
    $("#start").show();
    $.post("__APP__/Task/ajaxStopMission",{id:id,type:'stop'},function(data){
      location.reload();
    })
  }
//开启任务
  function mission_start(id){
    $("#stop").show();
    $("#start").hide();
    $.post("__APP__/Task/ajaxStopMission",{id:id,type:'start'},function(data){
      location.reload();
    })
  }  
</script>
</html>