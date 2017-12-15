$(function () {
    var headeHandle={

        //头部导航栏操作
        headerNavHandle:function(){
            var navList = $("#header ul a");
            var curLocation=window.location.href.split("?")[0].split("/");
            var curPage=curLocation[curLocation.length-1];
            navList.each(function (index,item) {
                if(item.className==curPage){
                    $(this).addClass("active").siblings().removeClass("active");
                }
            })
        },
        //主题切换操作
        themeHandle:function () {
            $("#header ul.theme-list li").click(function () {
                debugger;

                $(this).closest(".blog-container").attr('id',$(this).attr('class'));
                var themeName = $(this).attr('class');//这个值可以得到，但是传不过去
                var data={
                    "theme":themeName
                }

                $.ajax({
                    type     :'POST',
                    dataType:"json",
                    contentType: " application/json;charset=UTF-8",
                    data: JSON.stringify(data),
                    url  : 'http://192.168.80.80/yii2-blog/frontend/web/blog/theme',
                    success:function(data){
                        debugger;
                        alert("aa");
                    }
                })

            })
        },
        init:function () {
            headeHandle.headerNavHandle();
            headeHandle.themeHandle();
        }
    }
    headeHandle.init();
})




