<?php

App::uses('PLUGINAppController', 'PLUGIN.Controller');
//TODO: fix index_home.xml
/**
 * Example Controller
 *
 * @category Controller
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class PLUGINController extends PLUGINAppController {

/**
 * Controller name
 *
 * @var string
 * @access public
 */
	public $name = 'PLUGIN';

/**
 * Models used by the Controller
 *
 * @var array
 * @access public
 */
	//public $uses = array('Setting');
	public $ignoretables = array(	"acos",
									"aros",
									"aros_acos",
									"blocks",
									"comments",
									"contacts",
									"i18n",
									"languages",
									"links",
									"menus",
									"messages",
									"meta",
									"nodes",
									"nodes_taxonomies",
									"regions",
									"roles",
									"settings",
									"taxonomies",
									"terms",
									"types",
									"types_vocabularies",
									"users",
									"roles_users",
									"pobjects",
									"projects",
									"pobjectbehaviors",
									"flds",
									"ftypes",
									"pobjects_pobjectbehaviors",
									"projectevents",
									"schema_migrations",
									"flds_fldbehaviors",
									"fldbehaviors",
									"vocabularies");

		

/**
 * admin_index
 *
 * @return void
 */
	function admin_buildnewmobilefiles(){
		

		$this->set('title_for_layout', __('Step 3: Build Models, Controllers, Views', true));
		
		App::uses('ShellDispatcher', 'Console');
		App::uses('BakeShell', 'Console/Command');
		App::uses('Shell', 'Console');
		App::uses('AppShell', 'Console/Command');
		App::uses('Model', 'Model');
		App::uses('CakeSchema', 'Model');
		App::uses('AppShell', 'Console/Command');
	
		$thisshell = new Shell();
		$thisshell->initialize();
		$thisshell->dispatchShell('Schema generate -f -o');
		
		App::uses('File', 'Utility');
		App::import('Model', 'CakeSchema', false);
		App::import('Model', 'ConnectionManager');
		
		$db = ConnectionManager::getDataSource('default');
		$schema =& new CakeSchema(array('name'=>'app'));
		$schema = $schema->load();
	
		App::import('Cake', 'Shell','Console/Command');
	
	
		$assocaitions = array();
		
		//build alloy.js!
		$alloystr = '
		Alloy.Globals.RELATIONSHIP = {';
		
		$alloystr2 = '
		if(Alloy.Globals.LocalDB == true){';
		
		$alloystr3 = "Alloy.Globals.PLUGIN = 'lcPLUGIN/';";
		
		foreach($schema->tables as $table => $fields) {
			
			if(!in_array($table,$this->ignoretables)){
				
				$mymodel = ClassRegistry::Init($table);
				 
				 $alloystr2 .= 'Alloy.Collections.'.ucfirst($mymodel->name).' = Alloy.createCollection("'.$this->_singularName($mymodel->name).'");';
				 
				//2. build mobile model file
				
				$alloystr .= $this->bakeMobileModel($mymodel);
				
				//3. build mobile controller files:
				$this->bakeMobileController($mymodel);
				
				$this->bakeMobileViews($mymodel);
				
			}
			
		}
		
		$alloystr = substr($alloystr, 0, -1);
		$alloystr .= '}';
		
		//echo $alloystr;
		//debugger::dump($alloystr);
		
		$alloystr2 .= '}';
		$this->bakeMobileAlloyFile("Alloy.Globals.BASEURL = 'HOST/';".$alloystr, $alloystr2, $alloystr3);
		

		
		$this->Session->setFlash(__('Built files! Download from webroot!.', true), 'default', array('class' => 'success'));

		$this->redirect(array('plugin'=>'extensions', 'controller'=>'extensions_plugins'));		
		
		
	}
	
	
	
	function bakeMobileAlloyFile($alloystr , $alloystr2, $alloystr3){
		$totalalloystr = $alloystr . $alloystr2. $alloystr3;
		$totalalloystr .= "//:::::::APP CREATOR SYNC OPTIONS:::::::
			//::::THE DB:::::::
			//USER WILL BE ASKED: 'will there be an onboard DB?'
				//IF SO, APPCREATOR will print 'Alloy.Globals.LocalDB = true;'
				//ELSE, APPCREATOR will print 'Alloy.Globals.LocalDB = false;'
				Alloy.Globals.LocalDB = true;
					
				//USER WILL BE ASKED: Install default data on MOBILE INSTALL?
					//IF SO, APPCREATOR will print 'Alloy.Globals.SyncAtInstall = true;'
					//ELSE, APPCREATOR will print 'Alloy.Globals.SyncAtInstall = false;'
					Alloy.Globals.SyncAtInstall = false;
					
				
				//USER WILL BE ASKED: should the app be able to sync automatically?
					//IF SO, APPCREATOR will print 'Alloy.Globals.AutoSync = true;'
					//ELSE, APPCREATOR will print 'Alloy.Globals.AutoSync = false;'
					Alloy.Globals.AutoSync = true;
					
					//USER WILL BE ASKED (if SO), At what frequency?  :: //options: RUNTIME, LOGOUT, LOGIN, TIME
						//AT RUNTIME:
								//APPCREATOR WILL PRINT: 'Alloy.Globals.SyncFreqOpt = 'RUNTIME';'
						//EVERY LOGOUT:
								//APPCREATOR WILL PRINT: 'Alloy.Globals.SyncFreqOpt = 'LOGOUT';'
						//IF EVERY LOGIN: 
								//APPCREATOR WILL PRINT: 'Alloy.Globals.SyncFreqOpt = 'LOGIN';'
						//EVERY # of MINUTES, SECONDS, HOURS, or DAYS:
								//APPCREATOR WILL PRINT: 'Alloy.Globals.SyncFreqOpt = 'TIME';'
								//APPCREATOR WILL PRINT: 'Alloy.Globals.SyncFreqTimeOpt = 'DAYS';'
								//APPCREATOR WILL PRINT: 'Alloy.Globals.SyncFreqTimeVar = '1';'
						Alloy.Globals.SyncFreqOpt = 'RUNTIME';
					
													
					//USER WILL BE ASKED: Do you want to let the Mobile User set the frequency?
						//IF SO, APPCREATOR will print 'Alloy.Globals.AllowDynAutoSync = true;' ......... AND ALL OPTIONS WITH IT!!
						//ELSE, APPCREATOR will print 'Alloy.Globals.AllowDynAutoSync = false;' 
						Alloy.Globals.AllowDynAutoSync = true;
						Alloy.Globals.DefaultSyncFreqOpt = Alloy.Globals.SyncFreqOpt;
												
													
				//APP WILL NOT SYNC AUTOMATICALLY!!!! APPCREATOR WILL PRINT: Alloy.Globals.AutoSync = false; Alloy.Globals.AllowDynSync = true;								
				
				//USER WILL BE ASKED: do you want to let the mobile user sync dynamically (on command)?
					//IF SO, APPCREATOR will print Alloy.Globals.AllowDynSync = true;'
					//ELSE, APPCREATOR will print 'Alloy.Globals.AllowDynSync = false;'
					Alloy.Globals.AllowDynSync = true;
					
			//APP DOES NOT HAVE AN ONBOARD DB!!!!  APPCREATOR WILL PRINT: Alloy.Globals.SyncFreqOpt = 'RUNTIME';	
			
					
			//:::::LOGIN:::::::::		
			//USER WILL BE ASKED: Do you want a login screen?
				//IF SO, APPCREATOR will print 'Alloy.Globals.configureLogin = true;'
				//ELSE, APPCREATOR will print 'Alloy.Globals.configureLogin = false;'
				Alloy.Globals.configureLogin = true;
			
			
			
			
			
			//Testing Globals
			Alloy.Globals.testchildren = 3;
			
			// Android api version
			if( OS_ANDROID ) {
				Alloy.Globals.Android = { 
					'Api' : Ti.Platform.Android.API_LEVEL
				};
			}
			
			// Styles
			Alloy.Globals.Styles = {
				'TableViewRow' : {
					'height' : 45
				}
			};
			
			//Global Post function
			function globalsave(theurl, thedata, modelname, thelocaldata){
				var sendit = Ti.Network.createHTTPClient({
					onerror : function(e) {
						Ti.API.debug(e.error);
						alert(e.error);
					},
					timeout : 1000,
				});
				sendit.onload = function() {
					var json = JSON.parse(this.responseText);
					Ti.API.info(this.responseText);
					if(json.message=='Saved!'){
						//save local data
						thelocaldata['id'] = json.id;
						var myModel = Alloy.createModel(modelname, thelocaldata);
						// save model
						myModel.save();
						// force tables to update
						Alloy.Collections[modelname].fetch();
					   
					}else{
						alert('There was an error in saving the '+modelname+'record.');
					}
					//end new
				};
				sendit.open('POST', theurl);
				sendit.send(thedata);
				
			}
			
			function globalserverdelete(tblname, id){
				var sendit = Ti.Network.createHTTPClient({
					onerror : function(e) {
						Ti.API.debug(e.error);
						//globaldeleterecord( tblname, id);
						alert('There was an error during the connection.  Want to try again?');
					},
					timeout : 1000,
				});
				sendit.open('POST', Alloy.Globals.BASEURL+tblname+'/mobiledelete.json');
				Ti.API.info( Alloy.Globals.BASEURL+tblname+'/mobiledelete');
				//sendit.open('https://maps.googleapis.com/maps/api/place/nearbysearch/json?types=hospital&location=13.01883,80.266113&radius=1000&sensor=false&key=AIzaSyDStAQQtoqnewuLdFwiT-FO0vtkeVx8Sks');
				sendit.send({'id':id});
				// Function to be called upon a successful response
				sendit.onload = function() {
					var json = JSON.parse(this.responseText);
					Ti.API.info(json);
					var db = Titanium.Database.open('_alloy_');
					var rows = db.execute('DELETE FROM '+tblname+' WHERE id = ?',id);
					db.close();
				 };
			};
			
			function globaldelete(e, parentTab, modelname, singlename, dataId, manytomanyaddscreen, tblview){
				if(parentTab!=''){
					tblview.deleteRow(e.index);
					if (typeof Alloy.Globals.RELATIONSHIP[modelname][manytomanyaddscreen] != 'undefined') {
						//HM
						
						globalopenDetail(e, Alloy.Globals.RELATIONSHIP[modelname].sModelname);
					}else{
						
						var db = Titanium.Database.open('_alloy_');
						var mmtblname = Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].related[modelname].manytomanytblname;
						var rows = db.execute('SELECT id FROM '+mmtblname+' WHERE '+Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename+'_id = ? AND '+ singlename + '_id = ?',dataId, e.rowData.dataId);
						Ti.API.info('SELECT id FROM '+mmtblname+' WHERE '+Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename+'_id = '+dataId+' AND '+ singlename + '_id = '+e.rowData.dataId);
						//var rows = db.execute('DELETE FROM '+mmtblname+' WHERE '+singlename+'_id = ? AND '+Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename+'_id = ?',e.rowData.dataId,dataId);
						
						if(rows.getRowCount() == 1){ 
							globalserverdelete(mmtblname, rows.fieldByName('id'));
						}else{
							alert('There is an error in your records. There are '+rows.getRowCount()+' records');
						}
						db.close();
					}	
				}else{
					//delete actual ingredient
					tblview.deleteRow(e.index);
					globalserverdelete( Alloy.Globals.RELATIONSHIP[modelname].tblname, e.rowData.dataId);
				}
			}
			
			function globalgetrecords(modelname, Modelname){
				if (!Ti.App.Properties.hasProperty(modelname+'seeded')) {
					
					var newthing = [];
					var data = [];
					var sendit = Ti.Network.createHTTPClient({
						onerror : function(e) {
							Ti.API.debug(e.error);
							//getrecords();
							alert('There was an error during the connection to get '+modelname+' records');
						},
						timeout : 1000,
					});
					// Here you have to change it for your local ip
					
					sendit.open('POST', Alloy.Globals.BASEURL+modelname+'/mobileindex.json');
					sendit.send({'token':Ti.App.Properties.getString('token')});
					sendit.onload = function() {
						Ti.API.info(this.responseText);
						var json = JSON.parse(this.responseText);
						if (json.length == 0) {
							$.table.headerTitle = 'The database row is empty';
							
						}
						var records = json;
						for ( var i = 0, iLen = records.length; i < iLen; i++) {
							newthing.push(records[i][Modelname]);
						}
						Alloy.Collections[Modelname].reset(newthing);
						Alloy.Collections[Modelname].each(function(_m) {
							_m.save();
						});
						var things = Alloy.Collections[Modelname];
						things.fetch();
						Ti.App.Properties.setString(modelname+'seeded', 'yuppers');
					};
				
				//end if	
				}else{
					//sync
					var has_added = false;
					if(has_added == false){
						//download all!
						
						var newthing = [];
						var data = [];
						var sendit = Ti.Network.createHTTPClient({
							onerror : function(e) {
								Ti.API.debug(e.error);
								//getrecords();
								alert('There was an error during the connection to get '+modelname+' records');
							},
							timeout : 1000,
						});
						// Here you have to change it for your local ip
						
						sendit.open('POST', Alloy.Globals.BASEURL+modelname+'/mobileindex.json');
						sendit.send({'token':Ti.App.Properties.getString('token')});
						sendit.onload = function() {
							Ti.API.info(this.responseText);
							var json = JSON.parse(this.responseText);
							if (json.length == 0) {
								$.table.headerTitle = 'The database row is empty';
								
							}
							var records = json;
							for ( var i = 0, iLen = records.length; i < iLen; i++) {
								newthing.push(records[i][Modelname]);
							}
							Alloy.Collections[Modelname].reset(newthing);
							Alloy.Collections[Modelname].each(function(_m) {
								_m.save();
							});
							var things = Alloy.Collections[Modelname];
							things.fetch();
							Ti.App.Properties.setString(modelname+'seeded', 'yuppers');
						};
					}
				}
				var things = Alloy.Collections[Modelname];
				//fech data
				things.fetch();	
			}
			
			function globalopenChild( e, ManyToManys, ManyToMany, hasmultimanytomany, modelname ){
					if(hasmultimanytomany == true){
						var opts = {
						  cancel: ManyToManys.length-1,
						  options: ManyToManys,
						  title: 'Which Sub Records?'
						};
							
						var dialog = Ti.UI.createOptionDialog(opts);
						
						dialog.addEventListener('click', function(evt)
						{
							//check if cancel
							if(evt.index != ManyToManys.length-1){
								var relationstr = 'related';
								var theController = '';
								var isrelated = false;
								if (ManyToManys[evt.index].indexOf(relationstr) >= 0){
									//HABTM!  Chop string!
									theController = ManyToManys[evt.index].replace('related ', '');
									isrelated = true;
								}else{
									//NOT HABTM
									theController = ManyToManys[evt.index];
								}
								
								var addController = Alloy.createController(theController, {
									parentTab: Alloy.Globals.tabGroup.getActiveTab(),
									dataId: e.rowData.dataId,
									manytomanyaddscreen: modelname,
									related:isrelated
								});
								var addview = addController.getView();
								if (OS_IOS) {
									//Alloy.Globals.navgroup.open(addview); 
									var tab = Alloy.Globals.tabGroup.getActiveTab();
									tab.open(addview);  
								} else if (OS_ANDROID) {
									addview.open();
								}
							  }
								
						});
						
						dialog.show();
						
					}else{
						//only one many to many
						//check if it's a HABTM relation
						var relationstr = 'related';
						var theController = '';
						var isrelated = false;
						if (ManyToMany.indexOf(relationstr) >= 0){
							//HABTM!  Chop string!
							theController = ManyToMany.replace('related ', '');
							isrelated = true;
						}else{
							//NOT HABTM
							theController = ManyToMany;
						}
						var addController = Alloy.createController(theController, {
							parentTab: Alloy.Globals.tabGroup.getActiveTab(),
							dataId: e.rowData.dataId,
							manytomanyaddscreen: modelname,
							related:isrelated
						});
						var addview = addController.getView();
						if (OS_IOS) {
							//Alloy.Globals.navgroup.open(addview); 
							var tab = Alloy.Globals.tabGroup.getActiveTab();
							tab.open(addview);  
						} else if (OS_ANDROID) {
							addview.open();
						}
					}
				};
			
			function globaledittable(e, tblview){
				if(OS_IOS){
					//leave IOS here incase we add Android multidelete functionality
					  if (e.source.title == 'Edit') {
						tblview.editable = false;//deactivate swipe-Delete button
						tblview.editing = true;//Edit:on
						tblview.editing = false;//Edit:off
						tblview.editing = true;//Edit:on again!
						tblview.moving = true;
						e.source.title = 'Done';
					} else { 
						tblview.editable = true;//reactivate swipe-Delete button!
						tblview.editing = false;
						tblview.moving = false;
						e.source.title = 'Edit';
				   }
				
				}
			}
			
			function globalopenAddItem(parentTab, related, modelname, singlename, manytomanyaddscreen, dataId){
				if(parentTab!=''){
					//add new other record
					if(related == true){
						Ti.App.addEventListener('changefield',function(e){ 
							var row = e;
							var db = Titanium.Database.open('_alloy_');
							//find many to many table name with manytomanyaddscreeen name
							var mmtblname = Alloy.Globals.RELATIONSHIP[modelname].related[manytomanyaddscreen]['manytomanytblname'];
							var rows = db.execute('INSERT INTO '+mmtblname+' ('+Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename+'_id, '+singlename+'_id) Values(?,?)', dataId, e.value);
							db.close();
						 });
							var win=Alloy.createController(modelname+'chooser').getView();
							win.open();
					}else{
							var win=Alloy.createController(modelname+'Add').getView();
							win.open();	 
					}
				}else{
						var win=Alloy.createController(modelname+'Add').getView();
						win.open();
				}
			}
			
			function globalopenDetail(_e, Modelname){
					var things = Alloy.Collections[Modelname];
					//Ti.API.info(things.get(_e.rowData.model));
					var addController = Alloy.createController(Modelname+'detail', {
						parentTab: Alloy.Globals.tabGroup.getActiveTab(),
						dataId: _e.rowData.dataId,
						model: things.get(_e.rowData.dataId)
					});
					
					var addview = addController.getView();
					if (OS_IOS) {
						//Alloy.Globals.navgroup.open(addview); 
						var tab = Alloy.Globals.tabGroup.getActiveTab();
						tab.open(addview);  
					} else if (OS_ANDROID) {
						addview.open();
					}
			};";
			
			//create new M2M controller
			
			$pathx = rtrim(getcwd (),'webroot').'Plugin/PLUGIN/webroot/mobile/app/';
		
			$path = $pathx;
			$filename = $path  . 'alloy.js';
			//$this->out("\nBaking model class for $name...");
			$this->createFile($filename, $path, $totalalloystr);
	
	}
	
	function bakeMobileModel($name, $data = array()) {
	  $relationstr = '';
	   $modelArr =  $array = json_decode(json_encode($name->schema()), true);
	  
	   if (is_object($name)) {
			
			if ($data == false) {
				
				$data = $associations = array();
				
				$data['associations'] = $this->doAssociations($name, $associations);
				//$data['validate'] = $this->doValidation($name);
				
			}
			
			$data['primaryKey'] = $name->primaryKey;
			$data['useTable'] = $name->table;
			$data['useDbConfig'] = $name->useDbConfig;
			$data['name'] = $name = $this->_modelName($name->name);
		} else {
			$data['name'] = $name;
		}
		
		$defaults = array('associations' => array(), 'validate' => array(), 'primaryKey' => 'id',
			'useTable' => null, 'useDbConfig' => 'default', 'displayField' => null);
		$data = array_merge($defaults, $data);
		
		$str = '"'.strtolower($this->_pluralName($name)).'":{
					"Modelname":"'.ucfirst($this->_pluralName($name)).'",
					"modelname":"'.$this->_pluralName($name).'",
					"singlename":"'.$this->_singularName($this->_modelName($name)).'",
					"tblname":"'.$this->_pluralName($name).'",
					"sModelname":"'.$name.'",';
		
		foreach($data['associations']['belongsTo'] as $num => $relname){
			$str .= '"'.$this->_pluralName($relname['alias']).'":{
						"relation":"BT",
						"tblname":"'.$this->_pluralName($relname['alias']).'",
						"Modelname":"'.ucfirst($this->_pluralName($relname['alias'])).'",
						"modelname":"'.$this->_pluralName($relname['alias']).'",
						"sModelname":"'.$relname['alias'].'"
					},';
		}
		//delete last comma
		$str = substr($str, 0, -1);
		foreach($data['associations']['hasMany'] as $num => $relname){
			$str .= '"'.$this->_pluralName($relname['alias']).'":{
						"relation":"HM",
						"tblname":"'.$this->_pluralName($relname['alias']).'",
						"Modelname":"'.ucfirst($this->_pluralName($relname['alias'])).'",
						"modelname":"'.$this->_pluralName($relname['alias']).'",
						"sModelname":"'.$relname['alias'].'"
					},';
		}
		//delete last comma
		$str = substr($str, 0, -1);
		if(!empty($data['associations']['hasAndBelongsToMany'])){
			
			$str .= '"related":{';
			
			foreach($data['associations']['hasAndBelongsToMany'] as $num => $relname){
				$str .= '"'.strtolower($this->_pluralName($relname['alias'])).'":{
							"manytomanytblname":"'.$relname['joinTable'].'",
							"manytomanyModelname":"'.$this->_controllerName($relname['joinTable']).'",
							"manytomanymodelname":"'.strtolower($this->_controllerName($relname['joinTable'])).'"
						},';
			}
			//delete last comma
			$str = substr($str, 0, -1);
			$str .= '}';
		}			
		$str .= '	},';
		
		
		$fldstr = '"id":"INTEGER PRIMARY KEY",';
		
		foreach($modelArr as $key => $vals){
			$fldstr .= '"'.$key.'":"'.$vals['type'].'",'; 
		}
		//check this inflector!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		$fldstr = substr($fldstr, 0, -1);					
		$out = '// File models/thing.js
					exports.definition = {
						
					  config: {
						
						  columns: {
							  '.$fldstr.'
							 
						  },
						  adapter: {
							  type: "sql",
							  collection_name: "'.Inflector::tableize($name).'",
							  idAttribute: "id"
						  }
						  
						 
					  },        
					  extendModel: function(Model) {        
						  _.extend(Model.prototype, {
							  // extended functions and properties go here
						  });
					 
						  return Model;
					  },
					 
					   extendCollection: function(Collection) {        
						  _.extend(Collection.prototype, {
							  // extended functions and properties go here
						  });
					 
						  return Collection;
					  }
					};';
		
		
		$pathx = rtrim(getcwd (),'webroot').'Plugin/PLUGIN/webroot/mobile/app/models/';
		
		$path = $pathx;
		$filename = $path . Inflector::underscore($name) . '.js';
		//$this->out("\nBaking model class for $name...");
		$this->createFile($filename, $path, $out);
		ClassRegistry::flush();
		return $str;
   }
   
   function bakeMobileController($name, $data = array()){
    $fldstr = '';
	$fldstr2 = '';
	$relationstr = '';
	$eventlistenerstr ='';
	$pickstr = '';
	$cfldstr2 = '';
	$cfldstr3 = '';
	$m2mcontrollerstr ='';
	
	$modelObj = $name;
	$modelArr =  $array = json_decode(json_encode($name->schema()), true);
		$relationstr = '';
		if (is_object($name)) {
				
			if ($data == false) {
				
				$data = $associations = array();
				
				$data['associations'] = $this->doAssociations($name, $associations);
				//$data['validate'] = $this->doValidation($name);
				
			}
			
			$data['primaryKey'] = $name->primaryKey;
			$data['useTable'] = $name->table;
			$data['useDbConfig'] = $name->useDbConfig;
			$data['name'] = $name = $this->_modelName($name->name);
		} else {
			$data['name'] = $name;
		}
		//print_r($modelObj->hasAndBelongsToMany);
		$totalrelations = count($data['associations']['belongsTo']) + count($data['associations']['hasMany']) + count($data['associations']['hasAndBelongsToMany']);
		
		foreach($data['associations']['belongsTo'] as $num => $relname){
			$relationstr .= "'".$this->_pluralName($relname['alias'])."',";					
		}
		
		foreach($data['associations']['hasMany'] as $num => $relname){
			$relationstr .= "'".$this->_pluralName($relname['alias'])."',";
		}
		
		foreach($data['associations']['hasAndBelongsToMany'] as $num => $relname){
			$relationstr .= "'related ".$this->_pluralName($relname['alias'])."',";
		}
			
		/*
		////////////////////////////
		create add controller
		///////////////////////////
		*/
		foreach($modelArr as $key => $vals){
			
			//echo 'vals:'.$vals;
			if($key != 'id'){
				$fldstr .= '"'.$key.'":$.'.$key.'.value,';
				$fldstr2 .=  $key.':$.'.$key.'.value,';
				if(strpos($key, '_id') !== false){
					
					$strpos = strpos($key, '_id');
					
					$pickstr .= "$.pick".substr($key, 0, $strpos).".addEventListener('click', function(_e) {
								var win=Alloy.createController('".$this->_pluralName(substr($key, 0, $strpos))."chooser').getView();
								win.open();
								});";
					
					$eventlistenerstr .= "Ti.App.addEventListener('change".substr($key, 0, $strpos)."field',function(e){ 
											$.".$key.".value = e.value;
											$.".substr($key, 0, $strpos).".value = e.title;
										 });";
				}
			}
		}
		
		
		foreach($modelArr as $key => $vals){
			if($key != 'id'){
				
			}
		}
		$fldstr = substr($fldstr, 0, -1);
		$fldstr2 = substr($fldstr2, 0, -1);
		
		$controllerAddStr ="
		var singlename = '".strtolower($name)."';
		var modelname = '".$this->_pluralName($name)."';
		var Modelname = '".$name."';
		var tblname = '".Inflector::tableize($name)."';
		
		var args = arguments[0] || {};
		
		$.savebtn.addEventListener('click', function(_e) {
		
			globalsave( Alloy.Globals.BASEURL+modelname+'/mobileadd/',
			 {
				 ".$fldstr."
			 },
			 Modelname,
			 {		
					".$fldstr2."
			  }
			 );
			
				// close window
				$.AddWindow.close();
		
		});
		//this is for when you have a button that correspsonds to a has many 
		//if has a BT relation add an event listener and a click function for buttons
		".$eventlistenerstr."
		
		".$pickstr."
		
		$.cancelbtn.addEventListener('click', function(e) {
		//var send = things.get(e.rowData.model);
			$.AddWindow.close();
			//Alloy.Globals.testchildren = Alloy.Globals.testchildren - 1;
		});
		";
		//create new M2M controller
		$pathx = rtrim(getcwd (),'webroot').'Plugin/PLUGIN/webroot/mobile/app/controllers/';
	
		$path = $pathx;
		$filename = $path . $this->_pluralName($name) . 'Add.js';
		//$this->out("\nBaking model class for $name...");
		$this->createFile($filename, $path, $controllerAddStr);
		
		
		/*
		////////////////////////////
		create chooser controller
		///////////////////////////
		*/
		$chooseStr =
		"
			var singlename = '".strtolower($name)."';
			var modelname = '".$this->_pluralName($name)."';
			var Modelname = '".$name."';
			var tblname = '".Inflector::tableize($name)."';
			
			
			//We will need to add event listeners for each unique table view created for each tab.
			$.tblview.addEventListener('click', function(e) {
			//var send = things.get(e.rowData.model);
				
				Ti.App.fireEvent('change".strtolower($name)."field', {
					value: e.rowData.dataId,
					title: e.rowData.title
				}); 
				$.tblviewWindow.close();
				
				//Alloy.Globals.testchildren = Alloy.Globals.testchildren - 1;
			});
			if(OS_IOS){
				$.cancel.addEventListener('click', function(e) {
			//var send = things.get(e.rowData.model);
				$.tblviewWindow.close();
				//Alloy.Globals.testchildren = Alloy.Globals.testchildren - 1;
			});
			
			}
			
			var things = Alloy.Collections[Modelname];
			
			things.fetch();	
			 
			function closeWindow(){
				$.tblviewWindow.close();
			} 
			 
			 // Android
			if (OS_ANDROID) {
			   $.tblviewWindow.addEventListener('open', function() {
					if($.tblviewWindow.activity) {
						var activity = $.tblviewWindow.activity;
						// Menu
						//activity.invalidateOptionsMenu();
						activity.onCreateOptionsMenu = function(e) {
							var menu = e.menu;
							if(Alloy.Globals.configureLogin == true){
								//add logout action
								var menuItem1 = menu.add({
									title: L('cancel', 'Cancel'),
									showAsAction: Ti.Android.SHOW_AS_ACTION_ALWAYS
								});
								//add recipe_yingredient!!!!
								menuItem1.addEventListener('click', closeWindow);
							//end logout action
							};
							
							////
							//// add other actions to menu at Home here.
							////
						}; 
					}
				});
				
				// Back Button - not really necessary here - this is the default behaviour anyway?
				$.tblviewWindow.addEventListener('android:back', function() {              
					$.tblviewWindow.close();
					$.tblviewWindow = null;
				});     
			};
			";
			
		$pathx = rtrim(getcwd (),'webroot').'Plugin/PLUGIN/webroot/mobile/app/controllers/';
	
		$path = $pathx;
		$filename = $path . $this->_pluralName($name) . 'chooser.js';
		//$this->out("\nBaking model class for $name...");
		$this->createFile($filename, $path, $chooseStr);
		
		/*
		////////////////////////////
		create detail controller
		///////////////////////////
		*/
		$datatrans = '';
		
		foreach($modelArr as $key => $vals){
			if($key != 'id'){
				$datatrans .= $key.':_model.attributes.'.$key.',';
				$cfldstr2 .=  $key.':$.'.$key.'.value,';
				$cfldstr3 .= 'itemModel.set("'.$key.'", $.'.$key.'.value);
				';
			}
		}
		
		$cfldstr = substr($fldstr, 0, -1);
		$cfldstr2 = substr($fldstr2, 0, -1);
		
		$detailStr =
		"///**************
		/*
		 * 
		 Three variable arrays:
		 Data Transform:
		 Static portion:	id:_model.attributes.id
		 Variable:	 		[fldname]: _model.attributes.[fldname]
		 
		 Save Data:
		 Static Portion:	id: $.name.datid,
		 Variable:			[fldname]: $.[fldname].value,
		 
		 Local Save data:
		 Static portion: NA
		 Variable:		 itemModel.set('[fldname]', $.[fldname].value);
						
		 */
		////*************
		
		var args = arguments[0] || {};
		var parentTab = args.parentTab || '';
		var dataId = (args.dataId === 0 || args.dataId > 0) ? args.dataId : '';
		
		if (dataId !== '') {
			$.thingDetail.set(args.model.attributes);
			
			$.thingDetail = _.extend({}, $.thingDetail, {
				transform : function() {
					return dataTransformation(this);
				}
			});
		
			function dataTransformation(_model) {
				return {
					//ModelVars
					id : _model.attributes.id,
					".$datatrans."
					//ModelVars
				};
			}
		}
		
		function savetoremote(){
			var sendit = Ti.Network.createHTTPClient({
					onerror : function(e) {
						Ti.API.debug(e.error);
						savetoremote();
						alert('There was an error during the connection');
					},
					timeout : 1000,
				});
			sendit.open('GET', Alloy.Glogals.BASEURL+'workers/mobilesave');
			sendit.send({
				//Model Vars
				id: $.name.datid,
				".$cfldstr2."
				//Model Vars
			});
			// Function to be called upon a successful response
			sendit.onload = function() {
				var json = JSON.parse(this.responseText);
				// var json = json.todo;
				// if the database is empty show an alert
				if (json.length == 0) {
					$.table.headerTitle = 'The database row is empty';
					
				}
			};
		}
		
		///Buttons!
		
		$.cancelbtn.addEventListener('click', function(){
			$.".$this->_pluralName($name)."detail.close();
		});
		
		$.savebtn.addEventListener('click', function(){
			var itemModel = args.model;
			//Model VARS
			".$cfldstr3."
			//End model vars
			
			itemModel.save();
			//Alloy.Collections.Thing.fetch();
			savetoremote();
			$.".$this->_pluralName($name)."detail.close();
		});
		
		 // Android
		if (OS_ANDROID) {
			$.".$this->_pluralName($name)."detail.addEventListener('open', function() {
				if($.".$this->_pluralName($name)."detail.activity) {
					var activity = $.".$this->_pluralName($name)."detail.activity;
		
					// Action Bar
					if( Ti.Platform.Android.API_LEVEL >= 11 && activity.actionBar) {      
						activity.actionBar.title = L('detail', 'Detail');
						activity.actionBar.displayHomeAsUp = true; 
						activity.actionBar.onHomeIconItemSelected = function() {               
							$.".$this->_pluralName($name)."detail.close();
							$.".$this->_pluralName($name)."detail = null;
						};             
					}
				}
			});
			
			// Back Button - not really necessary here - this is the default behavior anyway?
			$.".$this->_pluralName($name)."detail.addEventListener('android:back', function() {              
				$.".$this->_pluralName($name)."detail.close();
				$.".$this->_pluralName($name)."detail = null;
			});     
		}";
		
		
		//create new M2M controller
		$pathx = rtrim(getcwd (),'webroot').'Plugin/PLUGIN/webroot/mobile/app/controllers/';
	
		$path = $pathx;
		$filename = $path . $this->_pluralName($name) . 'detail.js';
		//$this->out("\nBaking model class for $name...");
		$this->createFile($filename, $path, $detailStr);
		
		/*
		////////////////////////////
		create Many to Many EDIT controller
		///////////////////////////
		*/
		foreach($data['associations']['hasAndBelongsToMany'] as $num => $relname){
				
			$m2mcontrollerstr .=
			"
			var Modelname = '".strtolower($this->_controllerName($relname['joinTable']))."';
			var modelname = '".strtolower($this->_controllerName($relname['joinTable']))."';
			var tblname = '".$relname['joinTable']."';
			// Check for expected controller args
			//
			var args = arguments[0] || {};
			var parentTab = args.parentTab || '';
			var dataId = (args.dataId === 0 || args.dataId > 0) ? args.dataId : '';
			
			//
			// The list controller shouldn't call detail unless it has an id it is going to pass it in the first place
			// Just double check we got it anyway and do nothing if we didn't
			//
			Ti.API.info(dataId);
			if (dataId != '') {
				//Ti.API.info('id:'+args.dataId.attributes.id);
				$.thingDetail.set(args.model.attributes);
				
				$.thingDetail = _.extend({}, $.thingDetail, {
					transform : function() {
						return dataTransformation(this);
					}
				});
			
				
				function dataTransformation(_model) {
				   // Ti.API.info(_model.attributes.name);
					return {
						id : _model.attributes.id,
						widget_id : _model.attributes.widget_id,
						worker_id : _model.attributes.worker_id,
						itemqty: _model.attributes.numbermade
					};
				}
			}
			
			function savetoremote(){
				var sendit = Ti.Network.createHTTPClient({
						onerror : function(e) {
							Ti.API.debug(e.error);
							savetoremote();
							alert('There was an error during the connection');
						},
						timeout : 1000,
					});
				sendit.open('GET', Alloy.Globals.BASEURL+Modelname+'/mobilesave');
				//sendit.open('https://maps.googleapis.com/maps/api/place/nearbysearch/json?types=hospital&location=13.01883,80.266113&radius=1000&sensor=false&key=AIzaSyDStAQQtoqnewuLdFwiT-FO0vtkeVx8Sks');
				sendit.send({
					id: $.name.datid,
					name: $.name.value,
					description: $.description.value
				});
				// Function to be called upon a successful response
				sendit.onload = function() {
					var json = JSON.parse(this.responseText);
					// var json = json.todo;
					// if the database is empty show an alert
					if (json.length == 0) {
						$.table.headerTitle = 'The database row is empty';
						
					}
				};
			}
			
			$.cancelbtn.addEventListener('click', function(){
				$.".$name."detail.close();
			});
			
			$.savebtn.addEventListener('click', function(){
				var itemModel = args.model;
				//itemModel.set('description', $.description.value);
				itemModel.set('name', $.name.value);
				
				itemModel.save();
			
				// force tables to update
				Alloy.Collections.Thing.fetch();
				//save to remote
				savetoremote();
				$.".$name."detail.close();
			});
			
			 // Android
			if (OS_ANDROID) {
				$.".$name."detail.addEventListener('open', function() {
					if($.".$name."detail.activity) {
						var activity = $.".$name."detail.activity;
			
						// Action Bar
						if( Ti.Platform.Android.API_LEVEL >= 11 && activity.actionBar) {      
							activity.actionBar.title = L('detail', 'Detail');
							activity.actionBar.displayHomeAsUp = true; 
							activity.actionBar.onHomeIconItemSelected = function() {               
								$.".$name."detail.close();
								$.".$name."detail = null;
							};             
						}
					}
				});
				
				// Back Button - not really necessary here - this is the default behaviour anyway?
				$.".$name."detail.addEventListener('android:back', function() {              
					$.".$name."detail.close();
					$.".$name."detail = null;
				});     
			}
			
			// iOS
			// as detail was opened in the tabGroup, iOS will handle the nav itself (back button action and title)
			// but we could change the iOS back button text:
			//$.".$name."detail.backButtonTitle = L('backText', 'Back to List');
			";
			
			//save new M2M controller
			$pathx = rtrim(getcwd (),'webroot').'Plugin/PLUGIN/webroot/mobile/app/controllers/';
		
			$path = $pathx;
			$filename = $path . $relname['joinTable'] . 'Edit.js';
			//$this->out("\nBaking model class for $name...");
			$this->createFile($filename, $path, $m2mcontrollerstr);
		
		}
		
		//delete last comma
		$relationstr = substr($relationstr, 0, -1);
		
		/*
		////////////////////////////
		create main controller FILE
		///////////////////////////
		*/
		$filestr = "
			var singlename = '".$this->_singularName($name)."';
			var modelname = '".$this->_pluralName($name)."';
			var Modelname = '".ucfirst($name)."';
			var tblname = '".$this->_pluralName($name)."';
			";
		
		if($totalrelations > 1){
			$filestr .= "//foreach manytomany get list and add 'cancel'
					var ManyToManys = [".$relationstr.", 'Cancel'];
					var hasmultimanytomany = true;
					//ELSE PRINT
					var ManyToMany = '';//'yingredients';
					//var hasmultimanytomay = false;			
					//Arguments coming in:
					//var hasmultimanytomay = false;
					";
		}else{
			if($relationstr = ''){
				
				$filestr .="
						//foreach manytomany get list and add 'cancel'
						var ManyToManys = '';//['related widgets', 'Some Other', 'And another','Yet another','Cancel'];
						//var hasmultimanytomany = true;
						//ELSE PRINT
						var ManyToMany = '".$relationstr."';
						var hasmultimanytomany = false;			
						//Arguments coming in:
						//var hasmultimanytomay = false;
						";
				
			}else{
			
				$filestr .="
						//foreach manytomany get list and add 'cancel'
						var ManyToManys = '';//['related widgets', 'Some Other', 'And another','Yet another','Cancel'];
						//var hasmultimanytomany = true;
						//ELSE PRINT
						var ManyToMany = ".$relationstr.";
						var hasmultimanytomany = false;			
						//Arguments coming in:
						//var hasmultimanytomay = false;
						";
			}
		}

		
		$filestr .= 
		"				
			var args = arguments[0] || {};
			var parentTab = args.parentTab || '';
			var manytomanyaddscreen = args.manytomanyaddscreen;
			var related = args.related;
			var dataId = (args.dataId === 0 || args.dataId > 0) ? args.dataId : '';
			//VARS:
			//HAS CHILDREN = true;
			//HAS PARENT = false;
			
			function openAddItem(){
				globalopenAddItem(parentTab, related, modelname, singlename, manytomanyaddscreen, dataId);
			}
			
			function deleterecord(e){
				globaldelete(e, parentTab, modelname, singlename, dataId, manytomanyaddscreen, $.tblview);
				Ti.API.info('e_id:'+e.rowData.dataId);
			}
			
			function editmany(e){
				if(parentTab!=''){
					//check to see the type of relation...if not in relation array, must me related (m2m)
					var checkarray = Alloy.Globals.RELATIONSHIP[tblname];
					var mmtblname = '';
					var mmModelname = '';
					Ti.API.info(checkarray);
					if (typeof Alloy.Globals.RELATIONSHIP[tblname][manytomanyaddscreen] != 'undefined') {
						//HM
					   mmModelname = Alloy.Globals.RELATIONSHIP[tblname].sModelname;
						globalopenDetail(e, mmModelname);
						
					}else{
						//m2m only!
						mmtblname = Alloy.Globals.RELATIONSHIP[tblname].related[manytomanyaddscreen].manytomanytblname;
						mmModelname = Alloy.Globals.RELATIONSHIP[tblname].related[manytomanyaddscreen].manytomanyModelname;
						
							//open recipes_yingredients inspector!!!
						var db = Titanium.Database.open('_alloy_');
						//Ti.API.info(dataId);
						//db.execute('BEGIN IMMEDIATE TRANSACTION');
						var rows = db.execute('SELECT id FROM '+mmtblname+' WHERE '+Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename+'_id = ? AND '+ singlename + '_id = ?',dataId, e.rowData.dataId);
						if(rows.getRowCount() == 1){  
							//Ti.API.info(rows.fieldByName('yingredient_id')); 
							var ythings = Alloy.Collections[mmModelname];
							ythings.fetch();
							//Ti.API.info('id shoulbe: '+rows.fieldByName('id'));
							var addController = Alloy.createController(mmtblname+'Edit', {
								parentTab: Alloy.Globals.tabGroup.getActiveTab(),
								dataId: rows.fieldByName('id'),
								model: ythings.get(rows.fieldByName('id'))			  
							});
							var addview = addController.getView();
							if (OS_IOS) {
								//Alloy.Globals.navgroup.open(addview); 
								var tab = Alloy.Globals.tabGroup.getActiveTab();
								tab.open(addview);  
							} else if (OS_ANDROID) {
								addview.open();
							}
							
							//db.execute('COMMIT TRANSACTION');
							db.close();
						}else{
							alert('Error: you have duplicate records!');
						}
					}
					
				}else{
					globalopenDetail(e, Modelname);
				}
			}
			
			if(OS_IOS){
				$.addbtn.addEventListener('click', function(){
					globalopenAddItem(parentTab, related, modelname, singlename, manytomanyaddscreen, dataId);
				});
				
				$.refresh.addEventListener('click', function(){
					globalgetrecords(modelname, Modelname);
				});
				
				$.editme.addEventListener('click', function(e){
				   globaledittable(e, $.tblview);
				});	
				$.tblview.addEventListener('delete',function(e){
					deleterecord(e);	
					
				});
				$.tblview.addEventListener('longpress', function(e) {
				//var send = things.get(e.rowData.model);
					globalopenDetail(e, Modelname);
				});
				/*
				$.tblview.addEventListener('dblclick', function(e) {
				//var send = things.get(e.rowData.model);
					editmany(e);
				});
				*/
			}
			
			var things = Alloy.Collections[Modelname];
			//fech data
			things.fetch();	
			
			globalgetrecords(modelname, Modelname);
			
			$.tblview.addEventListener('click', function(e) {
				if(parentTab!=''){
					//show detail of related.
					editmany(e);
				}else{
					globalopenChild( e, ManyToManys, ManyToMany, hasmultimanytomany, modelname, parentTab );
			   }
			});
			
			function gettherecords(){
				globalgetrecords(modelname, Modelname);
			}
			
			//loader (both)
			function myLoader(e) {
				// Length before
				var ln = things.models.length;
				Ti.API.info(ln);
				
					var newthing = [];
					var data = [];
					var sendit = Ti.Network.createHTTPClient({
						onerror : function(e) {
							Ti.API.debug(e.error);
							
							alert('There was an error during the connection');
						},
						timeout : 1000,
					});
					// Here you have to change it for your local ip
					var lnstr = (ln/20)+1;
					sendit.open('GET', Alloy.Globals.BASEURL+modelname+'/page:'+lnstr.toString());
					//sendit.open('https://maps.googleapis.com/maps/api/place/nearbysearch/json?types=hospital&location=13.01883,80.266113&radius=1000&sensor=false&key=AIzaSyDStAQQtoqnewuLdFwiT-FO0vtkeVx8Sks');
					sendit.send();
					// Function to be called upon a successful response
					sendit.onload = function() {
						var json = JSON.parse(this.responseText);
						// var json = json.todo;
						// if the database is empty show an alert
						if (json.length == 0) {
							$.table.headerTitle = 'The database row is empty';
							
						}
						// Emptying the data to refresh the view
						// Insert the JSON data to the table view
						var records = json;
						for ( var i = 0, iLen = records.length; i < iLen; i++) {
					
							newthing.push(records[i][Modelname]);
							//Ti.API.info(recipes[i].Recipe.name);
						}
						
						Alloy.Collections[Modelname].reset(newthing);
				
						// save all of the elements
						Alloy.Collections[Modelname].each(function(_m) {
							_m.save();
						});
						
						//Send data to model
						var things = Alloy.Collections[Modelname];
						//fech data
						 things.fetch({
			
							// Some data for the sync adapter to retrieve next page
							data: { offset: ln },
					
							// Don't reset the collection, but add to it
							add: true,
					
							// Don't trigger an add event for every model, but just one fetch
							silent: true,
					
							success: function (col) {
								Ti.API.info('successful here');
								// Call done if we didn't add anymore models
								(col.models.length === ln) ? e.done() : e.success();
							},
					
							error: e.error
						});
						//end new
					   
						
					};
			}
			
			 // Android Navigation
			if(OS_ANDROID) {
				
				$.tblviewWindow.addEventListener('open', function() {
					if($.tblviewWindow.activity) {
						var activity = $.tblviewWindow.activity;
			
						// Action Bar
						if( Ti.Platform.Android.API_LEVEL >= 11 && activity.actionBar) {      
							activity.actionBar.title = L('detail', 'Detail');
							activity.actionBar.displayHomeAsUp = true; 
							activity.actionBar.onHomeIconItemSelected = function() {               
								$.tblviewWindow.close();
								$.tblviewWindow = null;
							};             
						}
						
						activity.onCreateOptionsMenu = function(e) {
							var menu = e.menu;
							 
							// Menu Item 1
							var menuItem1 = menu.add({
								title : 'Add',
								showAsAction : Ti.Android.SHOW_AS_ACTION_NEVER
							});
							
							menuItem1.addEventListener('click', openAddItem);
						};
						
					}
				});
				
				//necessary to change the menu for Add
			 
				$.tblviewWindow.addEventListener('focus', function() {
						if($.tblviewWindow.activity) {
							var activity = Alloy.Globals.tabGroup.activity;
							
							// Menu
							activity.invalidateOptionsMenu();
							activity.onCreateOptionsMenu = function(e) {
								var menu = e.menu;
								if(Alloy.Globals.configureLogin == true){
									//add logout action	
									var menuItem1 = menu.add({
										title: L('add', 'Add '+Modelname),
										showAsAction: Ti.Android.SHOW_AS_ACTION_NEVER
									});
								   menuItem1.addEventListener('click', openAddItem);
									
									var menuItem2 = menu.add({
										title: L('refresh', 'Refresh'),
										showAsAction: Ti.Android.SHOW_AS_ACTION_NEVER
									});
								   
								   menuItem2.addEventListener('click', gettherecords);
									
								   
								};
					
							};            
						}   
					});
				
				  //edit and delete
				$.tblviewWindow.addEventListener('swipe', function(e) {
					if(parentTab!=''){
						var row = e;
						
						var opts = {
						  cancel: 4,
						  options: ['Edit Relation','Delete Relation', 'Edit Record', 'Delete Record', 'Cancel'],
						  title: 'Edit or Delete?'
						};
							
						var dialog = Ti.UI.createOptionDialog(opts);
						 
						dialog.addEventListener('click',function(evt){
							//get relation record
							switch(evt.index){
								case 0:
									editmany(row);
								break;
								case 1:
									deleterecord(row);
								break;
								case 2:
									globalopenDetail(row, Modelname);
								break;
								case 3:
									deleterecord(row);
								break;
							}
						});
						 
						dialog.show();
					
					}else{
						var row = e;
						Ti.API.info('e:'+row);
						var alertDialog = Titanium.UI.createAlertDialog({
							title: 'Edit or Delete Record?',
							message: 'Edit or Delete?',
							buttonNames: ['Edit','Delete', 'Cancel'],
							cancel: 2
						});
						 
						alertDialog.addEventListener('click',function(e){
							switch(e.index){
								case 0:
									 globalopenDetail(row, Modelname);
								break;
								case 1:
									deleterecord(row);
								break;
								case 2:
									//do nothing.
								break;
								
							} 
							   
						});
						 
						alertDialog.show();
					}
					
				  
				});
				
				// Back Button - not really necessary here - this is the default behaviour anyway?
				$.tblviewWindow.addEventListener('android:back', function() {              
					$.tblviewWindow.close();
					$.tblviewWindow = null;
				});     
			};
			$.tblviewWindow.addEventListener('focus', function(e){
				if(parentTab!=''){
					Ti.API.info('args not empty!');
					//var recipesyingredient = Alloy.Collection.RecipesYingredient;
					var things = Alloy.Collections[Modelname];
					//recipesyingredient.fetch({query:'SELECT * FROM recipes_yingredient WHERE recipe_id ='+dataId});
					var db = Titanium.Database.open('_alloy_');
					//db.execute('BEGIN IMMEDIATE TRANSACTION');
					if(related==true){
						//ManyToMany
						var mmtblname = Alloy.Globals.RELATIONSHIP[modelname].related[manytomanyaddscreen].manytomanytblname;
						
						var rows = db.execute('SELECT '+singlename+'_id FROM '+mmtblname+' WHERE '+Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename+'_id = ?',dataId);
						if(rows.rowCount!=0){
							var str = '';
							while(rows.isValidRow()){  
								//Ti.API.info(rows.fieldByName('yingredient_id')); 
								str = str+rows.fieldByName(singlename+'_id')+',';
								rows.next();
							}
							db.close();
							str = str.substring(0, str.length - 1) + ')';
							things.fetch({query:'SELECT * FROM '+tblname+' WHERE id IN ('+str});
						}else{
							
							things.fetch({query:'SELECT * from '+mmtblname+' WHERE id = 0;'});
							$.tblview.headerTitle = 'The database row is empty';
							
						}
					}else{
						//HasMany
						//var rows = db.execute('SELECT * FROM '+hmtblname+' WHERE '+Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename+'_id = ?',dataId);
						things.fetch({query:'SELECT * FROM '+tblname+' WHERE '+Alloy.Globals.RELATIONSHIP[manytomanyaddscreen].singlename+'_id ='+dataId});
					}
				}else{
					Ti.API.info('args empty!');
					//get all records
					var things = Alloy.Collections[Modelname];
					//fech data
					things.fetch();	
				}
			});";
		
			$pathx = rtrim(getcwd (),'webroot').'Plugin/PLUGIN/webroot/mobile/app/controllers/';
			
			$path = $pathx;
			$filename = $path . Inflector::underscore($this->_pluralName($name)) . '.js';
			//$this->out("\nBaking model class for $name...");
			$this->createFile($filename, $path, $filestr);
	   
   }
   
   function bakeMobileViews($name, $data = array()){
	    $addviewstr ='';
		$cfldstr4 = '';
		$relationstr = '';
		$modelObj = $name;
		$modelArr =  $array = json_decode(json_encode($name->schema()), true);
		if (is_object($name)) {
				
			if ($data == false) {
				
				$data = $associations = array();
				
				$data['associations'] = $this->doAssociations($name, $associations);
				//$data['validate'] = $this->doValidation($name);
				
			}
			
			$data['primaryKey'] = $name->primaryKey;
			$data['useTable'] = $name->table;
			$data['useDbConfig'] = $name->useDbConfig;
			$data['name'] = $name = $this->_modelName($name->name);
		} else {
			$data['name'] = $name;
		}
		
		/*
		////////////////////////////
		create main view FILE
		///////////////////////////
		*/
		
		$viewStr = '
		<Alloy>
			<Collection  src="'.$this->_modelName($name).'" />
			<!--<Tab title="Items" icon="KS_nav_ui.png" id="recipestab">-->	
				<Window id="tblviewWindow" ><!--class="container"> -->
					<RightNavButton platform="android,ios">
						<Button id="editme">Edit</Button>
					</RightNavButton>
					<ActivityIndicator id="activityIndicator" />
					<Label id="labelNoRecords" />
					<TableView searchHidden="true" id="tblview" dataCollection="'.$this->_modelName($name).'" moveable="true" editable="true" filterAttribute="title">
					  <SearchBar platform="android,ios"/>
					  <Widget id="is" src="nl.fokkezb.infiniteScroll" onEnd="myLoader" />
					  <TableViewRow id="row" dataId="{id}" title="{name}">
						
						<!--<Label class="rowName" text="{name}"></Label>-->
					  </TableViewRow>
					</TableView>
					 <Toolbar platform="ios" bottom="0" borderTop="true" borderBottom="false">
		
					<!-- The Items tag sets the Toolbar.items property. -->
					<Items>
						
					   
						<Button id="camera" systemButton="Ti.UI.iPhone.SystemButton.CAMERA" />
						<FlexSpace/>
						<Button id="refresh" systemButton="Titanium.UI.iPhone.SystemButton.REFRESH" />
						<FlexSpace/>
						<Button id="addbtn" systemButton="Titanium.UI.iPhone.SystemButton.ADD" />
					</Items>
		
					<!-- Place additional views for the Toolbar here. -->
		
					</Toolbar>
				</Window>
				
			<!--</Tab>-->
			<!--code will insert new tabs here????-->
		</Alloy>
		';
		
		$pathx = rtrim(getcwd (),'webroot').'Plugin/PLUGIN/webroot/mobile/app/views/';
			
		$path = $pathx;
		$filename = $path . $this->_pluralName($name) . '.xml';
		//$this->out("\nBaking model class for $name...");
		$this->createFile($filename, $path, $viewStr);
		
		/*
		////////////////////////////
		create detail view FILE
		///////////////////////////
		*/
		$cfldstrdetail = '';
		foreach($modelArr as $key => $vals){
			if($key != 'id' && $key != 'name'){
				$cfldstrdetail .= '<TextField id="'.$key.'" value="{$.thingDetail.'.$key.'}" ></TextField>';
				
			}
		}
		
		$detailStrView = 
		'<Alloy>
			<Model src="'.$this->_modelName($name).'" instance="true" id="thingDetail">
			<Window id="detail" model="$.thingDetail" dataTransform="dataTransformation" layout="vertical"> 
				<TextField id="name" datid = "{$.thingDetail.id}" value="{$.thingDetail.name}"  hintText="Name" ></TextField>
				'.$cfldstrdetail.'
				<Button id="savebtn">Save</Button>
				<Button id="cancelbtn">Cancel</Button>
			</Window>
		</Alloy>
		';
		
		$pathx = rtrim(getcwd (),'webroot').'Plugin/PLUGIN/webroot/mobile/app/views/';
			
		$path = $pathx;
		$filename = $path . $this->_pluralName($name) . 'detail.xml';
		//$this->out("\nBaking model class for $name...");
		$this->createFile($filename, $path, $detailStrView);
		
		
		/*
		////////////////////////////
		create chooser view FILE
		///////////////////////////
		*/
		$chooserStr =
		'<Alloy>
			<Collection  src="'.$this->_modelName($name).'" />
			
				<Window id="tblviewWindow" ><!--class="container"> -->
					
					<ActivityIndicator id="activityIndicator" />
					<Label id="labelNoRecords" />
					<TableView id="tblview" dataCollection="'.$this->_modelName($name).'" editable="true" filterAttribute="title">
					  <SearchBar platform="android,ios"/>
					 
					  <TableViewRow id="row" dataId="{id}" model="{alloy_id}" title="{name}">
						<!--<Label class="rowName" text="{name}"></Label>-->
					  </TableViewRow>
					</TableView>
					<Toolbar platform="ios" bottom="0" borderTop="true" borderBottom="false">
					<!-- The Items tag sets the Toolbar.items property. -->
					<Items>
						<FlexSpace/>
						<Button id="cancel" systemButton="Titanium.UI.iPhone.SystemButton.CANCEL" />
						<FlexSpace/>
					</Items>
				</Toolbar>
				</Window>
			
			<!--code will insert new tabs here????-->
		</Alloy>
		';
		
		
		$pathx = rtrim(getcwd (),'webroot').'Plugin/PLUGIN/webroot/mobile/app/views/';
			
		$path = $pathx;
		$filename = $path . $this->_pluralName($name) . 'chooser.xml';
		//$this->out("\nBaking model class for $name...");
		$this->createFile($filename, $path, $chooserStr);
		
		/*
		////////////////////////////
		create Many to ManyEdit view FILE
		///////////////////////////
		*/
		if(strpos(Inflector::tableize($name), '_') !== false){
			foreach($modelArr as $key => $vals){
					if($key != 'id'){
						$cfldstr4 .= '<TextField id="'.$key.'" value="{$.thingDetail.'.$key.'}" ></TextField>';
					}
				}
				
		//TODO Check MODEL SRC for join tables
			$m2mEditStr = 
			'<Alloy>
			
				<Model src="'.Inflector::tableize($name).'" instance="true" id="thingDetail">
				<Window id="detail" model="$.thingDetail" dataTransform="dataTransformation" layout="vertical"> 
					<!-- <TextField id="widget_id" datid = "{$.thingDetail.id}" value="{$.thingDetail.widget_id}"></TextField>-->
				   
					'.$cfldstr4.'
					<Button id="savebtn">Save</Button>
					<Button id="cancelbtn">Cancel</Button>
				</Window>
			</Alloy>';
			
			
			$pathx = rtrim(getcwd (),'webroot').'Plugin/PLUGIN/webroot/mobile/app/views/';
				
			$path = $pathx;
			$filename = $path . Inflector::tableize($name) . 'Edit.xml';
			//$this->out("\nBaking model class for $name...");
			$this->createFile($filename, $path, $m2mEditStr);
			
		}
		
		/*
		////////////////////////////
		create add view FILE
		///////////////////////////
		*/
		///$addviewstr ='';
		//print_r($modelArr);
		foreach($modelArr as $key => $vals){
			
			//echo 'vals:'.$vals;
			if($key != 'id'){
				if(strpos($key, '_id') !== false){
					
					$strpos = strpos($key, '_id');
					$addviewstr .= '<TextField id="'.$key.'" value="{$.thingDetail.'.$key.'}" ></TextField>
					';
				//create extra feild (to show name of linked model
					$addviewstr .= '<TextField id="'.substr($key, 0, $strpos).'name"></TextField>';
				//create extra button!
					$addviewstr .= '<Button id="pick'.substr($key, 0, $strpos).'">'.substr($key, 0, $strpos).'</Button>';
				}else{
					//echo 'key:'.$key;
					$addviewstr .= '<TextField id="'.$key.'" hintText="'.$key.'" value="{$.thingDetail.'.$key.'}" ></TextField>
					';
				}
			}
		}
		
		//echo 'cfld:'.$cfldstr2;
		
		$addStr = '
		<Alloy>
			<Model src="'.$this->_modelName($name).'" instance="true" id="thingDetail">
			<Window id="AddWindow">
				
				<ScrollView id="addView" layout="vertical" >'.
				$addviewstr.'
					
					<Button id="savebtn" title="Save"></Button>
					<Button id="cancelbtn" title="Cancel"></Button>
				</ScrollView>
			</Window>
		</Alloy>
		';
		//echo $addStr;
		$pathx = rtrim(getcwd (),'webroot').'Plugin/PLUGIN/webroot/mobile/app/views/';
			
		$path = $pathx;
		$filename = $path . $this->_pluralName($name) . 'Add.xml';
		//$this->out("\nBaking model class for $name...");
		$this->createFile($filename, $path, $addStr);
		
   
   }
   
   	/**
 * Get an Array of all the tables in the supplied connection
 * will halt the script if no tables are found.
 *
 * @param string $useDbConfig Connection name to scan.
 * @return array Array of tables in the database.
 */
	function getAllTables($useDbConfig = null) {
		App::import('Core', 'File');
		App::import('Model', 'CakeSchema', false);
		App::import('Model', 'ConnectionManager');
		
		$db = ConnectionManager::getDataSource('default');
		//debugger::dump($db);
		$schema =& new CakeSchema(array('name'=>'app'));
		$schema = $schema->load();
		return $schema;
	}
	
   
   function doAssociations(&$model) {
		if (!is_object($model)) {
		
			return false;
		}

		$fields = $model->schema(true);
		if (empty($fields)) {
			
			return false;
		}

		if (empty($this->_tables)) {
			$this->_tables = $this->getAllTables();
		}

		$associations = array(
			'belongsTo' => array(), 'hasMany' => array(), 'hasOne'=> array(), 'hasAndBelongsToMany' => array()
		);
		$possibleKeys = array();

		$associations = $this->findBelongsTo($model, $associations);
		
		$associations = $this->findHasOneAndMany($model, $associations);
	
		$associations = $this->findHasAndBelongsToMany($model, $associations);
		
		return $associations;
	}

/**
 * Find belongsTo relations and add them to the associations list.
 *
 * @param object $model Model instance of model being generated.
 * @param array $associations Array of inprogress associations
 * @return array $associations with belongsTo added in.
 */
	function findBelongsTo(&$model, $associations) {
		$fields = $model->schema(true);
		foreach ($fields as $fieldName => $field) {
			$offset = strpos($fieldName, '_id');
			if ($fieldName != $model->primaryKey && $fieldName != 'parent_id' && $offset !== false) {
				$tmpModelName = $this->_modelNameFromKey($fieldName);
				$associations['belongsTo'][] = array(
					'alias' => $tmpModelName,
					'className' => $tmpModelName,
					'foreignKey' => $fieldName,
				);
			} elseif ($fieldName == 'parent_id') {
				$associations['belongsTo'][] = array(
					'alias' => 'Parent' . $model->name,
					'className' => $model->name,
					'foreignKey' => $fieldName,
				);
			}
		}
		return $associations;
	}

/**
 * Find the hasOne and HasMany relations and add them to associations list
 *
 * @param object $model Model instance being generated
 * @param array $associations Array of inprogress associations
 * @return array $associations with hasOne and hasMany added in.
 */
	function findHasOneAndMany(&$model, $associations) {
		
		$foreignKey = $this->_modelKey($model->name);
		//echo 'finding One and Many...<br />';
		//debugger::dump($this->_tables->tables);
		foreach ($this->_tables->tables as $mname => $otherTable) {
			
				//debugger::dump($mname);
				//echo 'try getting table for '.$mname.'<br />';
				$tempOtherModel = $this->_getModelObject($this->_modelName($mname), $mname);
				//echo 'got table for '.$mname.'<br />';
				$modelFieldsTemp = $tempOtherModel->schema(true);
				$pattern = '/_' . preg_quote($model->table, '/') . '|' . preg_quote($model->table, '/') . '_/';
				//debugger::dump($pattern);
				//echo 'pattern for tbl - '.$mname.':'.$pattern.'<br />';
				$possibleJoinTable = preg_match($pattern , $mname);
				if ($possibleJoinTable == true) {
					continue;
					
				}
				//echo 'foreach <br />';
				foreach ($modelFieldsTemp as $fieldName => $field) {
					//echo 'fldname:'.$fieldName.'<br />';
					$assoc = false;
					if ($fieldName != $model->primaryKey && $fieldName == $foreignKey) {
						$assoc = array(
							'alias' => $tempOtherModel->name,
							'className' => $tempOtherModel->name,
							'foreignKey' => $fieldName
						);
						
					} elseif ($otherTable == $model->table && $fieldName == 'parent_id') {
						$assoc = array(
							'alias' => 'Child' . $model->name,
							'className' => $model->name,
							'foreignKey' => $fieldName
						);
						
					}
					
					if ($assoc) {
						
						$associations['hasOne'][] = $assoc;
						$associations['hasMany'][] = $assoc;
					}
					
				}
				//print_r($associations);
				//echo '<br />';
				//echo '<br />';
		}
		
		return $associations;
	}

/**
 * Find the hasAndBelongsToMany relations and add them to associations list
 *
 * @param object $model Model instance being generated
 * @param array $associations Array of inprogress associations
 * @return array $associations with hasAndBelongsToMany added in.
 */
	function findHasAndBelongsToMany(&$model, $associations) {
		
		$foreignKey = $this->_modelKey( $this->_singularName($model->name ));
		//debugger::dump($model->name);
		foreach ($this->_tables->tables as $tname => $otherTable) {
			
			$tempOtherModel = $this->_getModelObject($this->_modelName($tname), $tname);
			$modelFieldsTemp = $tempOtherModel->schema(true);
			$offset = strpos($tname, $model->table . '_');
			$otherOffset = strpos($tname, '_' . $model->table);

			if ($offset !== false) {
				
				$offset = strlen($model->table . '_');
			
				$habtmName = $this->_modelName(substr($tname, $offset));
				
				$associations['hasAndBelongsToMany'][] = array(
					'alias' => $habtmName,
					'className' => $habtmName,
					'foreignKey' => $foreignKey,
					'associationForeignKey' => $this->_modelKey($habtmName),
					//'joinTable' => $otherTable
					'joinTable'=>$tname
				);
			} elseif ($otherOffset !== false) {
				
				$habtmName = $this->_modelName(substr($tname, 0, $otherOffset));
				$associations['hasAndBelongsToMany'][] = array(
					'alias' => $habtmName,
					'className' => $habtmName,
					'foreignKey' => $foreignKey,
					'associationForeignKey' => $this->_modelKey($habtmName),
					//'joinTable' => $otherTable
					'joinTable'=>$tname
				);
			}
		}
		return $associations;
	}
	/**
 * Get a model object for a class name.
 *
 * @param string $className Name of class you want model to be.
 * @return object Model instance
 */
	function &_getModelObject($className, $table = null) {
		//debugger::dump($table);
		if (!$table) {
			
			$table = Inflector::tableize($className);
		}
		//echo 'sometable '.$table.'<br />';
		$object =& new Model(array('name' => $className, 'table' => $table, 'ds' => 'default'));
		//																												HEEEEEEEEEEEEEEEEERRRRRRRRREEEEEEEEEEEEEE
		return $object;
	}
	
	function createFile($path, $folderpath, $contents) {
		App::uses('File', 'Utility');
		$path = str_replace(DS . DS, DS, $path);

		if (!class_exists('File')) {
			require LIBS . 'file.php';
		}

		if ($File = new File($path, true)) {
			
			$data = $File->prepare($contents);
			$File->write($data);
			
			//debugger::dump('written!');
			//$this->out(sprintf(__('Wrote `%s`', true), $path));
			return true;
		} else {
			//debugger::dump('Err!');
			//$this->err(sprintf(__('Could not write to `%s`.', true), $path), 2);
			return false;
		}
	}
	
	function shiftArgs($args) {
		return array_shift($args);
	}
	
	function _controllerName($name) {
		
		return Inflector::pluralize(Inflector::camelize($name));
	}

/**
 * Creates the proper controller camelized name (singularized) for the specified name
 *
 * @param string $name Name
 * @return string Camelized and singularized controller name
 * @access protected
 */
	function _modelName($name) {
		//debugger::dump($name);
		return Inflector::camelize(Inflector::singularize($name));
	}

/**
 * Creates the proper underscored model key for associations
 *
 * @param string $name Model class name
 * @return string Singular model key
 * @access protected
 */
	function _modelKey($name) {
		return Inflector::underscore($name) . '_id';
	}

/**
 * Creates the proper model name from a foreign key
 *
 * @param string $key Foreign key
 * @return string Model name
 * @access protected
 */
	function _modelNameFromKey($key) {
		return Inflector::camelize(str_replace('_id', '', $key));
	}

/**
 * creates the singular name for use in views.
 *
 * @param string $name
 * @return string $name
 * @access protected
 */
	function _singularName($name) {
		return Inflector::variable(Inflector::singularize($name));
	}

/**
 * Creates the plural name for views
 *
 * @param string $name Name to use
 * @return string Plural name for views
 * @access protected
 */
	function _pluralName($name) {
		return Inflector::variable(Inflector::pluralize($name));
	}

/**
 * Creates the singular human name used in views
 *
 * @param string $name Controller name
 * @return string Singular human name
 * @access protected
 */
	function _singularHumanName($name) {
		return Inflector::humanize(Inflector::underscore(Inflector::singularize($name)));
	}

/**
 * Creates the plural human name used in views
 *
 * @param string $name Controller name
 * @return string Plural human name
 * @access protected
 */
	function _pluralHumanName($name) {
		return Inflector::humanize(Inflector::underscore($name));
	}
	/**
 * Creates the proper controller path for the specified controller class name
 *
 * @param string $name Controller class name
 * @return string Path to controller
 * @access protected
 */
	function _controllerPath($name) {
		return strtolower(Inflector::underscore($name));
	}

}
