var loggedIn = false;

Ti.App.Properties.getString("loggedIn") && (loggedIn = true);

exports.isLoggedIn = function() {
    return loggedIn;
};

exports.login = function(username, password, callback) {
    var sendit = Ti.Network.createHTTPClient({
        onerror: function(e) {
            Ti.API.debug(e.error);
            alert("Could not login.");
            setTimeout(function() {
                callback({
                    result: "not ok"
                });
            }, 5e3);
        },
        timeout: 5e3
    });
    sendit.onload = function() {
        var json = JSON.parse(this.responseText);
        Ti.API.info("message: " + json.message);
        Ti.API.info("token: " + json.token);
        Ti.App.Properties.setString("token", json.token);
        if ("" != json.token) {
            loggedIn = true;
            Ti.App.Properties.setString("loggedIn", 1);
            setTimeout(function() {
                callback({
                    result: "ok"
                });
            }, 5e3);
        } else setTimeout(function() {
            callback({
                result: "loaded, but not ok"
            });
        }, 5e3);
    };
    Ti.API.info("calling " + Alloy.Globals.BASEURL + "users/users/loginjson.json");
    sendit.open("POST", Alloy.Globals.BASEURL + "users/users/loginjson.json");
    sendit.setRequestHeader("Content-Type", "application/json");
    sendit.send({
        username: username,
        passwd: password
    });
};

exports.logout = function(callback) {
    loggedIn = false;
    Ti.App.Properties.removeProperty("loggedIn");
    Ti.App.Properties.removeProperty("token");
    callback({
        result: "ok"
    });
};

var dataStore = [];

var dataBuilt = false;

exports.deleteItem = function(id) {
    dataStore.splice(id, 1);
};

exports.getItem = function(id) {
    return dataStore[id];
};

exports.getAll = function() {
    return dataStore;
};