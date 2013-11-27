//Les models javascript de la partie catalogue


define(function () {


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
    model : Module
});

//La collection de chapitres
var Chapitres = Backbone.Collection.extend({
    model : Chapitre
});

return {'Annee' : Annee, 'Modules' : Modules, 'Module' : Module, 'Chapitres' : Chapitres, 'Chapitre' : Chapitre}
});
