function Controller() {
    require("alloy/controllers/BaseController").apply(this, Array.prototype.slice.call(arguments));
    this.__controllerPath = "register";
    arguments[0] ? arguments[0]["__parentSymbol"] : null;
    arguments[0] ? arguments[0]["$model"] : null;
    arguments[0] ? arguments[0]["__itemTemplate"] : null;
    var $ = this;
    var exports = {};
    $.__views.register = Ti.UI.createWindow({
        backgroundColor: "white",
        id: "register",
        fullscreen: "false"
    });
    $.__views.register && $.addTopLevelView($.__views.register);
    $.__views.registerLabel = Ti.UI.createLabel({
        width: Ti.UI.SIZE,
        height: Ti.UI.SIZE,
        color: "#000",
        id: "registerLabel"
    });
    $.__views.register.add($.__views.registerLabel);
    exports.destroy = function() {};
    _.extend($, $.__views);
    $.register.title = L("register", "Register");
    $.registerLabel.text = L("register", "Register");
    _.extend($, exports);
}

var Alloy = require("alloy"), Backbone = Alloy.Backbone, _ = Alloy._;

module.exports = Controller;