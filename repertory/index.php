<?php
session_start();
if(isset($_POST['typeId'])){
    $typeId=$_POST['typeId'];
    $_SESSION['typeId']=$typeId;
    //echo '<script>alert("1")</script>';
}else{
    if(isset($_SESSION['typeId'])){
        $typeId=$_SESSION['typeId'];
       //echo '<script>alert("2")</script>';
    }
    else{
        $typeId=0;
        //echo '<script>alert("3")</script>';
    }
}
?>
<div class="indexTitle">
    <a id="0" href="#" class="<?php if($typeId=='0'){echo 'pinkTag';}else{echo '';}?>">政治</a>
    <a id="1" href="#" class="<?php if($typeId=='1'){echo 'pinkTag';}else{echo '';}?>">经济</a>
    <a id="2" href="#" class="<?php if($typeId=='2'){echo 'pinkTag';}else{echo '';}?>">文化</a>
    <a id="3" href="#" class="<?php if($typeId=='3'){echo 'pinkTag';}else{echo '';}?>">科技</a>
    <a id="4" href="#" class="<?php if($typeId=='4'){echo 'pinkTag';}else{echo '';}?>">热点</a>
</div>
<div class="container-fluid" style=" height:100%;">
    <div class="row">
        <div class="col-md-2 visible-md-block visible-lg-block">

        </div>
        <div class="col-md-8 col-sm-12 mainContent">
            <div class="chnStr">
                自由贸易区
            </div>
            <div class="enStr">
                free trade zone free trade zone
            </div>
            <div class='changeBtn box'>
                <a href='#' ripple="ripple" data-ripple-background='#000' style='height:35px;line-height:35px;font-size:16px;font-weight:600'>换一个</a><br>
                <a href='#' class='addColdWord' style='width:30%;margin-top:25px;'>加入生词本</a>
            </div><br>
            <div class="userLoc" id="0">
                位置 >> <span>政治板块</span>
            </div>
        </div>
        <div class="col-md-2 visible-md-block visible-lg-block">

        </div>
    </div>
</div>
<script>
        $('.userLoc').attr('id',<?php echo $typeId;?>);
        var locShow = $('.userLoc').attr('id');
        switch(locShow){
            case "0":
            $('.userLoc').children('span').text('政治板块');
            break;
            case "1":
            $('.userLoc').children('span').text('经济板块');
            break;
            case "2":
            $('.userLoc').children('span').text('文化板块');
            break;
            case "3":
            $('.userLoc').children('span').text('科技板块');
            break;
            default:
            $('.userLoc').children('span').text('热点板块');
            break;
        }
</script>
    <script type="text/javascript">
       $(function(){
           $('[ripple]').on('click',function(e){
                var rippleDiv = $('<div class="ripple"></div>');
                pOffset = $(this).offset();
                rippleX = e.pageX - pOffset.left;
                rippleY = e.pageY - pOffset.top;
                ripple = $('.ripple');
                rippleDiv.css({
                    left:rippleX - ripple.width() / 2,
                    top:rippleY - ripple.height() / 2,
                    background: $(this).attr('data-ripple-background')
                }).appendTo($(this));

                window.setTimeout(function () {
                    rippleDiv.remove();
                }, 1500)
            })
       })
    </script>