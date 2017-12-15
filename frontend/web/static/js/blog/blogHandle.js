$(function () {

    var formHandle = {

        //为当前选择的单选框添加checked        
        radioHandle: function () {
            $("input:radio:first").attr("checked", true).closest("label").addClass("checked").siblings().removeClass("checked");
            $("input:radio").click(function () {
                $(this).attr("checked", true).closest("label").addClass("checked").siblings().removeClass("checked");
            });
        },

        //为当前选择的复选框添加checked
        checkboxHandle: function () {
            $("input:checkbox:first").attr("checked", true).closest("label").addClass("checked").siblings().removeClass("checked");
            $("input:checkbox").click(function () {
                $(this).closest("label").toggleClass("checked");
            });

        },

        //表单聚焦时样式
        focusStyle:function () {
            $("#write-article-form input,#write-article-form textarea").focus(function () {
                $(this).addClass("focus");
            });
            $("#write-article-form input,#write-article-form textarea").blur(function () {
                $(this).removeClass("focus");
            })
        },

        //文章编辑操作
        postEditHandle:function () {

            //点击小图标展开文章操作菜单
            $(".cur-article-list .article-operate .open-icon-box").click(function (e) {
                e.stopPropagation();
                $(this).siblings(".operate-menu").fadeToggle(200);
            });

            //点击菜单选项
            $(".operate-menu").click(function (e) {
                e.stopPropagation();
                $(this).hide();
                if(e.target.innerText=="删除文章"){
                    $(this).siblings(".confirm-box").show();
                }
            });

            //取消删除文章
            $(".cur-article-list .article-operate .confirm-box").click(function (e) {
                if(e.target.innerText=="取消"){
                    e.stopPropagation();
                    $(this).fadeOut(200);
                }
            });

            //收起操作菜单
            $(document.body).click(function () {
                $(".cur-article-list .operate-menu").fadeOut(200);
            })

        },



        init: function () {
            formHandle.radioHandle();
            formHandle.checkboxHandle();
            formHandle.focusStyle();
            formHandle.postEditHandle();
        }

    }

    formHandle.init();
})