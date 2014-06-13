//Completely Static!
var AppData = require('data');
function startapp(){
	Ti.API.info('starting app...');
	var index = Alloy.createController('indexhome').getView();
    index.open();
	//$.tabGroup.open();
    //$.tabGroup.setActiveTab(4); 
    //Alloy.Globals.tabGroup = $.tabGroup;
    
    //
    // Navigation
    //
    // Android
}
if (Alloy.Globals.configureLogin == false){
	//launch app right away if the creator does not want a login.
	Ti.API.info('calling startapp...');
	startapp();
}else{	
	//check login
	Ti.API.info('check if logged in');
	if (! AppData.isLoggedIn()) {
		Ti.API.info('not logged in');
		//do stuff here
	    var loginController = Alloy.createController('login');
	} else {
		Ti.API.info('logged in');
		//do stuff here
		startapp(); 
	};
}

