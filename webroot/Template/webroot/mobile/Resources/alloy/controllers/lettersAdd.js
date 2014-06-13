function Controller() {
    require("alloy/controllers/BaseController").apply(this, Array.prototype.slice.call(arguments));
    this.__controllerPath = "lettersAdd";
    arguments[0] ? arguments[0]["__parentSymbol"] : null;
    arguments[0] ? arguments[0]["$model"] : null;
    arguments[0] ? arguments[0]["__itemTemplate"] : null;
    var $ = this;
    var exports = {};
    $.thingDetail = Alloy.createModel("Letter");
    $.__views.AddWindow = Ti.UI.createWindow({
        backgroundColor: "white",
        id: "AddWindow"
    });
    $.__views.AddWindow && $.addTopLevelView($.__views.AddWindow);
    $.__views.addView = Ti.UI.createScrollView({
        id: "addView",
        layout: "vertical"
    });
    $.__views.AddWindow.add($.__views.addView);
    $.__views.name = Ti.UI.createTextField({
        width: 200,
        top: 10,
        borderStyle: Ti.UI.INPUT_BORDERSTYLE_ROUNDED,
        autocapitalization: Ti.UI.TEXT_AUTOCAPITALIZATION_NONE,
        id: "name",
        hintText: "name"
    });
    $.__views.addView.add($.__views.name);
    $.__views.savebtn = Ti.UI.createButton({
        top: 10,
        id: "savebtn",
        title: "Save"
    });
    $.__views.addView.add($.__views.savebtn);
    $.__views.cancelbtn = Ti.UI.createButton({
        top: 10,
        id: "cancelbtn",
        title: "Cancel"
    });
    $.__views.addView.add($.__views.cancelbtn);
    var __alloyId45 = function() {
        $.name.value = _.isFunction($.thingDetail.transform) ? $.thingDetail.transform()["name"] : $.thingDetail.get("name");
        $.name.value = _.isFunction($.thingDetail.transform) ? $.thingDetail.transform()["name"] : $.thingDetail.get("name");
    };
    $.thingDetail.on("fetch change destroy", __alloyId45);
    exports.destroy = function() {
        $.thingDetail.off("fetch change destroy", __alloyId45);
    };
    _.extend($, $.__views);
    var modelname = "letters";
    var Modelname = "Letter";
    arguments[0] || {};
    $.savebtn.addEventListener("click", function() {
        globalsave(Alloy.Globals.BASEURL + modelname + "/mobileadd/", {
            name: $.name.value
        }, Modelname, {
            name: $.name.value
        });
        $.AddWindow.close();
    });
    $.cancelbtn.addEventListener("click", function() {
        $.AddWindow.close();
    });
    _.extend($, exports);
}

var Alloy = require("alloy"), Backbone = Alloy.Backbone, _ = Alloy._;

module.exports = Controller;