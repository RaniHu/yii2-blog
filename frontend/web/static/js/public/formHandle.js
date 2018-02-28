var formHandleFn = {
    //表单聚焦时样式
    focusStyle: function () {
        $("input,textarea").focus(function () {
            $(this).addClass("focus");
        });
        $("input,textarea").blur(function () {
            $(this).removeClass("focus");
        })
    },

    //表单验证
    formValidate: function () {
        // $(".form-submit-btn").click(function () {
        //     if ($("input").val() == ""||$("textarea").val()=="") {
        //         alert("内容输入不完整!");
        //         return false;
        //     }
        // })
    },
    init: function () {
        formHandleFn.focusStyle();
        formHandleFn.formValidate();
    }
}
formHandleFn.init();