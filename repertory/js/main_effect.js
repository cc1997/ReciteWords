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

            $('#nextBtn').on('click',function(){
                var temp = $("#xcho").css("margin-left");
                temp = parseInt(temp.match(/\d+/)[0]);
                var parentWidth = $('.fixFrame').css('width');
                parentWidth = parseInt(parentWidth.match(/\d+/)[0]);
                var calValue = -1 * Math.ceil(temp/parentWidth) * 100;

                console.log(calValue);
                if(calValue == -200){
                    $("#xcho").css("margin-left","-100%");
                    calValue = -100;
                    $("#preCont").html($("#nowCont").html());
                    $("#nowCont").html($("#nextCont").html());
                    $("#nextCont").html();
                }
                var speed = 10;
                var dist = 0;
                var nextAnimate = setInterval(function(){
                    if(dist == 100){
                        clearInterval(nextAnimate);
                    }else{
                        calValue = (calValue - speed);
                        var strValue = calValue + "%";
                        $('#xcho').css("margin-left",strValue); 
                        dist += speed;
                    }
                    
                },20);
            })
            $('#backBtn').on('click',function(){
                var temp = $("#xcho").css("margin-left");
                temp = parseInt(temp.match(/\d+/)[0]);
                var parentWidth = $('.fixFrame').css('width');
                parentWidth = parseInt(parentWidth.match(/\d+/)[0]);
                var calValue = -1 * Math.ceil(temp/parentWidth) * 100;

                console.log(calValue);
                if(calValue == 0){
                    $("#xcho").css("margin-left","-100%");
                    calValue = -100;
                    $("#nextCont").html($("#nowCont").html()); 
                    $("#nowCont").html($("#preCont").html());
                }

                var speed = 10
                var dist = 0;
                var backAnimate = setInterval(function(){
                    if(dist == 100){
                        clearInterval(backAnimate);
                    }else{
                       calValue = (calValue + speed);
                        var strValue = calValue + "%";
                        $('#xcho').css("margin-left",strValue); 
                        dist += speed;
                    }
                },20);
            })
       })