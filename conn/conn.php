<?php
 //$link = mysqli_connect("localhost","a0915104520","密码","a0915104520",3306) or die("数据库服务器连接错误".mysql_error());
 $link = mysqli_connect("localhost","root","","a0915104520",3306) or die("数据库服务器连接错误".mysql_error());
 mysqli_query($link,"set names utf8");
?>
