$(function () {
    sidebarHighLight();
});



//侧边栏高亮
function sidebarHighLight() {
    var curId=getQueryString('id');
    var curUrl=window.location.href.split("?")[0].split("/");
    var curPage=curUrl[curUrl.length-1];
    $("#"+curPage+" a").each(function (index,item) {
        if(item.getAttribute('data-params-id')==curId){
            $(this).addClass("active");
            return;
        }
    });
}



//获取url参数
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]);
    return null;
}

