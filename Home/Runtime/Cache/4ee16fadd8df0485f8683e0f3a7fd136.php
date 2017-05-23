<?php if (!defined('THINK_PATH')) exit();?>               <div class="sidebar-nav navbar-collapse">
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