<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
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
  <link href="__PUBLIC__/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
  <style type="text/css">
  .tab-content .list-group .list-group-item {
  border-top-style: none;
  border-right-style: none;
  border-bottom-style: none;
  border-left-style: none;
  margin: 0px;
  padding: 0px;
}
    .tab-content .list-group .list-group-item .panel.panel-default {
  margin-bottom: 10px;
}
    .pagination {
  margin-top: 0px;
}
    .youxuliebiao {
  font-size: 12px;
  padding-left: 15px;
}
  .youxuliebiao li{line-height:250%}
    .youxuliebiao li .btn{
  margin: 0px;
  padding: 0px;
}
    </style>
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
              </div>
        </nav>
        <!-- Page Content -->
        <div id="page-wrapper">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12">
                <h1 class="page-header">任务筛选</h1>
                  <div class="panel panel-default">
                      <div class="panel-body">
                        <div class="col-md-5" id="date_search">时间选择：
                          <button type="button" class="btn btn-primary quickdate btn-sm pic1" onclick="change_date('pic1')">今日</button>
                          <input name="pic" id="pic1" checked="checked" type="radio" style="display:none" value="today">
                          <input name="date1"  type="hidden">
                          <button type="button" class="btn btn-outline btn-primary quickdate btn-sm pic2" onclick="change_date('pic2')">本周</button>
                          <input name="pic" id="pic2"  type="radio" style="display:none" value="week">
                          <button type="button" class="btn btn-outline btn-primary quickdate btn-sm pic3" onclick="change_date('pic3')">上周</button>
                          <input name="pic" id="pic3"  type="radio" style="display:none" value="last_week">
                          <button type="button" class="btn btn-outline btn-primary quickdate btn-sm pic4" onclick="change_date('pic4')">本月</button>
                          <input name="pic" id="pic4"  type="radio" style="display:none" value="month">
                          <button type="button" class="btn btn-outline btn-primary quickdate btn-sm pic5" onclick="change_date('pic5')">上月</button>
                          <input name="pic" id="pic5"  type="radio" style="display:none" value="last_month">
                          <div class="form-group quickchangedate">
                            <div class="input-group date form_date " data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1" data-link-format="yyyy-mm-dd">
                              <input class="form-control" size="16" type="text" value="" readonly>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                            <input type="hidden" id="dtp_input1" name="start_time" value="" /><br/>
                          </div>
                          <div class="form-group quickchangedate">
                            <div class="input-group date form_date " data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                              <input class="form-control" size="16" type="text" value="" readonly>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            </div>
                          <input type="hidden" id="dtp_input2" value="" name="end_time" /><br/>
                          </div>
                          <button type="button" class="btn btn-outline btn-primary btn-sm pic6" id="changedate" onclick="change_date('pic6')">自选</button>
                          <input name="pic" id="pic6"  type="radio" style="display:none" value="optional">
                        </div>
                        <div class="col-md-3">  
                        </div>
                        <br/><br/>
                        <div class="col-md-5 form-inline" id="article_search">帖子搜索：
                          <button type="button" class="btn btn-primary  btn-sm" onclick="change_article('title')">搜标题</button>
                          <input name="article1" id="title"  type="radio" style="display:none" value="middle" checked="checked">
                          <div class="form-group input-group col-md-5">
                            <input type="text" class="form-control" placeholder="请输入关键词" id="article_title">
                          </div>  
                        </div>
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-3">
                          <button type="submit" onclick="getArticleData(5)" class="btn btn-primary btn-outline ">筛选</button>
                        </div>
                    
                  </div>
                </div>
              </div>
            </div>
        
      <div class="row">
                              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel">主题分类管理</h4>
                                    </div>
                                    <div class="modal-body">
                                      <div class="row">
                                        <div class="col-sm-12">
                                          <div class="form-group">
                                            <label>选择主题</label>
                                            <select class="form-control">
                                              <option>满意度</option>
                                              <option>市场机会</option>
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label>选择主题分类</label>
                                            <select class="form-control">
                                              <option>收费情况</option>
                                              <option>硬件设施</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-primary" data-dismiss="modal">提交</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                    <div class="col-lg-8">
                       
            <div class="panel panel-default" data-find="_2">
            <input type="hidden" id="tabvalue" >  
                        <div class="panel-body" data-find="_1" id="myTab">
                              <ul class="nav nav-tabs">
                                <li class="active">
                                  <a href="#home" data-toggle="tab" aria-expanded="true" onclick="switchTabGetData(2)"> 微信</a>
                                </li>
                                <li class="">
                                  <a href="#profile" onclick="switchTabGetData(1)">微博</a>
                                </li>
                              </ul>
                            <div class="tab-content">
<!--微博开始-->
                            <div class="tab-pane fade active in" id="home">

                            </div>
<!--微博结束-->
<!--微信开始-->
                            <div class="tab-pane fade" id="profile">

                            </div>
<!--微信结束-->
  
                            </div>
                          </div>
                        <!-- /.panel-body -->
                        </div>
                      </div>
                     <!-- /.col-lg-8 -->
                      <div class="col-lg-4">
                       
                        <div class="panel panel-default" data-find="_2">
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body" data-find="_1">
                            <!-- Nav tabs -->
                              <ul class="nav nav-tabs">
                                <li class="active"><a  href="#good" data-toggle="tab" aria-expanded="true"><span class="fa fa-smile-o" style="font-size:18px; color:#F00"></span> 内容（正面）</a>
                                </li>
                                <li class=""><a href="#bad" data-toggle="tab" aria-expanded="false"><span class="fa fa-frown-o" style="font-size:18px; color:#06F"></span> 内容（负面）</a>
                                </li>
                              </ul>
                            <!-- Tab panes -->
                              <div class="tab-content">
                                <div class="tab-pane fade active in" id="good">
                                  <p></p>
                                  <ol class="youxuliebiao">
                                  <?php if(is_array($active)): foreach($active as $key=>$v): ?><li>
                                      <div class="pull-right">
                                        <button type="button" class="btn btn-link glyphicon glyphicon-trash" onclick="delArticle(<?php echo ($v["id"]); ?>)"></button>
                                      </div>
                                      <a href="__URL__/mng_mission_article_detail?id=<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></a>
                                    </li><?php endforeach; endif; ?>
                                  </ol>
                                  <div>
                                  </div>
                                </div>
                                <div class="tab-pane fade" id="bad">
                                  <p></p>
                                  <ol class="youxuliebiao">
                                  <?php if(is_array($inactive)): foreach($inactive as $key=>$v): ?><li>
                                      <div class="pull-right">
                                        <button type="button" class="btn btn-link glyphicon glyphicon-trash" onclick="delArticle(<?php echo ($v["id"]); ?>)"></button>
                                      </div>
                                      <a href="__URL__/mng_mission_article_detail?id=<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></a>
                                    </li><?php endforeach; endif; ?>
                                  </ol>
                                  <div>
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

   <script type="text/javascript" src="__PUBLIC__/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>

   <script type="text/javascript" src="__PUBLIC__/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script>
//bootstrap tab页签切换 
$(function () { 
  $('#myTab a:first').tab('show');//初始化显示哪个tab 

  $('#myTab a').click(function (e) { 
    e.preventDefault();//阻止a链接的跳转行为 
    $(this).tab('show');//显示当前选中的链接及关联的content 
  }) 
})
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
//$('#pic3').attr("checked","checked");
        getArticleData(2);
      })

$(function(){
  $(".quickchangedate").hide();
  showdate=1;
  $("#changedate").click(function(){
    if(showdate==1){
      $(".quickdate").hide();
      $(".quickchangedate").show();
      showdate=0;
    }
    else{
      $(".quickdate").show();
      $(".quickchangedate").hide();
      showdate=1;
    }
  });
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
  $("#selectAll").click(function(){  
    if(this.checked){    
      $("#list :checkbox").attr("checked", true);   
    }else{    
      $("#list :checkbox").attr("checked", false); 
    }    
  });  
});


//ajax获取当前任务ID下的微博/微信数据
//fid 渠道 pagenum 页码 id 任务ID is_star 显示标星文章
  function getArticleData(fid,pagenum,is_star){
    if(fid>4){
      if($("#home").hasClass("active")){
        fid=2;
      }else{
        fid=1;
      }   
    }
    var id = "<?php echo $_GET[id];?>";
    //没有分页默认为1
    if(!pagenum){pagenum=1}
    /*
      是否是点击仅显示标星帖子按钮
      是的则判断是否选中 一次为显示标星 再点则是取消显示标星
      如果不是从点击按钮进来的 直接判断是否选中即可
    */ 
    if(!is_star){
      if($('#is_star').attr('checked')){
        is_star = 2;
      }else{
        is_star = 1;
      }    
    }
    //判断时间选择哪个选中
    for(i=1;i<7;i++){
      if($('#pic'+i).attr('checked')){
        var date_check =  i;
      }
    }
    if(date_check==6){
      var start_time = $('#dtp_input1').val();
      var end_time = $('#dtp_input2').val();
    }
    //标题关键字
    var article_title = $('#article_title').val();
    
    $.post("__URL__/ajaxGetArticleDataByID",{fid:fid,id:id,pagenum:pagenum,is_star:is_star,date_check:date_check,article_title:article_title,start_time:start_time,end_time:end_time},function(data){
      if(fid==2){
        $('#home').html(data);
      }else{
        $('#profile').html(data);
      }
      $(".pic"+date_check).removeClass("btn-outline");
    },'html')
  }

//ajax分页
function ajaxPage(pagenum){
  getArticleData(5,pagenum);
}
//显示标星文章
function showStar(){
  if($('#is_star').attr('checked')){
    is_star = 1;
  }else{
    is_star = 2;
  }
  getArticleData(5,1,is_star);
}


//自定义tab切换加载数据
function switchTabGetData(fid){
  //$('#is_star').attr('checked',false);
  getArticleData(fid);
}

</script>
</body>
<script>
//s=2  取消标星 1为增加  2未标星 1标星
function addStar(s,id){
  $.post("__URL__/ajaxAddStar",{s:s,id:id},function(data){
    if(data=='ok'){
      if(s==2){
        $("#weibo_"+id).removeClass("glyphicon-star-empty");
        $("#weibo_"+id).addClass("glyphicon-star");
        $("#weibo_"+id).attr("title","已标星");
        $("#weibo_"+id).removeAttr("onclick");
        $("#weibo_"+id).attr("onclick","addStar(1,"+id+")");
      }else{
        $("#weibo_"+id).removeClass("glyphicon-star");
        $("#weibo_"+id).addClass("glyphicon-star-empty");
        $("#weibo_"+id).attr("title","未标星");
        $("#weibo_"+id).removeAttr("onclick");
        $("#weibo_"+id).attr("onclick","addStar(2,"+id+")"); 
      }
    }else{
      alert("添加失败");
    }
  })
}
//删除文章
function delArticle(id){
  $.post("__URL__/ajaxDelArticle",{id:id},function(data){
    if(data=='ok'){
      $("#li_list_"+id).hide();
      var page_count = $('#page_count').html();
      var page_count_1 = page_count - 1;
      $('#page_count').html(page_count_1);
    }else{
      //alert("删除失败");
      console.log(data);
    }
  })  
}


/*function go_weixin(){
  var id = "<?php echo $_GET[id]?>";
  var kwds = "<?php echo $_GET[kwds]?>";
  location.href = "__URL__/mng_misson_analysis_w?id="+id+"&kwds="+kwds;
}*/
function change_date(pic){

  $("#date_search input").attr("checked",false);
  $("#"+pic).attr("checked","checked" );

  $("."+pic).removeClass("btn-outline");
  $("#date_search button").addClass("btn-outline");

  var date   = $("#"+pic).val();
  $("input[name='date1']").val(date);
  console.info(date);
}

function change_qinggan(qinggan){
  //console.info($("#qinggan_search").html());
  $('.'+qinggan).removeClass("btn-outline");
  $("#qinggan_search button").addClass("btn-outline");
  

  $("#qinggan_search input").attr("checked",false);
  $("#"+qinggan).attr("checked","checked" );  
}


function change_article(article){
  $("#article_search input[name='article']").addClass("btn-outline");
  $(this).removeClass("btn-outline");

  $("#article_search input").attr("checked",false);
  $("#"+qinggan).attr("checked","checked" );  
}
</script>
</html>