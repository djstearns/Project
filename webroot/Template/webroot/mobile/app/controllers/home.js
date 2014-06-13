//Completely Static!
//
// View Language
//
$.tabHome.title = L('home', 'Home');
$.home.title = L('home', 'Home');
$.labelHome.text = L('labelHome', 'Home Label');


//
// Action Handlers
//
function actionLogout() {
    var AppData = require('data');
    AppData.logout(
        function (response) {
            if (response.result === 'ok') {
                // Android close app, iOS open login controller
                //sync at logout here!
                
                if(OS_ANDROID) {
                    var activity = Ti.Android.currentActivity;
                    activity.finish();
                } else {
                    var loginController = Alloy.createController('login');
                    loginController.getView().open();
                    var tg = Alloy.Globals.tabGroup;
                    tg.close();
                    tg=null;
                    Alloy.Globals.tabGroup = null;                       
                }
            } else {
                alert(L('error', 'Error') + ':\n' + response.msg);
            }       
        });
}
////END ACTION HANDLERS @ Home

//
// Navigation
//

// Android
if(OS_ANDROID) {
	//Menu
	    $.home.addEventListener('focus', function() {
	        if($.home.activity) {
	            var activity = Alloy.Globals.tabGroup.activity;
	            
	            // Menu
	            activity.invalidateOptionsMenu();
	            activity.onCreateOptionsMenu = function(e) {
	                var menu = e.menu;
	                if(Alloy.Globals.configureLogin == true){
	                	//add logout action	
		                var menuItem1 = menu.add({
		                    title: L('logout', 'Logout'),
		                    showAsAction: Ti.Android.SHOW_AS_ACTION_NEVER
		                });
		                menuItem1.addEventListener('click', actionLogout);
		            //end logout action
		            };
		            
		            ////
		            //// add other actions to menu at Home here.
		            ////
	            };            
	        }   
	    });

}

// iOS
if (OS_IOS) {
	if(Alloy.Globals.configureLogin == true){
	    var btnRightNav = Ti.UI.createButton({
	       title: L('logout', 'Logout')
	    });
	    btnRightNav.addEventListener('click', actionLogout);
	    $.home.rightNavButton = btnRightNav;
    }
}