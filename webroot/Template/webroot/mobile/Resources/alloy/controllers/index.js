function Controller() {
    function startapp() {
        Ti.API.info("starting app...");
        var index = Alloy.createController("indexhome").getView();
        index.open();
    }
    require("alloy/controllers/BaseController").apply(this, Array.prototype.slice.call(arguments));
    this.__controllerPath = "index";
    arguments[0] ? arguments[0]["__parentSymbol"] : null;
    arguments[0] ? arguments[0]["$model"] : null;
    arguments[0] ? arguments[0]["__itemTemplate"] : null;
    var $ = this;
    var exports = {};
    exports.destroy = function() {};
    _.extend($, $.__views);
    var AppData = require("data");
    if (false == Alloy.Globals.configureLogin) {
        Ti.API.info("calling startapp...");
        startapp();
    } else {
        Ti.API.info("check if logged in");
        if (AppData.isLoggedIn()) {
            Ti.API.info("logged in");
            startapp();
        } else {
            Ti.API.info("not logged in");
            Alloy.createController("login");
        }
    }
    _.extend($, exports);
}

var Alloy = require("alloy"), Backbone = Alloy.Backbone, _ = Alloy._;

module.exports = Controller;