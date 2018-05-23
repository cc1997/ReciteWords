
<div class="indexTitle" style='background-color:black;color:white;'>
    <h4>文件上传</h4>
</div>
<div class="container-fluid" style="padding-top:50px;">
    <div class="row">
        <div class="col-md-2 visible-md-block visible-lg-block">

        </div>
        <div class="col-md-8 col-sm-12 mainContent">
            <form action="update/file_check.php" method='post' enctype="multipart/form-data">
                <input style='display:inline-block;padding-left:80px;' type="file" name="file" id="file" /><br><br>
                类别：<select name="wordType" id="wordType" style='width:100px;'>
                    <option value="policy">政治</option>
                    <option value="economy">经济</option>
                    <option value="culture">文化</option>
                    <option value="technology">科技</option>
                    <option value="hot">热点</option>
                </select><br><br>
                <p id='checkTips' style='font-size:12px;color:red;'></p>
                <input type="submit" name="submit" value="使用该文件更新词库" class='btn btn-sm btn-primary'/>
            </form>
        </div>
        <div class="col-md-2 visible-md-block visible-lg-block">

        </div>
    </div>
    <hr>
    <div class='row'>
        <div class='col-md-12 mainContent'>
            1.电脑端：可以<br>
            2.ios端：ios11以上貌似可以<br>
            3.安卓端：基本可以<br>
            请按格式上传
        </div>
    </div>
</div>
<script>
    let fileNamex = '';
    $("#file").change(function(){
        //console.log(this.files[0]['name']);
        fileNamex = this.files[0]['name'];
        $.ajax({
            async:false,
            type:"POST",
            url:"update/type_check.php",
            data:{fileName:fileNamex},
            dataType: "text",  //也可以json接受
            success: function (data) {  
                    $("#checkTips").html("检测到当前文件已上传,已为你自动选择分类");
                    switch(data){
                        case '0':
                            $("#wordType").val('policy');
                            break;
                        case '1':
                            $("#wordType").val('economy');
                            break;
                        case '2':
                            $("#wordType").val('culture');
                            break;
                        case '3':
                            $("#wordType").val('technology');
                            break;
                        default:
                            $("#wordType").val('hot');
                            $("#checkTips").html("");
                    }  
            },  
            error: function (data) {  
                console.log("error");  
            } 
        });
    })
    
</script>