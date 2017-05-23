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

      <!-- DataTables CSS -->
      <link href="__PUBLIC__/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

      <!-- DataTables Responsive CSS -->
      <link href="__PUBLIC__/bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

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
        <h1 class="page-header">任务管理 - <?php echo $_GET['task_name']?> - 授权<button type="button" class="btn btn-default " data-toggle="modal" data-target="#myModal" onclick="getUserGroup()">添加授权用户</button></h1>
      </div>
      <!-- /.col-lg-12 --> 
    </div>
    <div class="row">
  	  <div class="row">
        <div class="col-sm-12">
          <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
            <thead>
              <tr role="row">
                <th class="center">ID</th>
                <th class="center">授权用户</th>
                <th class="center">授权时间</th>
                <th class="center">操作</th>
              </tr>
            </thead>
            <tbody>
            <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr class="gradeA odd" role="row" id="list_<?php echo ($v["id"]); ?>">
                <td class="center"><?php echo ($v["id"]); ?></td>
                <td class="center"><?php echo ($v["username"]); ?></td>
                <td class="center"><?php echo ($v["create_time"]); ?></td>
                <td class="center">
                  <button type="button" class="btn btn-outline btn-primary btn-xs" onclick="delAuthUser(<?php echo ($v["id"]); ?>)">取消授权</button>
                </td>
              </tr><?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!--授权用户弹框-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">添加授权用户</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>授权用户</label>
                  <div id="user_group">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addAuthUser()">提交</button>
          </div>
      </div>
      <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
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

//弹框是获取用户组
function getUserGroup(){
  var id = "<?php echo $_GET[id]?>";
  $.post("__URL__/ajaxGetUserGroup",{id:id},function(data){
    $("#user_group").html(data);
  },'html')
}



//添加授权用户
      function addAuthUser(){
        var id= "<?php echo $_GET['id']?>";
        var chk_value =[]; 
        $('input[name="username"]:checked').each(function(){ 
          chk_value.push($(this).val()); 
        }); 
        if(chk_value.length==0){
          alert('你还没有选择授权用户！');
          return false;
        }
        $.post("__URL__/ajaxAddAuthUser",{id:id,usernames:chk_value},function(data){
          var str = data.substr(0, 2)
          if(str=='ok'){
            alert("添加成功");
            location.reload();
          }else{
            alert("添加失败");
          }
        })
      }
//删除授权用户
      function delAuthUser(id){
        $.post("__URL__/ajaxDelAuthUser",{id:id},function(data){
          if(data=='ok'){
            alert("删除成功");
            $("#list_"+id).hide();
          }else{
            alert("删除失败");
          }
        })
        //$("#list_"+id).hide();
      }

</script>


</html>