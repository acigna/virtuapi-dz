//Les models javascript de la partie catalogue


define(['backbone'
], function ( Backbone ) {


//Le modèle Annee
var Annee = Backbone.Model.extend({
    
});

//Le modèle Module
var Module = Backbone.Model.extend({

});

//Le modèle Chapitre
var Chapitre = Backbone.Model.extend({

});

//La collection de modules
var Modules = Backbone.Collection.extend({
    url : function () {
        return this.urlRoot + "/" + this.annee.id;
    },
    model : Module,
    initialize : function ( models, options ) {
        this.urlRoot = options['urlRoot'];
        this.annee = options['annee'];
    },
    
    parse : function ( response ) {
        return response.modules;    
    }
});

//La collection de chapitres
var Chapitres = Backbone.Collection.extend({
    url : function () {
        return this.urlRoot + "/" + this.module.id;
    },
    
    model : Chapitre,
    
    initialize : function ( models, options ) {
        this.urlRoot = options['urlRoot'];
        this.module = options['module'];
    },
    
    parse : function ( response ) {
        return response.chapitres;
    }
    
    
});

return {'Annee' : Annee, 'Modules' : Modules, 'Module' : Module, 'Chapitres' : Chapitres, 'Chapitre' : Chapitre}
});
