function Controller() {
    require("alloy/controllers/BaseController").apply(this, Array.prototype.slice.call(arguments));
    this.__controllerPath = "indexhome";
    arguments[0] ? arguments[0]["__parentSymbol"] : null;
    arguments[0] ? arguments[0]["$model"] : null;
    arguments[0] ? arguments[0]["__itemTemplate"] : null;
    var $ = this;
    var exports = {};
    $.__views.tabGroup = Ti.UI.createTabGroup({
        id: "tabGroup"
    });
    $.__views.tabHome = Alloy.createController("home", {
        id: "tabHome"
    });
    $.__views.tabGroup.addTab($.__views.tabHome.getViewEx({
        recurse: true
    }));
    $.__views.recipestable = Alloy.createController("letters", {
        id: "recipestable"
    });
    $.__views.recipestab = Ti.UI.createTab({
        window: $.__views.recipestable.getViewEx({
            recurse: true
        }),
        title: "Letters",
        icon: "KS_nav_ui.png",
        id: "recipestab"
    });
    $.__views.tabGroup.addTab($.__views.recipestab);
    $.__views.items = Alloy.createController("kids", {
        id: "items"
    });
    $.__views.recipestab = Ti.UI.createTab({
        window: $.__views.items.getViewEx({
            recurse: true
        }),
        title: "Kids",
        icon: "KS_nav_ui.png",
        id: "recipestab"
    });
    $.__views.tabGroup.addTab($.__views.recipestab);
    $.__views.tabGroup && $.addTopLevelView($.__views.tabGroup);
    exports.destroy = function() {};
    _.extend($, $.__views);
    Alloy.Globals.tabGroup = $.tabGroup;
    _.extend($, exports);
}

var Alloy = require("alloy"), Backbone = Alloy.Backbone, _ = Alloy._;

module.exports = Controller;