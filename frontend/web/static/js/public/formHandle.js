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
    configformValidate: function () {
        if ($("#email").val() == "" || $("textarea").val() == "") {
            alert("内容输入不完整!");
            return false;
        }
    },
    init: function () {
        formHandleFn.focusStyle();
    }
}
formHandleFn.init();