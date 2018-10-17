function laydate_range(start, end) {
    require(['jquery'], function ($) {
        if (start === undefined) {
            start = '#created_at_start';
        }
        if (end === undefined) {
            end = '#created_at_end';
        }
        layui.use('laydate', function () {
            var laydate = layui.laydate;
            //执行一个laydate实例
            laydate.render({
                elem: start, //指定元素
                max: 0 //限制在今天之前
            });
        });
        layui.use('laydate', function () {
            var laydate = layui.laydate;
            //执行一个laydate实例
            laydate.render({
                elem: end //指定元素
            });
        });
    });
}

function layvue_form(laydata, other) {
    // if (other === undefined) {
    //     other = {id: "#app"};
    // } else if (other.id === undefined) {
    //     other.id = "#app";
    // }
    // require(['vue'], function (Vue) {
    //     new Vue({
    //         el: other.id,
    //         data: {
    //             laydata: laydata
    //         },
    //         mounted: function () {
    //             this.layrun();
    //         },
    //         methods: {
    //             layrun: function () {//监听表单layer表单变化
    //                 var _this = this;
    //                 this.$nextTick(function () {
    //                     layui.use('form', function () {
    //                         var form = layui.form;
    //                         require(['jquery'], function ($) {
    //                             $.each(_this.laydata, function (k, v) {
    //                                 form.on(v.type + '(' + v.layFilter + ')', function (da) {
    //                                     switch (v.sku) {
    //                                         case 'value':
    //                                             _this.laydata[k].value = da.value;
    //                                             break;
    //                                         case 'boolean':
    //                                             _this.laydata[k].value = da.elem.checked;
    //                                             break;
    //                                         case 'array':
    //                                             if (da.elem.checked) {
    //                                                 _this.laydata[k].value.push(da.value);
    //                                                 _this.laydata[k].value.sort(function(a,b){
    //                                                     return a-b;
    //                                                 });
    //                                             } else {
    //                                                 var index = _this.laydata[k].value.indexOf(da.value);
    //                                                 if (index >= 0) {
    //                                                     _this.laydata[k].value.splice(index, 1);
    //                                                 }
    //                                             }
    //                                             break;
    //                                         default:
    //                                             break;
    //                                     }
    //                                     //是否全选
    //                                     if ((other.all !== undefined && other.ids !== undefined) && (k == other.all || k == other.ids)) {
    //                                         var ids = [];
    //                                         $(other.id+' input[lay-filter="' + _this.laydata[other.ids].layFilter + '"]').each(function () {
    //                                             ids.push($(this).val());
    //                                         });
    //                                         if (k == other.all) {
    //                                             if (_this.laydata[k].value) {
    //                                                 _this.laydata[other.ids].value = ids;
    //                                                 $(other.id+' input[lay-filter="' + _this.laydata[other.ids].layFilter + '"]').prop('checked', true);
    //                                                 $(other.id+' input[lay-filter="' + _this.laydata[other.ids].layFilter + '"]').next('.layui-form-checkbox').addClass('layui-form-checked');
    //                                             } else {
    //                                                 _this.laydata[other.ids].value = [];
    //                                                 $(other.id+' input[lay-filter="' + _this.laydata[other.ids].layFilter + '"]').prop('checked', false);
    //                                                 $(other.id+' input[lay-filter="' + _this.laydata[other.ids].layFilter + '"]').next('.layui-form-checkbox').removeClass('layui-form-checked');
    //                                             }
    //                                         }else{
    //                                             if (_this.laydata[other.ids].value.slice(0,10).length==ids.slice(0,10).length) {
    //                                                 _this.laydata[other.all].value = true;
    //                                                 $(other.id+' input[lay-filter="' + _this.laydata[other.all].layFilter + '"]').prop('checked', true);
    //                                                 $(other.id+' input[lay-filter="' + _this.laydata[other.all].layFilter + '"]').next('.layui-form-checkbox').addClass('layui-form-checked');
    //                                             } else {
    //                                                 _this.laydata[other.all].value = false;
    //                                                 $(other.id+' input[lay-filter="' + _this.laydata[other.all].layFilter + '"]').prop('checked', false);
    //                                                 $(other.id+' input[lay-filter="' + _this.laydata[other.all].layFilter + '"]').next('.layui-form-checkbox').removeClass('layui-form-checked');
    //                                             }
    //                                         }
    //                                     }
    //                                 });
    //                             });
    //                         });
    //                         form.render();
    //                     });
    //                 });
    //             }
    //         }
    //     });
    // });
}