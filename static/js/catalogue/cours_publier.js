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
var chapitreUrlRoot = window.chapitreUrlRoot;

//Initialiser les collections
var modules = new models.Modules([], {urlRoot : moduleUrlRoot, annee : annee});
var chapitres = new models.Chapitres([], {urlRoot : chapitreUrlRoot, module : module});

//Initialiser les vues

////Initialiser la liste déroulante des modules
var annee_view = new views.AnneeView({el : "#NomAnnee", model : annee});
var modules_view = new views.ModulesView({el : "#NomModule", annee : annee, collection : modules, loaderUrl : window.loaderUrl});
var module_view = new views.ModuleView({el : "#NomModule", model : module});
var chapitres_view = new views.ChapitresView({el : "#NomChapitre", module : module, collection : chapitres, loaderUrl : window.loaderUrl});

});


});
