$(function () { 

require(['catalogue/utils'
], function ( utils ) {

//Configurer les selects de la suppression d'un chapitre
utils.setUpAMCSelect({"annee_elt" : "#NomAnnee", "annee_data" : window.annee, "module_elt" : "#NomModule",
    			      "module_data" : window.module, "chapitre_elt" : "#NomChapitre"});

});


});
