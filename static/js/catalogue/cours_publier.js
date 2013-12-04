$(function () { 

require(['marionette',
        'catalogue/views',
        'catalogue/models'
], function ( Marionette, views, models ) {

//Initialiser l'application

//Initialiser les modèles
var annee = new models.Annee(window.annee);
var module = new models.Module(window.module);
var chapitre = new models.Chapitre(window.chapitre);

//Initialiser l'urlRoot
var moduleUrlRoot = window.moduleUrlRoot;

//Initialiser les collections
var modules = new models.Modules([], {urlRoot : moduleUrlRoot, annee : annee});

//Initialiser les vues

////Initialiser la liste déroulante des modules
var annee_view = new views.AnneeView({el : "#NomAnnee", model : annee});
var modules_view = new views.ModulesView({el : "#NomModule", annee : annee, collection : modules});


});


});
