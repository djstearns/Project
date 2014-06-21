//
// Action handlers
//
function actionLogin(e) {
	//check fields
    if (! $.inputUsername.value || ! $.inputPassword.value) {
        var dialog = Ti.UI.createAlertDialog({
            message: L('formMissingFields', 'Please complete all form fields'),
            ok: 'OK',
            title: L('actionRequired', 'Action Required')
        }).show();
    }else {
    	//fields are ok
        $.activityIndicator.show();
        $.buttonLogin.enabled = false;
		//load functions
        var AppData = require('data');
        
        AppData.login($.inputUsername.value, $.inputPassword.value,
            function(response) {
                $.activityIndicator.hide();
                $.buttonLogin.enabled = true;
				
                if (response.result === 'ok') {
                   //do syncing at login here! (maybe launch an updator?)
                   //get all many to many relations here!!!
                   //getworkerswidgets();
                   
                    var index = Alloy.createController('indexhome').getView();
                    index.open();
                    
                    
                    if (OS_IOS) {
                    	//var loginwin = Alloy.Globals.loginwin;
	                    //loginwin.close();
	                    //Alloy.Globals.loginwin =  null;
                        var navgroup = Alloy.Globals.navgroup;
                        navgroup.close();
                        navgroup = null;
                        Alloy.Globals.navgroup = null;   
                    } else if (OS_ANDROID) {
                        $.loginForm.close();
                        $.loginForm = null;
                    }                 
                } else {
                    $.inputPassword.value = '';
                    alert(L('error', 'Error') + ':\n' + response.msg);
                }
            });
    }
}

function openRegister(e) {
    var registerController = Alloy.createController('register').getView();
    if (OS_IOS) {
        Alloy.Globals.navgroup.open(registerController);   
    } else if (OS_ANDROID) {
        registerController.open();
    }
}


/*
function getworkerswidgets(Modelname, tablename){
	Alloy.Collections.WorkersWidgets = Alloy.createCollection("kid");//Recipes Yingredient
                   
	//determine if the database needs to be seeded
	//if (!Ti.App.Properties.hasProperty('seeded')) {
		Ti.API.info('Getting workers widgets');
		var newthing = [];
		var data = [];
		var sendit = Ti.Network.createHTTPClient({
			
			onerror : function(e) {
				Ti.API.debug(e.error);
				
				alert('There was an error during the connection for workerswidgets');
				//getworkerswidgets();
			},
			timeout : 1000,
		});
		sendit.open('POST', Alloy.Globals.BASEURL+Alloy.Globals.PLUGIN+'Kids/mobileindex.json');
		//Ti.API.info(Ti.App.Properties.getString('token'));
		sendit.send({'token':Ti.App.Properties.getString('token')});
		sendit.onload = function() {
			var json = JSON.parse(this.responseText);
			// if the database is empty show an alert
			if (json.length == 0) {
				$.table.headerTitle = "The database row is empty";
			}
			// Emptying the data to refresh the view
			// Insert the JSON data to the table view
			var recipes = json;
			for ( var i = 0, iLen = recipes.length; i < iLen; i++) {
		
				newthing.push(recipes[i].WorkersWidget);
				//Ti.API.info(recipes[i].Recipe.name);
			}
			
			Alloy.Collections.WorkersWidgets.reset(newthing);
	
		    // save all of the elements
		    Alloy.Collections.WorkersWidgets.each(function(_m) {
		        _m.save();
		    });
		    
			//Send data to model
			var things = Alloy.Collections.WorkersWidgets;
			//fech data
			things.fetch();
			//end new
		    Ti.App.Properties.setString('workerswidgetsseeded', 'yuppers');
		};
}

*/

//
// View Language
//
$.loginForm.title        = L('login',      'Login');
$.inputUsername.hintText = L('username',   'Username');
$.inputPassword.hintText = L('password',   'Password');
$.buttonLogin.title      = L('login',      'Login');


//
// Navigation
//

// Android 
if (OS_ANDROID) {
    $.loginForm.addEventListener('open', function() {
        if($.loginForm.activity) {
            var activity = $.loginForm.activity;
    
            // Menu
            activity.invalidateOptionsMenu();
            activity.onCreateOptionsMenu = function(e) {
                var menu = e.menu;
                var menuItem1 = menu.add({
                    title: L('register', 'Register'),
                    showAsAction: Ti.Android.SHOW_AS_ACTION_NEVER
                });
                menuItem1.addEventListener('click', openRegister);
            };
    
            // Action Bar
            if( Alloy.Globals.Android.Api >= 11 && activity.actionBar) {      
                activity.actionBar.title = L('login', 'Login');            
            }
        }
    });
    
    // Back Button
    $.loginForm.addEventListener('android:back', function() {
        var activity = Ti.Android.currentActivity;
        activity.finish();
    });    
}

// iOS
if (OS_IOS) {
    var btnRightNav = Ti.UI.createButton({
       title: L('register', 'Register')
    });
    btnRightNav.addEventListener('click', openRegister);
    $.loginForm.rightNavButton = btnRightNav;
}