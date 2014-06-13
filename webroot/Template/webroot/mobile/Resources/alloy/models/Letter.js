exports.definition = {
    config: {
        columns: {
            id: "INTEGER PRIMARY KEY",
            id: "integer",
            name: "TEXT"
        },
        adapter: {
            type: "sql",
            collection_name: "letters",
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

model = Alloy.M("letter", exports.definition, []);

collection = Alloy.C("letter", exports.definition, model);

exports.Model = model;

exports.Collection = collection;