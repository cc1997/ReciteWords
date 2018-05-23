<?php

header("Content-type:text/html;charset=utf-8");
include_once("../conn/conn.php");
session_start();
date_default_timezone_set("Etc/GMT-8");

if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br />";
  }
else
  {
    $timeStr = strtotime("now");
    //echo $timeStr;
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["file"]["tmp_name"];
    if (file_exists("uploadfile/" . $_FILES["file"]["name"]))
    {
        echo $_FILES["file"]["name"] . " already exists. ";
    }
    else
    {
        if(!is_dir("uploadfile/")){
          mkdir("uploadfile/");
        }
        $realName = $_FILES["file"]["name"];//iconv("UTF-8","gbk",$_FILES["file"]["name"])
        $saveName = "uploadfile/" . $timeStr . ".docx";//当前时间戳作为文件名
        if($_POST["wordType"]=='policy') $wordType = 0;
        else if($_POST["wordType"]=='economy') $wordType = 1;
        else if($_POST["wordType"]=='culture') $wordType = 2;
        else if($_POST["wordType"]=='technology') $wordType = 3;
        else if($_POST["wordType"]=='hot') $wordType = 4;
        move_uploaded_file($_FILES["file"]["tmp_name"] , $saveName);
        echo "Stored in: " . "uploadfile/" . $_FILES["file"]["name"];
        $sql = mysqli_query($link , "select * from elly_filerecord where filename = '$realName'");
        $result = mysqli_fetch_object($sql);
        $date=date("Y-m-j H:i:s");
        if($result->filename!=''){
          echo "<script>alert('当前文档名已存在，将为你覆盖之前文档。')</script>";
          $sqlDel = mysqli_query($link , "delete from elly_filerecord where filename = '$realName'");
          $resultDel = mysqli_fetch_object($sqlDel);
        }
        $sqlIn = mysqli_query($link , "insert into elly_filerecord(filename,filepath,filetype,updatetime) values('$realName','$saveName','$wordType','$date')");
        $resultIn = mysqli_fetch_object($sqlIn);
        echo "<form style='display:none;' id='form1' name='form1' method='post' action='word2html/'>
                <input name='fileLoc' type='text' value='$saveName' />
                <input name='fileType' type='text' value='$wordType' />
              </form>
              <script type='text/javascript'>function load_submit(){document.form1.submit()}load_submit();</script>";
    }
  }
?>
