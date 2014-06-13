function globalsave(theurl, thedata, modelname, thelocaldata) {
    var sendit = Ti.Network.createHTTPClient({
        onerror: function(e) {
            Ti.API.debug(e.error);
            alert(e.error);
        },
        timeout: 1e3
    });
    sendit.onload = function() {
        var json = JSON.parse(this.responseText);
        Ti.API.info(this.responseText);
        if ("Saved!" == json.message) {
            thelocaldata["id"] = json.id;
            var myModel = Alloy.createModel(modelname, thelocaldata);
            myModel.save();
            Alloy.Collections[modelname].fetch();
        } else alert("There was an error in saving the " + modelname + "record.");
    };
    sendit.open("POST", theurl);
    sendit.send(thedata);
}

function globalserverdelete(tblname, id) {
    var sendit = Ti.Network.createHTTPClient({
        onerror: function(e) {
            Ti.API.debug(e.error);
            alert("There was an error during the connection.  Want to try again?");
        },
        timeout: 1e3
    });
    sendit.open("POST", Alloy.Globals.BASEURL + tblname + "/mobiledelete.json");
    Ti.API.info(Alloy.Globals.BASEURL + tblname + "/mobiledelete");
    sendit.send({
        id: id
    });
    sendit.onload = function() {
        var json = JSON.parse(this.responseText);
        Ti.API.info(json);
        var db = Titanium.Database.open("_alloy_");
        db.execute("DELETE FROM " + tblname + " WHERE id = ?", id);
        db.close();
    };
}

function globaldelete(e, parentTab, modelname, singlename, dataId, manytomanyaddscreen, tblview) {
    if ("" != parentTab) {
        tblview.deleteRow(e.index);
        if ("undefined" != typeof Alloy.Globals.RELATIONSHIP[modelname][manytomanyaddscreen]) globalopenDetail(e, Alloy.Globals.RELATIONSHIP[modelname].sModelname); else {
            var db = Titanium.Database.open("_alloy_");
            var mmtblname = Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].related[modelname].manytomanytblname;
            var rows = db.execute("SELECT id FROM " + mmtblname + " WHERE " + Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename + "_id = ? AND " + singlename + "_id = ?", dataId, e.rowData.dataId);
            Ti.API.info("SELECT id FROM " + mmtblname + " WHERE " + Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename + "_id = " + dataId + " AND " + singlename + "_id = " + e.rowData.dataId);
            1 == rows.getRowCount() ? globalserverdelete(mmtblname, rows.fieldByName("id")) : alert("There is an error in your records. There are " + rows.getRowCount() + " records");
            db.close();
        }
    } else {
        tblview.deleteRow(e.index);
        globalserverdelete(Alloy.Globals.RELATIONSHIP[modelname].tblname, e.rowData.dataId);
    }
}

function globalgetrecords(modelname, Modelname) {
    if (Ti.App.Properties.hasProperty(modelname + "seeded")) {
        var has_added = false;
        if (false == has_added) {
            var newthing = [];
            var sendit = Ti.Network.createHTTPClient({
                onerror: function(e) {
                    Ti.API.debug(e.error);
                    alert("There was an error during the connection to get " + modelname + " records");
                },
                timeout: 1e3
            });
            sendit.open("POST", Alloy.Globals.BASEURL + modelname + "/mobileindex.json");
            sendit.send({
                token: Ti.App.Properties.getString("token")
            });
            sendit.onload = function() {
                Ti.API.info(this.responseText);
                var json = JSON.parse(this.responseText);
                0 == json.length && ($.table.headerTitle = "The database row is empty");
                var records = json;
                for (var i = 0, iLen = records.length; iLen > i; i++) newthing.push(records[i][Modelname]);
                Alloy.Collections[Modelname].reset(newthing);
                Alloy.Collections[Modelname].each(function(_m) {
                    _m.save();
                });
                var things = Alloy.Collections[Modelname];
                things.fetch();
                Ti.App.Properties.setString(modelname + "seeded", "yuppers");
            };
        }
    } else {
        var newthing = [];
        var sendit = Ti.Network.createHTTPClient({
            onerror: function(e) {
                Ti.API.debug(e.error);
                alert("There was an error during the connection to get " + modelname + " records");
            },
            timeout: 1e3
        });
        sendit.open("POST", Alloy.Globals.BASEURL + Alloy.Globals.PLUGIN + modelname + "/mobileindex.json");
        sendit.send({
            token: Ti.App.Properties.getString("token")
        });
        sendit.onload = function() {
            Ti.API.info(this.responseText);
            var json = JSON.parse(this.responseText);
            0 == json.length && ($.table.headerTitle = "The database row is empty");
            var records = json;
            for (var i = 0, iLen = records.length; iLen > i; i++) newthing.push(records[i][Modelname]);
            Alloy.Collections[Modelname].reset(newthing);
            Alloy.Collections[Modelname].each(function(_m) {
                _m.save();
            });
            var things = Alloy.Collections[Modelname];
            things.fetch();
            Ti.App.Properties.setString(modelname + "seeded", "yuppers");
        };
    }
    var things = Alloy.Collections[Modelname];
    things.fetch();
}

function globalopenChild(e, ManyToManys, ManyToMany, hasmultimanytomany, modelname) {
    if (true == hasmultimanytomany) {
        var opts = {
            cancel: ManyToManys.length - 1,
            options: ManyToManys,
            title: "Which Sub Records?"
        };
        var dialog = Ti.UI.createOptionDialog(opts);
        dialog.addEventListener("click", function(evt) {
            if (evt.index != ManyToManys.length - 1) {
                var relationstr = "related";
                var theController = "";
                var isrelated = false;
                if (ManyToManys[evt.index].indexOf(relationstr) >= 0) {
                    theController = ManyToManys[evt.index].replace("related ", "");
                    isrelated = true;
                } else theController = ManyToManys[evt.index];
                var addController = Alloy.createController(theController, {
                    parentTab: Alloy.Globals.tabGroup.getActiveTab(),
                    dataId: e.rowData.dataId,
                    manytomanyaddscreen: modelname,
                    related: isrelated
                });
                var addview = addController.getView();
                var tab = Alloy.Globals.tabGroup.getActiveTab();
                tab.open(addview);
            }
        });
        dialog.show();
    } else {
        var relationstr = "related";
        var theController = "";
        var isrelated = false;
        if (ManyToMany.indexOf(relationstr) >= 0) {
            theController = ManyToMany.replace("related ", "");
            isrelated = true;
        } else theController = ManyToMany;
        var addController = Alloy.createController(theController, {
            parentTab: Alloy.Globals.tabGroup.getActiveTab(),
            dataId: e.rowData.dataId,
            manytomanyaddscreen: modelname,
            related: isrelated
        });
        var addview = addController.getView();
        var tab = Alloy.Globals.tabGroup.getActiveTab();
        tab.open(addview);
    }
}

function globaledittable(e, tblview) {
    if ("Edit" == e.source.title) {
        tblview.editable = false;
        tblview.editing = true;
        tblview.editing = false;
        tblview.editing = true;
        tblview.moving = true;
        e.source.title = "Done";
    } else {
        tblview.editable = true;
        tblview.editing = false;
        tblview.moving = false;
        e.source.title = "Edit";
    }
}

function globalopenAddItem(parentTab, related, modelname, singlename, manytomanyaddscreen, dataId) {
    if ("" != parentTab) if (true == related) {
        Ti.App.addEventListener("changefield", function(e) {
            var db = Titanium.Database.open("_alloy_");
            var mmtblname = Alloy.Globals.RELATIONSHIP[modelname].related[manytomanyaddscreen]["manytomanytblname"];
            db.execute("INSERT INTO " + mmtblname + " (" + Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename + "_id, " + singlename + "_id) Values(?,?)", dataId, e.value);
            db.close();
        });
        var win = Alloy.createController(modelname + "chooser").getView();
        win.open();
    } else {
        var win = Alloy.createController(modelname + "Add").getView();
        win.open();
    } else {
        var win = Alloy.createController(modelname + "Add").getView();
        win.open();
    }
}

function globalopenDetail(_e, Modelname) {
    var things = Alloy.Collections[Modelname];
    var addController = Alloy.createController(Modelname + "detail", {
        parentTab: Alloy.Globals.tabGroup.getActiveTab(),
        dataId: _e.rowData.dataId,
        model: things.get(_e.rowData.dataId)
    });
    var addview = addController.getView();
    var tab = Alloy.Globals.tabGroup.getActiveTab();
    tab.open(addview);
}

var Alloy = require("alloy"), _ = Alloy._, Backbone = Alloy.Backbone;

Alloy.Globals.BASEURL = "http://www.derekstearns.com/croogopluginmkr/";

Alloy.Globals.PLUGIN = "jamiesapp/";

Alloy.Globals.RELATIONSHIP = {
    kids: {
        Modelname: "Kids",
        modelname: "kids",
        singlename: "kid",
        tblname: "kids",
        sModelname: "Kid",
        letters: {
            relation: "BT",
            tblname: "letters",
            Modelname: "Letters",
            modelname: "letters",
            sModelname: "Letter"
        }
    },
    letters: {
        Modelname: "Letters",
        modelname: "letters",
        singlename: "letter",
        tblname: "letters",
        sModelname: "Letter"
    }
};

if (true == Alloy.Globals.LocalDB) {
    Alloy.Collections.Kids = Alloy.createCollection("kid");
    Alloy.Collections.Letters = Alloy.createCollection("letter");
}

Alloy.Globals.LocalDB = true;

Alloy.Globals.SyncAtInstall = false;

Alloy.Globals.AutoSync = true;

Alloy.Globals.SyncFreqOpt = "RUNTIME";

Alloy.Globals.AllowDynAutoSync = true;

Alloy.Globals.DefaultSyncFreqOpt = Alloy.Globals.SyncFreqOpt;

Alloy.Globals.AllowDynSync = true;

Alloy.Globals.configureLogin = true;

Alloy.Globals.testchildren = 3;

Alloy.Globals.Styles = {
    TableViewRow: {
        height: 45
    }
};

Alloy.createController("index");