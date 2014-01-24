$(function () { 

require(['catalogue/utils'
], function ( utils ) {
    
//Configurer les selects de la suppression d'un module
utils.setUpAMCSelect({"annee_elt" : "#NomAnnee1", "module_elt" : "#NomModule1"});

//Configurer les selects de l'ajout d'un chapitre
utils.setUpAMCSelect({"annee_elt" : "#NomAnnee3", "module_elt" : "#NomModule3"});
    
//Configurer les selects de la suppression d'un chapitre
utils.setUpAMCSelect({"annee_elt" : "#NomAnnee2", "module_elt" : "#NomModule2", 
                      "chapitre_elt" : "#NomChapitre"});
    
    
    
});


});
