$(function () {

    var BlogHandleFn = {

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
        //评论
        commentAjax: function () {
            $("#article-comment-area .write-comment-box .send-btn.has-login").click(function () {

                var _this=$(this);
                var commentTexts = $("#article-comment-area .write-comment-box .comment-texts").val();
                var articleId = parseInt($("#article-id").val());
                var sendData = {
                    "commentContents": commentTexts,
                    "articleId": articleId
                };
                debugger;

                //发送请求
                $.ajax({
                    type: 'POST',
                    dataType: "json",
                    data: sendData,
                    url: 'http://192.168.80.80/yii2-blog/frontend/web/blog/comment',
                    success: function (res) {
                        if (res.status == 200) {

                            debugger;
                            //清空评论框
                            _this.closest(".comment-btn").siblings(".comment-texts").val("");

                            //更新评论条数
                            $("#article-comment-area .comment-num").text(parseInt(res.curComment.count) + '条评论');

                            //插入评论
                            var appendComment = "<div class='comment-list' data-id='" + ['data']['id'] + "'><h4>" + res.curComment['data']['username'] + "</h4> <p class='comment-contents'>" + res.curComment['data']['content'] + "</p>" +
                                "<div class='other-info clearFix'><p class='comment-date'>" + res.curComment['data']['date'] + "</p>" +
                                "<ul class='reply-comment-nav'><li class='reply-btn'><span>回复</span></li><li><i class='article-like-icon'></i><span>赞</span></li></ul>" +
                                "</div><div class='write-reply-box write-box'><textarea class='comment-texts' placeholder='写下你的回复' name='comment-content'></textarea>" +
                                "<div class='comment-btn'><a class='cancle-btn'>取消</a><a class='form-submit-btn send-btn'>回复</a></div></div></div>";
                            $("#article-comment-area .other-comments").append(appendComment);

                            //点击展示回复框
                            BlogHandleFn.showReplyBox();

                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        debugger;
                        alert(XMLHttpRequest.status);
                        alert(XMLHttpRequest.readyState);
                        alert(textStatus);
                    }
                })
            });
        },
        //回复
        replyAjax: function () {
            $("#article-comment-area .write-reply-box .send-btn.has-login").click(function () {

                var _this = $(this);
                var commentTexts = $(this).closest(".comment-btn").siblings(".comment-texts").val();
                var commentId = $(this).closest(".comment-list").data("id");
                var sendData = {
                    "replyContents": commentTexts,
                    "commentId": commentId
                };

                //发送请求
                $.ajax({
                    type: 'POST',
                    dataType: "json",
                    data: sendData,
                    url: 'http://192.168.80.80/yii2-blog/frontend/web/blog/reply',
                    success: function (res) {
                        if (res.status == 200) {

                            //清空评论框
                            _this.closest(".comment-btn").siblings(".comment-texts").val("");

                            //当前回复html
                            var appendReply = ' <div class="reply-list"><p><a class="reply-user-name">' + res.curComment['data'][0]['user']['username'] + '：</a><span class="reply-content">' + res.curComment['data'][0]['content'] + '</span></p><p><span class="reply-date">' + res.curComment['data'][0]['date'] + '</span><span class="reply-btn">回复</span></p></div>';

                            //插入回复
                            _this.closest(".comment-list").children(".reply-list-box").append(appendReply);

                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        debugger;
                        alert(XMLHttpRequest.status);
                        alert(XMLHttpRequest.readyState);
                        alert(textStatus);
                    }
                })
            });
        },

        //展示回复框
        showReplyBox: function () {
            $("#article-comment-area .reply-comment-nav .reply-btn").click(function () {
                $(this).closest(".comment-list").children(".write-reply-box").fadeToggle();
            });

            $("#article-comment-area .write-reply-box .cancle-btn").click(function () {
                $(this).closest(".write-reply-box").fadeOut();
            });


        },

        //清空评论框内容
        clearCommentBox: function () {
            //点击取消时清空评论框
            $("#article-comment-area .cancle-btn").click(function () {
                $(this).parent(".comment-btn").siblings(".comment-texts").val("");
            });
        },

        init: function () {
            BlogHandleFn.radioHandle();
            BlogHandleFn.checkboxHandle();
            BlogHandleFn.postEditHandle();
            BlogHandleFn.commentAjax();
            BlogHandleFn.replyAjax();
            BlogHandleFn.showReplyBox();
            BlogHandleFn.clearCommentBox();
        }

    }

    BlogHandleFn.init();
})