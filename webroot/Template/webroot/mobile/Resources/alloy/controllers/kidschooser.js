function Controller() {
    function __alloyId24() {
        __alloyId24.opts || {};
        var models = __alloyId23.models;
        var len = models.length;
        var rows = [];
        for (var i = 0; len > i; i++) {
            var __alloyId21 = models[i];
            __alloyId21.__transform = {};
            var __alloyId22 = Ti.UI.createTableViewRow({
                dataId: "undefined" != typeof __alloyId21.__transform["id"] ? __alloyId21.__transform["id"] : __alloyId21.get("id"),
                model: "undefined" != typeof __alloyId21.__transform["alloy_id"] ? __alloyId21.__transform["alloy_id"] : __alloyId21.get("alloy_id"),
                title: "undefined" != typeof __alloyId21.__transform["name"] ? __alloyId21.__transform["name"] : __alloyId21.get("name")
            });
            rows.push(__alloyId22);
        }
        $.__views.tblview.setData(rows);
    }
    require("alloy/controllers/BaseController").apply(this, Array.prototype.slice.call(arguments));
    this.__controllerPath = "kidschooser";
    arguments[0] ? arguments[0]["__parentSymbol"] : null;
    arguments[0] ? arguments[0]["$model"] : null;
    arguments[0] ? arguments[0]["__itemTemplate"] : null;
    var $ = this;
    var exports = {};
    Alloy.Collections.instance("Kid");
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
    $.__views.__alloyId20 = Ti.UI.createSearchBar({
        id: "__alloyId20"
    });
    $.__views.tblview = Ti.UI.createTableView({
        height: Ti.UI.SIZE,
        top: 0,
        search: $.__views.__alloyId20,
        id: "tblview",
        editable: "true",
        filterAttribute: "title"
    });
    $.__views.tblviewWindow.add($.__views.tblview);
    var __alloyId23 = Alloy.Collections["Kid"] || Kid;
    __alloyId23.on("fetch destroy change add remove reset", __alloyId24);
    var __alloyId27 = [];
    $.__views.__alloyId28 = Ti.UI.createButton({
        systemButton: Ti.UI.iPhone.SystemButton.FLEXIBLE_SPACE
    });
    __alloyId27.push($.__views.__alloyId28);
    $.__views.cancel = Ti.UI.createButton({
        top: 10,
        id: "cancel",
        systemButton: Titanium.UI.iPhone.SystemButton.CANCEL
    });
    __alloyId27.push($.__views.cancel);
    $.__views.__alloyId29 = Ti.UI.createButton({
        systemButton: Ti.UI.iPhone.SystemButton.FLEXIBLE_SPACE
    });
    __alloyId27.push($.__views.__alloyId29);
    $.__views.__alloyId25 = Ti.UI.iOS.createToolbar({
        items: __alloyId27,
        bottom: "0",
        borderTop: "true",
        borderBottom: "false",
        id: "__alloyId25"
    });
    $.__views.tblviewWindow.add($.__views.__alloyId25);
    exports.destroy = function() {
        __alloyId23.off("fetch destroy change add remove reset", __alloyId24);
    };
    _.extend($, $.__views);
    var Modelname = "Kid";
    $.tblview.addEventListener("click", function(e) {
        Ti.App.fireEvent("changekidfield", {
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