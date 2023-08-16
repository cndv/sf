define([], function () {
    require.config({
    paths: {
        'litestorefreight_delivery': '../addons/litestore/js/litestorefreight_delivery',
        'litestorefreight_regionalChoice': '../addons/litestore/js/litestorefreight_regionalChoice',
        'litestoregoods': '../addons/litestore/js/litestoregoods',
    },
});
if (Config.modulename === 'index' && Config.controllername === 'user' && ['login', 'register'].indexOf(Config.actionname) > -1 && $("#register-form,#login-form").length > 0 && $(".social-login").length == 0) {
    $("#register-form,#login-form").append(Config.third.loginhtml || '');
}

});