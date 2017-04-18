/**
 * Created by pumbf on 2017/4/17.
 */
var bootStrap = function () {
    return {
        init: function () {
            $("[name='my-checkbox']").bootstrapSwitch();
            $("[data-opereate='delete']").on('click',function(){

            });
        }
    };
};
