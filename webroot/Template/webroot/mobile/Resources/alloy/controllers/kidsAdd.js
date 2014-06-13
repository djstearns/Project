function Controller() {
    require("alloy/controllers/BaseController").apply(this, Array.prototype.slice.call(arguments));
    this.__controllerPath = "kidsAdd";
    arguments[0] ? arguments[0]["__parentSymbol"] : null;
    arguments[0] ? arguments[0]["$model"] : null;
    arguments[0] ? arguments[0]["__itemTemplate"] : null;
    var $ = this;
    var exports = {};
    $.thingDetail = Alloy.createModel("Kid");
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
    $.__views.age = Ti.UI.createTextField({
        width: 200,
        top: 10,
        borderStyle: Ti.UI.INPUT_BORDERSTYLE_ROUNDED,
        autocapitalization: Ti.UI.TEXT_AUTOCAPITALIZATION_NONE,
        id: "age",
        hintText: "age"
    });
    $.__views.addView.add($.__views.age);
    $.__views.letter_id = Ti.UI.createTextField({
        width: 200,
        top: 10,
        borderStyle: Ti.UI.INPUT_BORDERSTYLE_ROUNDED,
        autocapitalization: Ti.UI.TEXT_AUTOCAPITALIZATION_NONE,
        id: "letter_id"
    });
    $.__views.addView.add($.__views.letter_id);
    $.__views.lettername = Ti.UI.createTextField({
        width: 200,
        top: 10,
        borderStyle: Ti.UI.INPUT_BORDERSTYLE_ROUNDED,
        autocapitalization: Ti.UI.TEXT_AUTOCAPITALIZATION_NONE,
        id: "lettername"
    });
    $.__views.addView.add($.__views.lettername);
    $.__views.pickletter = Ti.UI.createButton({
        top: 10,
        title: "letter",
        id: "pickletter"
    });
    $.__views.addView.add($.__views.pickletter);
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
    var __alloyId17 = function() {
        $.name.value = _.isFunction($.thingDetail.transform) ? $.thingDetail.transform()["name"] : $.thingDetail.get("name");
        $.name.value = _.isFunction($.thingDetail.transform) ? $.thingDetail.transform()["name"] : $.thingDetail.get("name");
        $.age.value = _.isFunction($.thingDetail.transform) ? $.thingDetail.transform()["age"] : $.thingDetail.get("age");
        $.age.value = _.isFunction($.thingDetail.transform) ? $.thingDetail.transform()["age"] : $.thingDetail.get("age");
        $.letter_id.value = _.isFunction($.thingDetail.transform) ? $.thingDetail.transform()["letter_id"] : $.thingDetail.get("letter_id");
        $.letter_id.value = _.isFunction($.thingDetail.transform) ? $.thingDetail.transform()["letter_id"] : $.thingDetail.get("letter_id");
    };
    $.thingDetail.on("fetch change destroy", __alloyId17);
    exports.destroy = function() {
        $.thingDetail.off("fetch change destroy", __alloyId17);
    };
    _.extend($, $.__views);
    var modelname = "kids";
    var Modelname = "Kid";
    arguments[0] || {};
    $.savebtn.addEventListener("click", function() {
        globalsave(Alloy.Globals.BASEURL + modelname + "/mobileadd/", {
            name: $.name.value,
            age: $.age.value,
            letter_id: $.letter_id.value
        }, Modelname, {
            name: $.name.value,
            age: $.age.value,
            letter_id: $.letter_id.value
        });
        $.AddWindow.close();
    });
    Ti.App.addEventListener("changeletterfield", function(e) {
        $.letter_id.value = e.value;
        $.letter.value = e.title;
    });
    $.pickletter.addEventListener("click", function() {
        var win = Alloy.createController("letterschooser").getView();
        win.open();
    });
    $.cancelbtn.addEventListener("click", function() {
        $.AddWindow.close();
    });
    _.extend($, exports);
}

var Alloy = require("alloy"), Backbone = Alloy.Backbone, _ = Alloy._;

module.exports = Controller;