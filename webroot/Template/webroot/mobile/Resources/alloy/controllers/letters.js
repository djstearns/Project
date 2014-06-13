function Controller() {
    function __alloyId39() {
        __alloyId39.opts || {};
        var models = __alloyId38.models;
        var len = models.length;
        var rows = [];
        for (var i = 0; len > i; i++) {
            var __alloyId36 = models[i];
            __alloyId36.__transform = {};
            var __alloyId37 = Ti.UI.createTableViewRow({
                dataId: "undefined" != typeof __alloyId36.__transform["id"] ? __alloyId36.__transform["id"] : __alloyId36.get("id"),
                title: "undefined" != typeof __alloyId36.__transform["name"] ? __alloyId36.__transform["name"] : __alloyId36.get("name")
            });
            rows.push(__alloyId37);
        }
        $.__views.tblview.setData(rows);
    }
    function deleterecord(e) {
        globaldelete(e, parentTab, modelname, singlename, dataId, manytomanyaddscreen, $.tblview);
        Ti.API.info("e_id:" + e.rowData.dataId);
    }
    function editmany(e) {
        if ("" != parentTab) {
            var checkarray = Alloy.Globals.RELATIONSHIP[tblname];
            var mmtblname = "";
            var mmModelname = "";
            Ti.API.info(checkarray);
            if ("undefined" != typeof Alloy.Globals.RELATIONSHIP[tblname][manytomanyaddscreen]) {
                mmModelname = Alloy.Globals.RELATIONSHIP[tblname].sModelname;
                globalopenDetail(e, mmModelname);
            } else {
                mmtblname = Alloy.Globals.RELATIONSHIP[tblname].related[manytomanyaddscreen].manytomanytblname;
                mmModelname = Alloy.Globals.RELATIONSHIP[tblname].related[manytomanyaddscreen].manytomanyModelname;
                var db = Titanium.Database.open("_alloy_");
                var rows = db.execute("SELECT id FROM " + mmtblname + " WHERE " + Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename + "_id = ? AND " + singlename + "_id = ?", dataId, e.rowData.dataId);
                if (1 == rows.getRowCount()) {
                    var ythings = Alloy.Collections[mmModelname];
                    ythings.fetch();
                    var addController = Alloy.createController(mmtblname + "Edit", {
                        parentTab: Alloy.Globals.tabGroup.getActiveTab(),
                        dataId: rows.fieldByName("id"),
                        model: ythings.get(rows.fieldByName("id"))
                    });
                    var addview = addController.getView();
                    var tab = Alloy.Globals.tabGroup.getActiveTab();
                    tab.open(addview);
                    db.close();
                } else alert("Error: you have duplicate records!");
            }
        } else globalopenDetail(e, Modelname);
    }
    function myLoader(e) {
        var ln = things.models.length;
        Ti.API.info(ln);
        var newthing = [];
        var sendit = Ti.Network.createHTTPClient({
            onerror: function(e) {
                Ti.API.debug(e.error);
                alert("There was an error during the connection");
            },
            timeout: 1e3
        });
        var lnstr = ln / 20 + 1;
        sendit.open("GET", Alloy.Globals.BASEURL + modelname + "/page:" + lnstr.toString());
        sendit.send();
        sendit.onload = function() {
            var json = JSON.parse(this.responseText);
            0 == json.length && ($.table.headerTitle = "The database row is empty");
            var records = json;
            for (var i = 0, iLen = records.length; iLen > i; i++) newthing.push(records[i][Modelname]);
            Alloy.Collections[Modelname].reset(newthing);
            Alloy.Collections[Modelname].each(function(_m) {
                _m.save();
            });
            var things = Alloy.Collections[Modelname];
            things.fetch({
                data: {
                    offset: ln
                },
                add: true,
                silent: true,
                success: function(col) {
                    Ti.API.info("successful here");
                    col.models.length === ln ? e.done() : e.success();
                },
                error: e.error
            });
        };
    }
    require("alloy/controllers/BaseController").apply(this, Array.prototype.slice.call(arguments));
    this.__controllerPath = "letters";
    arguments[0] ? arguments[0]["__parentSymbol"] : null;
    arguments[0] ? arguments[0]["$model"] : null;
    arguments[0] ? arguments[0]["__itemTemplate"] : null;
    var $ = this;
    var exports = {};
    var __defers = {};
    Alloy.Collections.instance("Letter");
    $.__views.tblviewWindow = Ti.UI.createWindow({
        backgroundColor: "white",
        id: "tblviewWindow"
    });
    $.__views.tblviewWindow && $.addTopLevelView($.__views.tblviewWindow);
    $.__views.editme = Ti.UI.createButton({
        top: 10,
        title: "Edit",
        id: "editme"
    });
    $.__views.tblviewWindow.rightNavButton = $.__views.editme;
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
    $.__views.__alloyId34 = Ti.UI.createSearchBar({
        id: "__alloyId34"
    });
    $.__views.tblview = Ti.UI.createTableView({
        height: Ti.UI.SIZE,
        top: 0,
        search: $.__views.__alloyId34,
        searchHidden: "true",
        id: "tblview",
        moveable: "true",
        editable: "true",
        filterAttribute: "title"
    });
    $.__views.tblviewWindow.add($.__views.tblview);
    $.__views.is = Alloy.createWidget("nl.fokkezb.infiniteScroll", "widget", {
        id: "is",
        __parentSymbol: $.__views.tblview
    });
    $.__views.is.setParent($.__views.tblview);
    myLoader ? $.__views.is.on("end", myLoader) : __defers["$.__views.is!end!myLoader"] = true;
    var __alloyId38 = Alloy.Collections["Letter"] || Letter;
    __alloyId38.on("fetch destroy change add remove reset", __alloyId39);
    var __alloyId42 = [];
    $.__views.camera = Ti.UI.createButton({
        top: 10,
        id: "camera",
        systemButton: Ti.UI.iPhone.SystemButton.CAMERA
    });
    __alloyId42.push($.__views.camera);
    $.__views.__alloyId43 = Ti.UI.createButton({
        systemButton: Ti.UI.iPhone.SystemButton.FLEXIBLE_SPACE
    });
    __alloyId42.push($.__views.__alloyId43);
    $.__views.refresh = Ti.UI.createButton({
        top: 10,
        id: "refresh",
        systemButton: Titanium.UI.iPhone.SystemButton.REFRESH
    });
    __alloyId42.push($.__views.refresh);
    $.__views.__alloyId44 = Ti.UI.createButton({
        systemButton: Ti.UI.iPhone.SystemButton.FLEXIBLE_SPACE
    });
    __alloyId42.push($.__views.__alloyId44);
    $.__views.addbtn = Ti.UI.createButton({
        top: 10,
        id: "addbtn",
        systemButton: Titanium.UI.iPhone.SystemButton.ADD
    });
    __alloyId42.push($.__views.addbtn);
    $.__views.__alloyId40 = Ti.UI.iOS.createToolbar({
        items: __alloyId42,
        bottom: "0",
        borderTop: "true",
        borderBottom: "false",
        id: "__alloyId40"
    });
    $.__views.tblviewWindow.add($.__views.__alloyId40);
    exports.destroy = function() {
        __alloyId38.off("fetch destroy change add remove reset", __alloyId39);
    };
    _.extend($, $.__views);
    var singlename = "letter";
    var modelname = "letters";
    var Modelname = "Letter";
    var tblname = "letters";
    var ManyToManys = "";
    var ManyToMany = "";
    var hasmultimanytomany = false;
    var args = arguments[0] || {};
    var parentTab = args.parentTab || "";
    var manytomanyaddscreen = args.manytomanyaddscreen;
    var related = args.related;
    var dataId = 0 === args.dataId || args.dataId > 0 ? args.dataId : "";
    $.addbtn.addEventListener("click", function() {
        globalopenAddItem(parentTab, related, modelname, singlename, manytomanyaddscreen, dataId);
    });
    $.refresh.addEventListener("click", function() {
        globalgetrecords(modelname, Modelname);
    });
    $.editme.addEventListener("click", function(e) {
        globaledittable(e, $.tblview);
    });
    $.tblview.addEventListener("delete", function(e) {
        deleterecord(e);
    });
    $.tblview.addEventListener("longpress", function(e) {
        globalopenDetail(e, Modelname);
    });
    var things = Alloy.Collections[Modelname];
    things.fetch();
    globalgetrecords(modelname, Modelname);
    $.tblview.addEventListener("click", function(e) {
        "" != parentTab ? editmany(e) : globalopenChild(e, ManyToManys, ManyToMany, hasmultimanytomany, modelname, parentTab);
    });
    $.tblviewWindow.addEventListener("focus", function() {
        if ("" != parentTab) {
            Ti.API.info("args not empty!");
            var things = Alloy.Collections[Modelname];
            var db = Titanium.Database.open("_alloy_");
            if (true == related) {
                var mmtblname = Alloy.Globals.RELATIONSHIP[modelname].related[manytomanyaddscreen].manytomanytblname;
                var rows = db.execute("SELECT " + singlename + "_id FROM " + mmtblname + " WHERE " + Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename + "_id = ?", dataId);
                if (0 != rows.rowCount) {
                    var str = "";
                    while (rows.isValidRow()) {
                        str = str + rows.fieldByName(singlename + "_id") + ",";
                        rows.next();
                    }
                    db.close();
                    str = str.substring(0, str.length - 1) + ")";
                    things.fetch({
                        query: "SELECT * FROM " + tblname + " WHERE id IN (" + str
                    });
                } else {
                    things.fetch({
                        query: "SELECT * from " + mmtblname + " WHERE id = 0;"
                    });
                    $.tblview.headerTitle = "The database row is empty";
                }
            } else things.fetch({
                query: "SELECT * FROM " + tblname + " WHERE " + Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename + "_id =" + dataId
            });
        } else {
            Ti.API.info("args empty!");
            var things = Alloy.Collections[Modelname];
            things.fetch();
        }
    });
    __defers["$.__views.is!end!myLoader"] && $.__views.is.on("end", myLoader);
    _.extend($, exports);
}

var Alloy = require("alloy"), Backbone = Alloy.Backbone, _ = Alloy._;

module.exports = Controller;