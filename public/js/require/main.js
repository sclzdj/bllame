require.config({
    baseUrl: GB_HOST + 'js/require/',
    paths: {
        'css': 'libs/css.min',
        'jquery': 'libs/jquery.min',
        'jquery-ui': 'libs/jquery-ui.min',
        'jquery-pjax': 'libs/jquery-pjax.min',
        'vue': 'libs/vue.min',
        'lodash': 'libs/lodash.min',
        'util': 'util',
        'function': 'function',
    },
    shim: {
        'jquery-ui': {
            'deps': ['css!../../css/jquery-ui.min.css','jquery']
        },
        'jquery-pjax': {
            'deps': ['css!../../css/pjax.css','jquery']
        },
        'function': {
            'init': function () {
                return {
                    laydate_range: laydate_range,
                    layvue_form: layvue_form
                };
            }
        }
    }
});