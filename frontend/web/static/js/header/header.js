$(function () {
    var headeHandle={

        //头部导航栏操作
        headerNavHandle:function(){
            var navList = $("#header ul.header-nav li a");
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
                var _this=$(this);
                var themeName = $(this).attr('class');

                //发送请求
                $.ajax({
                    type     :'GET',
                    dataType:"json",
                    data:{"theme":themeName},
                    url  : 'http://192.168.80.80/yii2-blog/frontend/web/blog/theme',
                    success:function(res){
                        _this.closest(".blog-container").attr('id',res.themeName);

                    },
                    error:function (jqXHR) {
                        alert("发生错误");
                    }
                })

            })
        },

        //二级菜单事件
        secondMenuHandle:function () {
            $("#header .user-login-nav li a.user-name").click(function (e) {
                e.stopPropagation();
               $(this).siblings('.user-config-menu').fadeToggle(200);
            });
            $(document.body).click(function (e) {
                $("#header .user-login-nav li .user-config-menu").fadeOut(200);
            })
        },
        init:function () {
            headeHandle.headerNavHandle();
            headeHandle.themeHandle();
            headeHandle.secondMenuHandle();
        }
    }
    headeHandle.init();
})




