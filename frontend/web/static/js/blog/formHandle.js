$(function () {

    var formHandle = {

        //为当前选择的单选框添加checked        
        radioFocus: function () {
            // $("input:radio:first").attr("checked", true);
            $("input:radio:first").closest("label").addClass("checked");
            $("input:radio").click(function () {
                // $("input:radio").removeAttr("checked");
                $(this).attr("checked", true).closest("label").addClass("checked").siblings().removeClass("checked");
            })
        },

        checkboxFocus: function () {
            // $("input:checkbox:first").attr("checked", true);
            $("input:checkbox:first").closest("label").toggleClass("checked");
            $("input:checkbox").click(function () {
                $(this).closest("label").toggleClass("checked");
            })

        },


        init: function () {
            formHandle.radioFocus();
            formHandle.checkboxFocus();
        }

    }

    formHandle.init();
})