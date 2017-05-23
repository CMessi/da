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
                        <h1 class="page-header">任务分类 <button type="button" class="btn btn-default " data-toggle="modal" data-target="#myModal">添加分类</button></h1>
                    </div>
                </div>
          			<div class="col-sm-12">
                  <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                  <thead>
                    <tr role="row">
                      <th class="center">分类名称</th>
                      <th class="center">创建时间</th>
                      <th class="center">操作</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(is_array($categorys)): foreach($categorys as $key=>$v): ?><tr class="gradeA odd" role="row">
                        <td class="center"><?php echo ($v["name"]); ?></td>
                        <td class="center"><?php echo ($v["create_time"]); ?></td>
                        <td class="center">
                          <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="showSetCategory(<?php echo ($v["id"]); ?>,'<?php echo ($v["name"]); ?>')" data-target="#myModal">修改</button> 
                          <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" onclick="delCategory(<?php echo ($v["id"]); ?>)" data-target="#myModal2">删除</button>
                        </td>
                      </tr><?php endforeach; endif; ?> 
                  </tbody>
                </table>
                <div class="showPage">
                    <?php echo ($show); ?>
                </div>
          		</div>
            </div>
          </div>
        </div>
      </div>

<!--添加/修改分类dialog-->
      <div class="row">
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">分类设置 </h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-12">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                      <thead>
                        <tr role="row">
                          <th   rowspan="1" colspan="1" style="width: 175px;" >分类名称 <input type="text" id="categoryName"></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" id="categoryId" value="">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="AddSetCaegory()">保存</button>
              </div>
            </div>
          </div>
        </div>
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
//添加/修改分类
  function AddSetCaegory(){
    var name = $("#categoryName").val();
    var id = $("#categoryId").val();
    if(name==''){
      alert("填写分类名称");return false;
    }
     $.post("__URL__/ajaxAddCategory",{name:name,type:'category',id:id},function(data){
       if(data=='ok'){
         alert("保存成功");location.reload();
       }else{
         alert("保存失败,检查名称是否重复!");return false;
       }
     })       
  }
//修改分类弹框内容
  function showSetCategory(id,name){
    $("#categoryName").val(name);
    $("#categoryId").val(id);
  }
//删除分类
  function delCategory(id){
    if(confirm("确定要删除该分类吗?")){
      $.post("__URL__/ajaxDelCategory",{id:id,type:'category'},function(data){
        if(data=='ok'){
          alert("删除成功");location.reload();
        }else{
          alert("删除失败");return false;
        }
      }) 
    }
  }
  
</script>
</html>