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
        $(".form-submit-btn").click(function () {
            if ($("input,textarea").val() == "") {
                alert("内容输入不完整!");
                return false;
            }
        })
    },
    commentAjax: function () {
        $("#article-comment-area .comment-send-btn").click(function () {

            var commentTexts = $("#article-comment-area .comment-texts").val();
            var articleId = parseInt($("#article-id").val());
            var sendData={
                "commentContents":commentTexts,
                "articleId":articleId
            };
            //发送请求
            $.ajax({
                type: 'GET',
                dataType: "json",
                data: sendData,
                url: 'http://192.168.80.80/yii2-blog/frontend/web/blog/comment',
                success: function (res) {
                    $("#article-comment-area .comment-texts").val("");
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.status);
                    alert(XMLHttpRequest.readyState);
                    alert(textStatus);
                }
            })
        })

    },

    init: function () {
        formHandleFn.focusStyle();
        formHandleFn.formValidate();
        formHandleFn.commentAjax();
    }
}
formHandleFn.init();