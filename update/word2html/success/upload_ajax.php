<?php
header("charset=utf-8");
include("../../../conn/conn.php");
$jsonStr = $_POST['jsonWord'];
$wordtype = $_POST['wordType'];
function htmlEncode($str) {
    $str = str_replace('/\s+/ig', '',$str);
    $str = str_replace('/&/g', '',$str);
    $str = str_replace('/</g', '',$str);
    $str = str_replace('/>/g', '',$str);
    $str = str_replace('/(?:t| |v|r)*n/g', '<br />',$str);
    $str = str_replace('/t/g', '',$str);
    $str = str_replace('/x22/g', '"',$str);
    $str = str_replace("/x27/g", "\'",$str);
    $str = str_replace('/x2F/g', "",$str);
    $str = str_replace("/x20/g", "&nbsp;",$str);
    return $str;
   }
$jsonStr = htmlEncode($jsonStr);
//echo $jsonStr;
$data = json_decode($jsonStr,TRUE);
//var_dump($data);
//echo json_last_error();
$i=1;
$a=0;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, '../');
curl_setopt($curl, CURLOPT_HEADER, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POST, 1);
foreach( $data as $value){
    $flag=0;
    $chnmean = $value[chnmean];
    $chnmeanx = addslashes($chnmean);
    $engword = $value[engword];
    $engwordx = addslashes($engword);
    //echo $i.$chnmean.":".$engword;
    $sqlsearch=mysqli_query($link,"select * from elly_allword where chnmean = '$chnmean'");
    if($infosearch=mysqli_fetch_object($sqlsearch)){
        if($infosearch->chnmean==$chnmean){
            do{
                if($infosearch->enword==$engword){
                    //echo '=>'.$engword.'已上传x';
                    $flag=1;
                    break;
                };
            }while($infosearch=mysqli_fetch_object($sqlsearch));
            //echo $flag.'*';
            if($flag==0){
                if(mysqli_query($link,"insert into elly_allword(chnmean,enword,wordtype) values('$chnmeanx','$engwordx','$wordtype')")) {
                    $a++;
                    file_put_contents('progress.log','');
                    file_put_contents('progress.log',$a);
                }
            }
        }else{
            if(mysqli_query($link,"insert into elly_allword(chnmean,enword,wordtype) values('$chnmeanx','$engwordx','$wordtype')")){
                $a++;
                file_put_contents('progress.log','');
                file_put_contents('progress.log',$a);
            }
        }
    }else{
        if($sqlinsert=mysqli_query($link,"insert into elly_allword(chnmean,enword,wordtype) values('$chnmeanx','$engwordx','$wordtype')")){
            $a++;
            file_put_contents('progress.log','');
            file_put_contents('progress.log',$a);
        }else{
            //echo '传输失败';
        }
    }
    $i++;
}
 echo $a;
 file_put_contents('progress.log','0');
// $testStr="asdjsaioncxsnvjcthdsadjiohvicuvc";
// echo $testStr;