exports.definition = {
    config: {
        columns: {
            id: "INTEGER PRIMARY KEY",
            id: "integer",
            name: "TEXT",
            age: "integer",
            letter_id: "integer"
        },
        adapter: {
            type: "sql",
            collection_name: "kids",
            idAttribute: "id"
        }
    },
    extendModel: function(Model) {
        _.extend(Model.prototype, {});
        return Model;
    },
    extendCollection: function(Collection) {
        _.extend(Collection.prototype, {});
        return Collection;
    }
};

var Alloy = require("alloy"), _ = require("alloy/underscore")._, model, collection;

model = Alloy.M("kid", exports.definition, []);

collection = Alloy.C("kid", exports.definition, model);

exports.Model = model;

exports.Collection = collection;