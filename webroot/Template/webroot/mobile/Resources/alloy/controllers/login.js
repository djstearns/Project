function Controller() {
    require("alloy/controllers/BaseController").apply(this, Array.prototype.slice.call(arguments));
    this.__controllerPath = "login";
    arguments[0] ? arguments[0]["__parentSymbol"] : null;
    arguments[0] ? arguments[0]["$model"] : null;
    arguments[0] ? arguments[0]["__itemTemplate"] : null;
    var $ = this;
    var exports = {};
    $.__views.login = Ti.UI.createWindow({
        backgroundColor: "white",
        id: "login"
    });
    $.__views.login && $.addTopLevelView($.__views.login);
    $.__views.loginForm = Alloy.createController("login_form", {
        id: "loginForm"
    });
    $.__views.navgroup = Ti.UI.iPhone.createNavigationGroup({
        window: $.__views.loginForm.getViewEx({
            recurse: true
        }),
        id: "navgroup"
    });
    $.__views.login.add($.__views.navgroup);
    exports.destroy = function() {};
    _.extend($, $.__views);
    Alloy.Globals.navgroup = $.navgroup;
    Alloy.Globals.loginwin = $.login;
    $.login.open();
    _.extend($, exports);
}

var Alloy = require("alloy"), Backbone = Alloy.Backbone, _ = Alloy._;

module.exports = Controller;