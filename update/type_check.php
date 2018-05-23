<?php
include_once("../conn/conn.php");
$realName= $_POST['fileName'];
$sql = mysqli_query($link , "select * from elly_filerecord where filename = '$realName'");
$result = mysqli_fetch_object($sql);
$date=date("Y-m-j H:i:s");
if($result->filename!=''){
    echo $result->filetype;
}else{
    echo "new";
}