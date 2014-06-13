if (OS_IOS) {
    Alloy.Globals.navgroup = $.navgroup;
    Alloy.Globals.loginwin = $.login;  
    $.login.open();
} else if (OS_ANDROID) {
    $.loginForm.getView().open();
} else {
    alert(L('unsupportedPlatform', 'Unsupported Platform'));
}