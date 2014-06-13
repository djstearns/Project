function Controller() {
    function __alloyId52() {
        __alloyId52.opts || {};
        var models = __alloyId51.models;
        var len = models.length;
        var rows = [];
        for (var i = 0; len > i; i++) {
            var __alloyId49 = models[i];
            __alloyId49.__transform = {};
            var __alloyId50 = Ti.UI.createTableViewRow({
                dataId: "undefined" != typeof __alloyId49.__transform["id"] ? __alloyId49.__transform["id"] : __alloyId49.get("id"),
                model: "undefined" != typeof __alloyId49.__transform["alloy_id"] ? __alloyId49.__transform["alloy_id"] : __alloyId49.get("alloy_id"),
                title: "undefined" != typeof __alloyId49.__transform["name"] ? __alloyId49.__transform["name"] : __alloyId49.get("name")
            });
            rows.push(__alloyId50);
        }
        $.__views.tblview.setData(rows);
    }
    require("alloy/controllers/BaseController").apply(this, Array.prototype.slice.call(arguments));
    this.__controllerPath = "letterschooser";
    arguments[0] ? arguments[0]["__parentSymbol"] : null;
    arguments[0] ? arguments[0]["$model"] : null;
    arguments[0] ? arguments[0]["__itemTemplate"] : null;
    var $ = this;
    var exports = {};
    Alloy.Collections.instance("Letter");
    $.__views.tblviewWindow = Ti.UI.createWindow({
        backgroundColor: "white",
        id: "tblviewWindow"
    });
    $.__views.tblviewWindow && $.addTopLevelView($.__views.tblviewWindow);
    $.__views.activityIndicator = Ti.UI.createActivityIndicator({
        height: Ti.UI.SIZE,
        width: Ti.UI.SIZE,
        top: 20,
        style: Ti.UI.iPhone.ActivityIndicatorStyle.DARK,
        id: "activityIndicator"
    });
    $.__views.tblviewWindow.add($.__views.activityIndicator);
    $.__views.labelNoRecords = Ti.UI.createLabel({
        width: Ti.UI.SIZE,
        height: Ti.UI.SIZE,
        color: "#000",
        visible: false,
        top: 20,
        id: "labelNoRecords"
    });
    $.__views.tblviewWindow.add($.__views.labelNoRecords);
    $.__views.__alloyId48 = Ti.UI.createSearchBar({
        id: "__alloyId48"
    });
    $.__views.tblview = Ti.UI.createTableView({
        height: Ti.UI.SIZE,
        top: 0,
        search: $.__views.__alloyId48,
        id: "tblview",
        editable: "true",
        filterAttribute: "title"
    });
    $.__views.tblviewWindow.add($.__views.tblview);
    var __alloyId51 = Alloy.Collections["Letter"] || Letter;
    __alloyId51.on("fetch destroy change add remove reset", __alloyId52);
    var __alloyId55 = [];
    $.__views.__alloyId56 = Ti.UI.createButton({
        systemButton: Ti.UI.iPhone.SystemButton.FLEXIBLE_SPACE
    });
    __alloyId55.push($.__views.__alloyId56);
    $.__views.cancel = Ti.UI.createButton({
        top: 10,
        id: "cancel",
        systemButton: Titanium.UI.iPhone.SystemButton.CANCEL
    });
    __alloyId55.push($.__views.cancel);
    $.__views.__alloyId57 = Ti.UI.createButton({
        systemButton: Ti.UI.iPhone.SystemButton.FLEXIBLE_SPACE
    });
    __alloyId55.push($.__views.__alloyId57);
    $.__views.__alloyId53 = Ti.UI.iOS.createToolbar({
        items: __alloyId55,
        bottom: "0",
        borderTop: "true",
        borderBottom: "false",
        id: "__alloyId53"
    });
    $.__views.tblviewWindow.add($.__views.__alloyId53);
    exports.destroy = function() {
        __alloyId51.off("fetch destroy change add remove reset", __alloyId52);
    };
    _.extend($, $.__views);
    var Modelname = "Letter";
    $.tblview.addEventListener("click", function(e) {
        Ti.App.fireEvent("changeletterfield", {
            value: e.rowData.dataId,
            title: e.rowData.title
        });
        $.tblviewWindow.close();
    });
    $.cancel.addEventListener("click", function() {
        $.tblviewWindow.close();
    });
    var things = Alloy.Collections[Modelname];
    things.fetch();
    _.extend($, exports);
}

var Alloy = require("alloy"), Backbone = Alloy.Backbone, _ = Alloy._;

module.exports = Controller;