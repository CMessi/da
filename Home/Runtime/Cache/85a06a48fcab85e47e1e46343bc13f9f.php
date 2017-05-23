<?php if (!defined('THINK_PATH')) exit();?>          <!DOCTYPE html>
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
                  <h1 class="page-header">竞品分析 - <?php echo $_GET['kwds'];?> 
                    <button type="button" class="btn btn-default " data-toggle="modal" data-target="#myModal">添加竞品词</button>
                  </h1>
                </div>
              </div>
			      <div class="row">
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">添加竞品词</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>竞品关键词</label>
                          <input class="form-control" placeholder="请输入监测的竞品关键词" id="task_name">
	                        <p class="help-block">以主关键词为相同分析条件的竞品关键词</p>
                        </div>

                        <div class="form-group">
                          <label>排除关键词</label>
                          <input class="form-control" placeholder="请输入排除的关键词" id="del_kwds">
      		                <p class="help-block">在监测时如内容有排除的关键词则不会监测，使用“空格”可分割关键词</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addCompetingproduct()">提交</button>
                  </div>
                </div>
              </div>
            </div>
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
                                <th class="center">任务名称</th>
                                <th class="center">已采集记录</th>
                                <th class="center">监测时段</th>
                                <th class="center">任务状态</th>
                                <th class="center">操作</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr class="gradeA odd" role="row">
                                  <td class="center"><?php echo ($v["task_name"]); ?></td>
                                  <td class="center"><?php echo ($v["article_count"]); ?></td>
                                  <td class="center"><?php echo (substr($v["start_time"],0,10)); ?>--<?php echo (substr($v["end_time"],0,10)); ?></td>
                                  <td class="center">
                                    <?php if(($v["status"] == 0)): ?>等待处理
                                    <?php elseif(($v["status"] == 1)): ?>正在运行
                                    <?php elseif(($v["status"] == 2)): ?>成功
                                    <?php elseif(($v["status"] == 3)): ?>失败
                                    <?php elseif(($v["status"] == 4)): ?>暂停
                                    <?php else: ?>执行超时<?php endif; ?>
                                  </td>
                                  <td class="center">
                                  <?php if(($v["status"] > 2)): ?><button type="button" id="start" class="btn btn-outline btn-primary btn-xs" onclick="mission_start(<?php echo ($v["id"]); ?>)">开始</button>  
                                  <?php else: ?>                          
                                    <button type="button" id="stop" class="btn btn-outline btn-primary btn-xs" onclick="mission_stop(<?php echo ($v["id"]); ?>)">停止</button><?php endif; ?>
                                    <a href="__APP__/Task/task_detail?id=<?php echo ($v["id"]); ?>&task_name=<?php echo ($v["task_name"]); ?>">
                                      <button type="button" class="btn btn-outline btn-primary btn-xs">明细</button>
                                    </a>
                                    <a href="__APP__/Analysis/mng_misson_analysis?id=<?php echo ($v["id"]); ?>&task_name=<?php echo ($v["task_name"]); ?>">
                                    <button type="button" class="btn btn-outline btn-primary btn-xs">筛查</button>
                                    </a>
                                    <!-- <button type="button" class="btn btn-outline btn-primary btn-xs">删除</button> -->
                                    <!-- <a href="mng-mission-Competingproducts-except.html">
                                        <button type="button" class="btn btn-outline btn-primary btn-xs">排除</button>
                                      </a> -->  
                                    <a href="__APP__/Segmentation/mng_main_misson_segmentation?id=<?php echo ($v["id"]); ?>&task_name=<?php echo ($v["task_name"]); ?>">
                                      <button type="button" class="btn btn-outline btn-primary btn-xs">分词</button>
                                    </a>
                                  </td>
                                </tr><?php endforeach; endif; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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

      function addCompetingproduct(){
        var task_name = $("#task_name").val();
        var del_kwds  = $("#del_kwds").val();
        var id        = "<?php echo $_GET[id]?>";
        $.post("__URL__/ajaxAddCompetingproduct",{kwds:task_name,del_kwds:del_kwds,id:id},function(data){
          if(data=='del_kwds'){
            alert("排除的关键词过多！");return false;
          }else if(data=='success'){
            alert("添加成功");
            location.reload();
          }else{
            alert("添加失败");return false;
          }
        })
      }


      function mission_stop(id){
        $("#stop").hide();
        $("#start").show();
        $.post("__APP__/Task/ajaxStopMission",{id:id,type:'stop'},function(data){
          location.reload();
        })
      }
      function mission_start(id){
        $("#stop").show();
        $("#start").hide();
        $.post("__APP__/Task/ajaxStopMission",{id:id,type:'start'},function(data){
          location.reload();
        })
      }    
</script>
</html>