/*
** jQuery消息提示框组件
   @param type
*/
(function($){

    $.msgBox=function(options){
        var defaults={
            element:'body',                             //消息框放在哪个dom元素下
            type:'success',                             //消息类型(success、fail、warning、message)
            content:'',                                 //消息内容
            showCloseBtn:true,                          //是否显示关闭按钮
            showIcon:true,                              //是否显示图标
            position:'left',                            //文字位置
            autoClose:false                              //自动关闭的时间   null  1000 2000
         };
         //defaults为默认值，options是接收来的参数对象，最后所有参数合并到第一个里。同名属性合并的时候后面接收来的会覆盖 默认的
         var settings=$.extend(defaults,options);

         var box={
             template:'<div class="msg-box  msg-'+settings.type+'"><i class="msg-icon icon-'+settings.type+'"></i><p class="msg-content">'+settings.content+'</p><i class="icon-close-btn"></i></div>',
             _open:function(temp){

                //是否显示关闭按钮
                if(!settings.showCloseBtn){
                    $(".msg-box .close-btn").remove();
                }

                //是否显示图标
                if(!settings.showIcon){
                    $(".msg-box .msg-icon").remove();
                }
                return temp;
             },
             _close:function(){
//                debugger;
                $(".msg-box").fadeOut();
             },
             _init:function(){
                    var _this=this;
                    var newMsg=_this._open(_this.template);
                    $(settings.element).prepend(newMsg);
                    $(".msg-box").fadeIn();

                    //文字居中
                    if(settings.position=='center'){
                        $(".msg-box msg-content").addClass("center");
                    }

                    //自动关闭提示框
                    if(settings.autoClose){
                        var closeTimer=setTimeout(function(){
                            _this._close();
                            clearTimeout(closeTimer);
                        },settings.autoClose);
                    }

                    //手动关闭提示框
                    if(!settings.autoClose&&$(".msg-box .icon-close-btn").length>0){
                        $(".msg-box .icon-close-btn").on("click",function(){
                            _this._close();
                        })
                    }


              },
         }
         box._init();
         return box;
    }

})(jQuery);
