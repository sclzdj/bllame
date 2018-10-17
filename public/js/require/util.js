define(['lodash'],function(_){
    return {
        change:function(){
            require(['jquery'],function ($) {
                $('body').css('backgroundColor','red');
            });
        },
        join:function () {
            alert(_.join(['1', '2', '3'], '-'));
        },
        chunk:function () {
            alert(_.chunk(['a', 'b', 'c', 'd'], 2));
        }
    };
});