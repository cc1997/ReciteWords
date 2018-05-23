<?php
header("Content-type:text/html;charset=utf-8");
include_once('../../conn/conn.php');
include 'readword.php';
$savePath = "../".$_POST['fileLoc'];
$wordType = $_POST['fileType'];
$rt = new WordPHP();
?>

<!DOCTYPE html>
<html>
    <title>成功页面</title>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.css">
        <style>
            body{
                 background-color:#000;
            }
            .input-group{
            margin:10px 0px;//输入框上下外边距为10px,左右为0px
            }
            h3{
            padding:5px;
            border-bottom:1px solid #ddd;//h3字体下边框
            }
            li{
            list-style-type:square;//列表项图标为小正方形
            margin:10px 0;//上下外边距是10px
            }
            em{//强调的样式
            color:#c7254e;
            font-style: inherit;
            background-color: #bbb;
            }
            footer{
                width:100%;
                text-align:center;
                position:absolute;
                bottom:20px;
            }
            @media(max-width:768px){
                body{
                 margin:0;
                 background-color:#000;
                }
            }
        </style>
        
    </head>
    <body>
        <div id='infoPre'>
            <?php echo $rt->readDocument($savePath);?>
        </div>
        <script src="../../vendor/jquery/jquery.min.js"></script>
        <div class="row" style="margin-top:30px;">
            <div class="col-md-12" style="text-align:center;color:white;font-size:22px;font-weight:bold;">
                <div id="prog_out" class="progress progress-striped active" style='width:80%;margin:0 auto;'>
                    <div id="prog_in" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style='width:100%'>
                    </div>
                </div>
                <br>
                <div id='updateResultDiv'>
                    正在解析、读取word单词
                    <br>
                    请稍后...
                </div>
            <script>
                function recieveUpdateStatus(){
                    $('#updateResultDiv').html(<?php echo $_POST['num']?>);
                }
                setInterval("recieveUpdateStatus()",100);
                var cnt=0;
                var languageTag =true;//true解释，false英文
                var srcArr =new Array();
                var wordArr=new Array();
                var meanArr=new Array();
                $("p").each(function(){
                    var temp = $(this).children("span").text();
                    if(srcArr[cnt]!='undefined')
                        srcArr[cnt]=temp;
                    //document.write(srcArr[cnt]+'<br>') ;
                    cnt++;
                })
                $("#infoPre").html("");
                for(var i=0;i<srcArr.length-1;i++)
                {
                    if(srcArr[i]=='')
                    {
                        if(srcArr[i+1]=='')
                        {
                            continue;
                        }
                        else if(srcArr[i+5]=='')
                        {
                            //secArr[i+1];标题暂时不存
                            i=i+5;
                            continue;
                        }
                        else
                        {
                            if(languageTag==true)
                            {
                                meanArr.push(srcArr[i]);
                                languageTag=false;
                            }
                            else
                            {
                                wordArr.push(srcArr[i]);
                                languageTag=true;
                            }
                        }
                    }else{
                        if(languageTag==true)
                        {
                            meanArr.push(srcArr[i]);
                            languageTag=false;
                        }
                        else
                        {
                            wordArr.push(srcArr[i]);
                            languageTag=true;
                        }
                    }
                }
                let realUpdateWordNum = 0;
                var lostList = new Array();//空缺单词
                var arrayJson = new Array();
                //var arrayJson = {};//正确单词
                for(var key in meanArr){
                    //console.log(key+meanArr[key]+wordArr[key]);
                    //console.log('英文：'+wordArr[key]+'<br>');
                    if(meanArr[key]!=''&&wordArr[key]==''||meanArr[key]==''&&wordArr[key]!=''){
                        lostList.push(key);
                    }else{
                        var item = new Object();
                        item.chnmean = meanArr[key].replace(/[\r\n]/g,"").replace(/(^\s*)|(\s*$)/g, "").replace(/\s+/g,' ');//正则去掉前后空格以及换行符
                        item.engword = wordArr[key].replace(/[\r\n]/g,"").replace(/(^\s*)|(\s*$)/g,"").replace(/\s+/g,' ');//正则去掉前后空格以及换行符
                        arrayJson.push(item);
                    }
                }
                realUpdateWordNum = arrayJson.length;
                jsonText = JSON.stringify(arrayJson);//array转成json字符串
                jsonCopy = JSON.parse(jsonText);//json对象存档
                console.log(jsonText);
                function getUpdateStatus(){
                    //$('#updateResultDiv').html(<?php echo file_get_contents("success/progress.log") ?>);
                    $.ajax({  
                        type: "POST",  
                        async:true,
                        url: "success/progress.log",   
                        dataType: "text",  //也可以json接受
                        success: function (data) {  
                            var progressBarRate = parseInt(data)/realUpdateWordNum*100;
                            $('#prog_in').css('width',progressBarRate+'%');
                            //$('#updateResultDiv').html(progressBarRate);显示上传进度百分比
                        },  
                        error: function (data) {  
                            console.log("failed to upload");  
                        }  
                });  
                }
                
                $.ajax({  
                    type: "POST",  
                    async:true,
                    url: "success/upload_ajax.php",   
                    data: {jsonWord:jsonText,wordType:'<?php echo $wordType ?>'}, 
                    dataType: "text",  //也可以json接受
                    success: function (data) {  
                            clearInterval(attachLoop);
                            $('#prog_in').css('width','100%');
                            console.log(data);  
                            var cntLost=lostList.length;
                            $('#updateResultDiv').html('共识别到<b style=color:#aaa;>&nbsp;'+wordArr.length+'&nbsp;</b>个词，');
                            if(cntLost>0){
                                var diff = wordArr.length-cntLost;
                                $('#updateResultDiv').html($('#updateResultDiv').html()+"有<span style=color:#aaa;>&nbsp;"+(wordArr.length-cntLost-parseInt(data))+"&nbsp;</span>个单词已存在"+'<br>');
                                $('#updateResultDiv').html($('#updateResultDiv').html()+"新上传<b style=color:#4876ff;>&nbsp;"+data+"&nbsp;</b>词"+'<br>');
                                $('#updateResultDiv').html($('#updateResultDiv').html()+"文档中存在以下单词空缺，共<span style=color:#f00;>&nbsp;"+cntLost+"&nbsp;</span>词"+'<br>');
                                $('#updateResultDiv').html($('#updateResultDiv').html()+"<br>");
                            }else{
                                window.location.href="success/";
                            }
                    },  
                    error: function (data) {  
                        console.log("failed to upload");  
                    }  
                });  
                $('#prog_in').css('width','0%');
                var attachLoop = setInterval("getUpdateStatus()",100);
                //原json传值方法弃用，直接连接数据库更新。
                </script>
   
            </div>
            <div class="col-md-12" style="text-align:center;color:white;font-size:22px;">
                <form id='submitLost' action="fixlost/">

                </form>
            </div>
        </div>
        <footer>
                <div style="text-align: center;color:white;">
                    <p>Copyright &copy; Fuzzylock</p>
                </div>
        </footer>
    </body>
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script>
        var cntLost=lostList.length;
        //document.write(meanArr.length);
        if(cntLost>0){
            for(var j in lostList){
                if(meanArr[lostList[j]]!=''&&wordArr[lostList[j]]==''){
                    var x = lostList[j];
                    $("#submitLost").append("<div><span style='font-size:16px;'>"+meanArr[x]+"</span><br><input name="+"''"+" style='padding-left:5px;border:1px solid white;outline:none;border-radius:5px;font-size:16px;color:#fff;background-color:black;' type=text required placeholder="+"'请输入对应英文'"+"></div>");
                }else if(meanArr[lostList[j]]==''&&wordArr[lostList[j]]!=''){
                    var x = lostList[j];
                    $("#submitLost").append("<div><span style='font-size:16px;'>"+wordArr[x]+"</span><br><input name="+"''"+" style='padding-left:5px;border:1px solid white;outline:none;border-radius:5px;font-size:16px;color:#fff;background-color:black;' type=text required placeholder="+"'请输入对应中文'"+"></div>");
                }
            }
            $("#submitLost").append("<br><a href='success/'><input class='btn btn-success btn-sm' value='暂时忽略'><a>");
            $("#submitLost").append("<br><input type=submit class='btn btn-default btn-sm' value='提交补全' disabled>");
            document.write("<hr>");
            document.write("<span style='font-size:13px;color:#fcc;'>"+"Tips：<br/>点击 [ 暂时忽略 ] 将不会上传空缺的词。您可以在文档内找到以下空缺单词，手动修改文档后，重新上传进行覆盖<br/>点击 [ 提交补全 ] 正在完善，暂不支持..."+"</span><br>");
        }else{
            window.location.href="success/";
        }
    </script>
</html>
