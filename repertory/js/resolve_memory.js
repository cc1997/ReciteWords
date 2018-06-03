// var cookieSeeRecord = new Array();
            // cookieSeeRecord[0]="";
            // cookieSeeRecord[1]="";
            // cookieSeeRecord[2]="";
            // cookieSeeRecord[3]="";
            // cookieSeeRecord[4]="";

            /**检查/产生随机序列串，服务器 cookie->server->init  */
            function setCookie(c_name,value,expiredays){
                var exdate=new Date()
                exdate.setDate(exdate.getDate()+expiredays)
                document.cookie=c_name+ "=" + escape(value) + ((expiredays==null) ? "" : ";expires=" + exdate.toGMTString())
            }
            function getCookie(c_name){
                if (document.cookie.length>0){
                    c_start=document.cookie.indexOf(c_name + "=")
                    if (c_start!=-1){ 
                        c_start=c_start + c_name.length+1 
                        c_end=document.cookie.indexOf(";",c_start)
                        if (c_end==-1) c_end=document.cookie.length
                        return unescape(document.cookie.substring(c_start,c_end))
                        } 
                }
                return ""
            }
            var c_record = getCookie('SeeRecord');
            var requestType = 0;//get
            console.log(typeId);
            //console.log(c_record);
            if(c_record!=null && c_record!=""){
                //var randomArr = 
                //setCookie('seeRecord',,1);
                $.ajax({
                    url:"repertory/randomarr.php",//请求地址
                    type:"GET",//提交的方式
                    dataType:"xml", //返回类型 TEXT字符串 JSON XML
                    success:function(responseText){
                        console.log('sucesss');
                        var tempstr = $(responseText).find("recordstr").text();
                        console.log(tempstr);
                    },
                    error:function(data){
                        console.log("failed");
                        console.log(data);
                    }
                });
            }else{
                $.ajax({
                    url:"repertory/latest_status.php",//请求地址
                    type:"GET",//提交的方式
                    dataType:"xml", //返回类型 TEXT字符串 JSON XML
                    success:function(responseText){
                        console.log('sucesss');
                        var tempstr = $(responseText).find("recordstr").text();
                        console.log(tempstr);
                    },
                    error:function(data){
                        console.log("failed");
                        console.log(data);
                    }
                });
            }