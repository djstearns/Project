//
// Login stuff
//
var loggedIn = false;

// Check for persisted login
if (Ti.App.Properties.getString('loggedIn')) {
    loggedIn = true;
}

exports.isLoggedIn = function () {
    return loggedIn;
};

exports.login = function(username, password, callback) {
  
        var sendit = Ti.Network.createHTTPClient({
			onerror : function(e) {
				Ti.API.debug(e.error);
				alert('Could not login.');
				//alert(e.error);
				setTimeout(function() {
		            callback({ result: 'not ok' }); 
		        }, 5000);
			},
			timeout : 5000,
		});
		sendit.onload = function() {
			var json = JSON.parse(this.responseText);
			//Ti.API.info(this.responseText+'login response');
			Ti.API.info('message: '+json.message);
			Ti.API.info('token: '+json.token);
			//alert(this.responseText);
			Ti.App.Properties.setString('token',json.token);
			if(json.token != ''){
				loggedIn = true;
       			Ti.App.Properties.setString('loggedIn', 1);
				setTimeout(function() {
		            callback({ result: 'ok' }); 
		        }, 5000); 
			}else{
				setTimeout(function() {
		            callback({ result: 'loaded, but not ok' }); 
		        }, 5000); 
			}
		};
		Ti.API.info('calling '+Alloy.Globals.BASEURL+'users/users/loginjson.json');
		sendit.open('POST', Alloy.Globals.BASEURL+'users/users/loginjson.json');
		sendit.setRequestHeader("Content-Type", "application/json");
		//sendit.setRequestHeader("Content-Type", "application/json");
		sendit.send({"username":username, "passwd":password});
};

exports.logout = function (callback) {
    loggedIn = false;
    Ti.App.Properties.removeProperty('loggedIn'); 
    Ti.App.Properties.removeProperty('token'); 
    callback({ result: 'ok' });
};


//
// App data and methods
//
var dataStore = [];
var dataBuilt = false;

// Delete
exports.deleteItem = function (id) {
    dataStore.splice(id, 1);   
};

// Get
exports.getItem = function (id) {
    return dataStore[id];   
};

// GetAll
exports.getAll = function () {
    return dataStore;
};