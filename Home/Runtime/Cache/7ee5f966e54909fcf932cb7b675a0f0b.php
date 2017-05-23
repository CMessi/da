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
                <h1 class="page-header">
                竞品任务分析 
                  <button type="button" class="btn btn-default " data-toggle="modal" data-target="#myModal">添加竞品分析任务</button>
                </h1>
              </div>
            </div>

			      <div class="row">
              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">添加竞品分析任务</h4>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-sm-12">               
                          <div class="form-group">
                            <label>词条筛选</label>
                            <select class="form-control" id="zhu_renwu" onchange="changeCompeting(this)">
                              <?php if(is_array($zhu_list)): foreach($zhu_list as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>">
                                <?php echo ($v["task_name"]); ?>
                                </option><?php endforeach; endif; ?>
                            </select>
                          </div> 
                          <div class="form-group">
                            <label>竞品词条筛选</label>
                            <div id="competing">
                              <?php if(is_array($fu_list)): foreach($fu_list as $key=>$v): ?><input type="checkbox" value='<?php echo ($v["id"]); ?>' field="<?php echo ($v["kwds"]); ?>" name="competing"><?php echo ($v["kwds"]); endforeach; endif; ?>
                            </div>
                          </div>
                          <div class="form-group" id="datafrom">
                            <label>数据来源</label>
                            <?php if($fid == 2): ?><label class="checkbox-inline">
                                <input type="checkbox" value='2' name='data'>微信
                              </label>
                            <?php elseif($fid == 1): ?>
                              <label class="checkbox-inline">
                                <input type="checkbox" value='1' name='data'>微博
                              </label>
                            <?php else: ?>
                              <label class="checkbox-inline">
                                <input type="checkbox" value='1' name='data'>微博
                              </label>
                              <label class="checkbox-inline">
                                <input type="checkbox" value='2' name='data'>微信
                              </label><?php endif; ?>
                          </div>
                          <div class="form-group">
                            <label>展示图形类型</label>
                            <label class="radio-inline">
                              <input name="pic" id="pic1" value="线形图表" checked="checked" type="radio">线形图表
                            </label>
                          </div>
                          <div class="form-group">
                            <label>时间范围</label>
                            <label class="radio-inline">
                              <input name="date" id="date1" value="date1" checked="checked" type="radio">最近30天
                            </label>
                            <label class="radio-inline">
                              <input name="date" id="date2" value="date2" type="radio">最近60天
                            </label>
                            <label class="radio-inline">
                              <input name="date" id="date3" value="date3" type="radio">最近90天
                            </label>
                            <label class="radio-inline">
                              <input name="date" id="date4" value="date4" type="radio">最近1年
                            </label>
                            <label class="radio-inline">
                              <input name="date" id="optionsRadiosInline5" value="date5" type="radio">指定日期
                            </label>
                          </div>
                          <div class="input-group date form_date col-md-5 datetimepicker pull-right" data-date="" data-date-format="yyyy-mm-dd"  data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                            <input type="hidden" id="dtp_input2" value="" />
                        		<input id="from_date" class="form-control" size="16" type="text" value="" readonly>
                            <span class="input-group-addon">
                              <span class="glyphicon glyphicon-remove"></span>
                            </span>
                        		<span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                          </div>
                          <div class="input-group date form_date col-md-7 datetimepicker" data-date="" data-date-format="yyyy-mm-dd"  data-link-field="dtp_input1" data-link-format="yyyy-mm-dd">
                      			<input type="hidden" id="dtp_input1" value="" />
                            <input id="end_date" class="form-control" size="16" type="text" value="" readonly>
                            <span class="input-group-addon">
                              <span class="glyphicon glyphicon-remove"></span>
                            </span>
                      			<span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                      			<label class="col-sm-1 control-label">至</label>
                          </div>
                          <div class="form-group">
                            <label>情感筛选</label>
                            <label class="radio-inline">
                              <input name="ganqing" id="ganqing1" value="正面" checked="checked" type="radio">正面
                            </label>
                            <label class="radio-inline">
                              <input name="ganqing" id="ganqing2" value="负面" type="radio">负面
                            </label>
                            <label class="radio-inline">
                              <input name="ganqing" id="ganqing3" value="全部" type="radio">全部
                            </label> 
                          </div>
			                  </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addCompeting()">提交</button>
                    </div>
                  </div>
                </div>
              </div>
      

	            <div class="row">
                <div class="col-sm-12">
                  <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                    <thead>
                      <tr role="row">
                        <th class="center">任务关键字</th>
                        <th class="center">竞品关键字</th>
                        <th class="center">数据来源</th>
                        <th class="center">图形类型</th>
                        <th class="center">情感筛选</th>
                        <th class="center">时间范围</th>
                        <th class="center">操作</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr class="gradeA odd" role="row">
                          <td class="center"><?php echo getTaskBYCompeting($v['zhu_renwu'])?></td>
                          <td class="center"><span><?php echo ($v["fu_kwds_view"]); ?></span></td>
                          <td class="center">

                          <?php if(strlen($v['fid'])>2){?>
                              <img src="__PUBLIC__/images/1.jpg" height="20">
                              <img src="__PUBLIC__/images/2.jpg" height="20">
                            <?php }else{ echo "<img src='__PUBLIC__/images/$v[fid].jpg' height='20'>"; }?>

                          <td class="center"><?php echo ($v["graph_type"]); ?></td>
                          <td class="center"><?php echo ($v["partial"]); ?></td>
                          <td class="center"><?php echo ($v["time_view"]); ?></td>
                          <td class="center">
                          <a href="__URL__/<?php echo ($v["id"]); ?>.html?kwds=<?php echo getTaskBYCompeting($v['zhu_renwu'])?>&c=<?php echo ($v["fu_kwds_view"]); ?>">
                            <button type="button" class="btn btn-outline btn-primary btn-xs">查看结论</button>
                          </a>
                            <button type="button" class="btn btn-outline btn-primary btn-xs" onclick="delCompeting(<?php echo ($v["id"]); ?>)">删除</button></td>
                        </tr><?php endforeach; endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>


		          <div class="row">
                <?php echo ($page); ?>
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
	<script src="__PUBLIC__/js/bootstrap-datetimepicker.min.js"></script>
   <script src="__PUBLIC__/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script>
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
    //根据词条筛选得到竞品词条
    function changeCompeting(o){
        $.post('__URL__/ajaxGetCompetingById',{id:o.value},function(data){
             //
            if(data==''){
              $("#competing").html("");
            }else{
               $("#competing").html(data);
            }
        },"html");
        $.post('__URL__/ajaxGetFidById',{id:o.value},function(data){
             //
            if(data==''){
              $("#datafrom").html("");
            }else{
               $("#datafrom").html(data);
            }
        },"html");        
    }

    //添加竞品任务分析
    function addCompeting(){
      var zhu_renwu = $("#zhu_renwu").val();
      var date      = $("input[name='date']:checked").val();
      if(date=='date5'){
        date1=$("#dtp_input1").val()+'--'+$("#dtp_input2").val();
      }else{
        date1 = "";
      }
      //alert(date1);
      var ganqing   = $("input[name='ganqing']:checked").val();
      var pic       = $("input[name='pic']:checked").val();
      var competing = "";
      var fu_kwds_view = '';
      var obj_competing=document.getElementsByName('competing'); //选择所有name="'test'"的对象，返回数组
      //console.info(obj_competing[0].getAttribute("field"));
      //取到对象数组后，我们来循环检测它是不是被选中
      for(var i=0; i<obj_competing.length; i++){
        if(obj_competing[i].checked){
          competing+=obj_competing[i].value+','; //如果选中，将value添加到变量s中
          fu_kwds_view+=obj_competing[i].getAttribute("field")+',';
          
        } 
      }
      var data="";
      var obj_data=document.getElementsByName('data'); //选择所有name="'test'"的对象，返回数组
      //取到对象数组后，我们来循环检测它是不是被选中
      for(var i=0; i<obj_data.length; i++){
        if(obj_data[i].checked) data+=obj_data[i].value+','; //如果选中，将value添加到变量s中
      }
      if(data=='' || competing==''){//判断是否为空
          alert('竞品词条和数据来源不允许为空！');return false;
      }
      $.post("__URL__/ajaxAddCompeting",{date1:date1,zhu_renwu:zhu_renwu,date:date,ganqing:ganqing,pic:pic,competing:competing,data:data,fu_kwds_view:fu_kwds_view},function(s){
        if(s=='success'){
          alert('添加成功');location.reload();
        }else{
          alert("添加失败");return false;
        }
      })
    }


    function delCompeting(id){
      if(confirm("确定要删除该数据吗？")){
        $.post("__URL__/ajaxDelCompeting",{id:id},function(data){
          if(data=='success'){
            alert('删除成功');location.reload();
          }else{
            alert("删除失败");return false;
          }
        })
      }

    }
</script>
  <script>
    //加载菜单栏
      $(function(){
        $(".datetimepicker").hide();
		    $("#optionsRadiosInline5").click(function(){
    			if( $(".datetimepicker").css("display")=="none"){
    				$(".datetimepicker").show();
    			}else{
    				$(".datetimepicker").hide();
    			}
		    });
		//日期
    		$(".datetimepicker").datetimepicker({
    		  language:  'zh-CN',
          weekStart: 1,
          todayBtn:  1,
      		autoclose: 1,
      		todayHighlight: 1,
      		startView: 2,
      		minView: 2,
      		forceParse: 0
        });
      })

    </script>

<script>
      //加载菜单栏

</script>

</body>

</html>