// File models/thing.js
exports.definition = {
	
  config: {
  	
      columns: {
      	  "id":"INTEGER",
          "token": "TEXT",
          "email": "TEXT",
          "username": "TEXT",
          
        
      },
      adapter: {
          type: "sql",
          collection_name: "users",
          idAttribute:"id"
      }
      /*
		"URL": "https://maps.googleapis.com/maps/api/place/nearbysearch/json?types=hospital&location=13.01883,80.266113&radius=1000&sensor=false&key=AIzaSyDStAQQtoqnewuLdFwiT-FO0vtkeVx8Sks",
	    //"URL": "http://example.com/api/modelname",
	    //"debug": 1, 
	    "adapter": {
	        "type": "restapi",
	        "collection_name": "thing",
	        "idAttribute": "id"
	    },
	    "headers": { // your custom headers
	        "Accept": "application/vnd.stackmob+json; version=0",
	        "X-StackMob-API-Key": "your-stackmob-key"
	    },
	    //"parentNode": "news.domestic" //your root node
	    "parnetNode": "results"
	    */
	 
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
};