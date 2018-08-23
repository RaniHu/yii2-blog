$(function () {
    var uploadFn = {
        isChange:0,
        originUserIcon :$("#final-img").attr("src"),
        init: function () {
            uploadFn.showUploadBox();
            uploadFn.tailoringImg();
            uploadFn.submitForm();
            uploadFn.isChangeUserInfo();
        },
        //========显示上传图片弹窗========
        showUploadBox: function () {
            $(".user-cur-icon").on("click", function () {
                $("#mask").show();
                $("#icon-config-box").slideDown(300, function () {
                    var userIconSrc = $("#final-img").attr("src");
                    $("#icon-config-box .previewImg").append("<img src='" + userIconSrc + "'/>");
                    uploadFn.changeAvatar();
                });

            });

            $(".close-btn-icon").click(function () {
                uploadFn.closeUploadBox();
            });
        },
        //=========关闭上传图片弹窗=========
        closeUploadBox: function () {
            $("#icon-config-box").slideUp(200);
            $("#mask").hide();
        },
        //=========更改头像========
        changeAvatar: function () {
            $("#chooseImg").on("change", function () {
                if (!this.files || !this.files[0]) {
                    return;
                }
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#tailoringImg").cropper('replace', e.target.result, false);
                }
                $(".icon-show-area p").remove();
                reader.readAsDataURL(this.files[0]);   //异步读取文件内容，结果用data:url的字符串形式表示
                $("#icon-config-box .avatar-name").text(this.files[0].name);
            })
        },
        //=========剪裁图片========
        tailoringImg: function () {

            //cropper图片裁剪
            $('#tailoringImg').cropper({
                aspectRatio: 1 / 1,//默认比例
                preview: '.previewImg',//预览视图
                guides: false,  //裁剪框的虚线(九宫格)
                autoCropArea: 0.8,  //0-1之间的数值，定义自动剪裁区域的大小，默认0.8,16 / 9
                movable: false, //是否允许移动图片
                dragCrop: true,  //是否允许移除当前的剪裁框，并通过拖动来新建一个剪裁框区域
                movable: true,  //是否允许移动剪裁框
                resizable: true,  //是否允许改变裁剪框的大小
                zoomable: true,  //是否允许缩放图片大小
                mouseWheelZoom: false,  //是否允许通过鼠标滚轮来缩放图片
                touchDragZoom: false,  //是否允许通过触摸移动来缩放图片
                rotatable: true,  //是否允许旋转图片
                crop: function (e) {
                    // 输出结果数据裁剪图像。
                }
            });
            //向左旋转
            $(".cropper-rotate-right-btn").on("click", function () {
                $('#tailoringImg').cropper("rotate", 45);
            });
            //向右旋转
            $(".cropper-rotate-left-btn").on("click", function () {
                $('#tailoringImg').cropper("rotate", -45);
            });
            //重置
            $(".cropper-reset-btn").on("click", function () {
                $('#tailoringImg').cropper("reset");
            });
            //放大
            $(".cropper-large-btn").on("click", function () {
                $('#tailoringImg').cropper("zoom", 0.1);
            });
            //缩小
            $(".cropper-small-btn").on("click", function () {
                $('#tailoringImg').cropper("zoom", -0.1);
            });
            //左移
            $(".cropper-arrow-left-btn").on("click", function () {
                $('#tailoringImg').cropper("move", -10, 0);
            });
            //右移
            $(".cropper-arrow-right-btn").on("click", function () {
                $('#tailoringImg').cropper("move", 10, 0);
            });
            //上移
            $(".cropper-arrow-up-btn").on("click", function () {
                $('#tailoringImg').cropper("move", 0, -10);
            });
            //下移
            $(".cropper-arrow-down-btn").on("click", function () {
                $('#tailoringImg').cropper("move", 0, 10);
            });
            //换向
            var flagX = true;
            $(".cropper-scaleX-btn").on("click", function () {
                if (flagX) {
                    $('#tailoringImg').cropper("scaleX", -1);
                    flagX = false;
                } else {
                    $('#tailoringImg').cropper("scaleX", 1);
                    flagX = true;
                }
                flagX != flagX;
            });

            //确认剪裁
            $("#sureCut").click(function () {
                if ($("#tailoringImg").attr("src") == null) {
                    return false
                }
                var canvas = $("#tailoringImg").cropper('getCroppedCanvas'); //获取被裁剪后的canvas
                var base64Url = canvas.toDataURL('image/jpeg');//转换为base64地址形式
                $("#final-img").attr("src", base64Url);//显示为图片的形式
                $("#icon").val(base64Url);//显示为图片的形式
                uploadFn.isChange=1;
                uploadFn.closeUploadBox();
            })

        },
        isChangeUserInfo:function () {
            $("#user-config-box input ").change(function () {
                uploadFn.isChange=1;
            })
        },
        submitForm: function () {

            $("#sub-btn").on("click",function () {
                var email = $("#email").val();
                var sign = $("#sign").val();
                var icon = $("#final-img").attr("src");
                var isChangeIcon=false;
                if(icon!=uploadFn.originUserIcon){
                    isChangeIcon=true;
                }

                //提交表单验证
                if(email==''){
                    $("#email").addClass("danger-border");
                }else if(uploadFn.isChange==1){
                    $.ajax({
                        url: "http://www.huranblog.com/blog/config",
                        method: "POST",
                        dataType: "json",
                        data: {"email": email, "sign": sign, "icon": icon,"isChangeIcon":isChangeIcon},
                        success: function (result) {
                            if(result.status==200){
                                
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            console.log(XMLHttpRequest.status);
                            console.log(XMLHttpRequest.readyState);
                            console.log(textStatus);
                        }
                    })
                }


            })

        }

    }
    uploadFn.init();

})