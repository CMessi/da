<?php    
/*   
*类结构   
   function MysqlConnector() : 类的构造函数，定义和包含配置信息   
   function connectMySql()   : 打开数据库连接   
   function Close()          : 关闭数据库连接            
   function returnSql($sql)  : 执行一条语句，返回一行的数组   
   function executeSql($sql) : 执行一段查询，返回是否成功    
   function returnDb($sql)   : 执行查询，返回数据集   
   function SelectLimit($sql,$offset_b,$offset_n=0)   
                             : 分页查询，返回数据集 参数(sql语句,开始位置,读取行数)   
   function dateArray($sql,$startID,$endID)   
                             : 分页查询，返回二维数组 参数(sql语句,开始位置,读取行数)   
   function getArray($sql)   : 执行两个字段的查询，返回一个数组，格式 array[row["0"]]=>row["1"]   
  
      
      
*使用案例：   
  $conn= new MysqlConnector();   //实例化   
  $db = &$conn;     
     
  $db->returnSql($sql)     //执行查询   
     
*/   
   
// if (!extension_loaded('mysql'))
//   dl('mysql.so');//动态加载Mysql模块   
class MysqlConnector    
{    
/* public: 数据库连接参数 */   
     var $dbhost;        //服务器地址    
     var $dbname;        //数据库名称    
     var $dbusername;    //连接账号    
     var $dbpassword;    //连接密码    
     var $setnames;      //数据库编码    
   
   function MysqlConnector()         //构造函数，数据库链接配置 
   {    

        $this->dbhost = "localhost";    
        $this->dbname = "bigdata";    
        $this->dbusername = "root";    
        $this->dbpassword = "";   
        $this->setnames="UTF8";  
   }    
  
   
   function connectMySql()       //链接数据库，返回活动连接    
   {  
  
     
       // $openconn = mysql_connect($this->dbhost,$this->dbusername,$this->dbpassword, $this->dbname ) or die("连接数据库错误，请检查配置!".mysql_errno());    
	 $openconn = mysql_connect($this->dbhost,$this->dbusername,$this->dbpassword ) or die("连接数据库错误，请检查配置!".mysql_errno());    
	 
		
         mysql_query("SET NAMES '".$this->setnames."'",$openconn);    
       mysql_select_db($this->dbname,$openconn);    
        return $openconn;    
   }    
       
    /*   
    *   
    *执行查询语句，返回某一行的数组   
    */   
   
    function returnArray($sql)    
    {    
        $array_result="";    
        
        //mysql_unbuffered_query   
		//mysql_select_db($this->dbname,$openconn);  
		mysql_query("SET NAMES '".$this->setnames."'",$openconn);    
        $db_result=mysql_query($sql,$this->connectMySql());    
        if($db_result){    
            $array_result=mysql_fetch_array($db_result);                
        }    
        mysql_free_result($db_result);   //释放记录集    

        return $array_result;   
        
                
    }    
        
    /*   
    *   
    *执行查询语句，返回数据集   
    *   
    */   
        
    function returnResult($sql)        
    {    
	    $openconn = mysql_connect($this->dbhost,$this->dbusername,$this->dbpassword) or die("连接数据库错误，请检查配置!".mysql_errno());  
	    mysql_select_db($this->dbname,$openconn); 
        mysql_query ("set names  '".$this->setnames."'", $openconn); 
        $db_result=mysql_query($sql, $openconn);    
mysql_close($openconn); 
        return $db_result;    
            
    }    
      
//执行query方法
    public function query($sql){
    @$openconn = mysql_connect($this->dbhost,$this->dbusername,$this->dbpassword, $this->dbname ) or die("连接数据库错误，请检查配置!".mysql_errno());  
      mysql_select_db($this->dbname,$openconn); 
    mysql_query ("set names  '".$this->setnames."'", $openconn);
    $list=array();
    $result=mysql_query($sql);
    //var_dump($result);die;
    if(mysql_num_rows($result)>0){
      while($row=mysql_fetch_assoc($result)){
        $list[]=$row;
      }
      mysql_free_result($result);
    }
    mysql_close($openconn); 
    return $list;
  }       
    /*
     *
    *执行查询语句，返回一个对象。
    *
    */
    
    function returnObj($sql)
    {
		$openconn = mysql_connect($this->dbhost,$this->dbusername,$this->dbpassword ) or die("连接数据库错误，请检查配置!".mysql_errno());  
	    mysql_select_db($this->dbname,$openconn); 
		mysql_query ("set names  '".$this->setnames."'", $openconn);
		
    	$db_result=mysql_query($sql,$openconn);
    	$obj=mysql_fetch_object($db_result);
mysql_close($openconn); 
    	return $obj;
    	//return $db_result;
    
    }
    
    /*   
    *   
    *执行查询语句，返回某两列的数组，主要用于下拉框，前一列是values,后一列是option   
    *   
    */   
        
     function getArray($sql)         
    {    
        $array_result=array();  
        //mysql_query("SET NAMES '".$this->setnames."'",$openconn);      
       // mysql_select_db($this->dbname,$openconn); 
        $db_result=mysql_query($sql,$this->connectMySql());    
        if($db_result){    
           while($row=mysql_fetch_row($db_result))    
           {    
               $array_result[$row[0]]=$row[1];    
           }    
        }    
        mysql_close($openconn);     
        return $array_result;    
                
    }    
   
    /*   
    *   
    *执行一条sql语句,返回执行是否成功   
    *   
    */   
   
    function executeSql($sql)         
    {        
        
		
		@$openconn = mysql_connect($this->dbhost,$this->dbusername,$this->dbpassword ) or die("连接数据库错误，请检查配置!".mysql_errno());  
	    mysql_select_db($this->dbname,$openconn); 
		mysql_query ("set names '".$this->setnames."'", $openconn); 
		
        $result=mysql_query($sql,$openconn);   
mysql_close($openconn);  
        if(!$result){    
            echo "<!--出错了:" . $sql.mysql_errno()."-->";   
            return false;   
        }else{   
        	//echo "dbo 中执行的SQL为：".$sql;
            return true;       
        }   
    }   
       
    /*   
       
    分页读取sql语句,返回纪录集，   
    参数分别为sql语句，开始行数，读取条数(传递2哥参数时，开始行数即为读取条数)   
    */   
       
    function SelectLimit($sql,$offset_b,$offset_n=0)       
    {   
        
        $result="";   
        $this->CheckLink($sql);   
        if(!$offset_n){   
            $limit = " limit ".$offset_b;   
        }else{   
            $limit = " limit ".$offset_b.",".$offset_n;    
        }   
        $sql.=$limit;   
//      echo "<br>";    
//      echo $sql;    
                
        $result = $this->returnDb($sql);    
 
        return $result;    
    }    
        
/*   
*   
*将数据集转化成数组   
*   
*/      
    function dateArray($sql,$startID,$endID)    
    {
    	mysql_query("SET NAMES '".$this->setnames."'",$openconn);      
       $array_result=array();    
       $db_result=$this->SelectLimit($sql,$startID,$endID);           //根据sql语句读取数据集    
           
       if($db_result){                                //数据集存在    
           $i=0;    
           while($row=mysql_fetch_row($db_result))    //循环填充数组    
           {    
               $array_result[$i]=$row;    
               $i++;    
           }    
        }    
            
        return $array_result;    
        
    }    
            
   
           
}