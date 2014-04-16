//Les outils de la partie catalogue

define(['marionette',
        'catalogue/views',
        'catalogue/models'
], function ( Marionette, views, models ) {

    //Configuration des selects Annee / Module / Chapitre
    var setUpAMCSelect = function ( options ) {
        var annee_elt = options.annee_elt,
            annee_data = options.annee_data,
            module_elt = options.module_elt,
            module_data = options.module_data,
            chapitre_elt = options.chapitre_elt,
            chapitre_data = options.chapitre_data;

        //Configuration Annee
        if( annee_elt ) {
            //Le modèle
            var annee = new models.Annee(annee_data || {});

            //La vue attachée au modèle
            var annee_view = new views.AnneeView({el : annee_elt, model : annee});
        }

        //Configuration Module
        if( module_elt ) {
            //Le modèle
            var module = new models.Module(module_data || {});

            //La collection
            var modules = new models.Modules([], {annee : annee});
            
            //La vue attachée au modèle
            var module_view = new views.ModuleView({el : module_elt, model : module});

            //La vue attachée à la collection 
            var modules_view = new views.ModulesView({el : module_elt, annee : annee, collection : modules});
        }

        //Configuration Chapitre
        if( chapitre_elt ) {
            var chapitres = new models.Chapitres([], {module : module});
            var chapitres_view = new views.ChapitresView({el : chapitre_elt, module : module, collection : chapitres});
        }
    };

    return {setUpAMCSelect: setUpAMCSelect};
});