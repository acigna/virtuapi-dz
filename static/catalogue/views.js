//Les views javascript de la partie catalogue

define(['catalogue/models'], function ( models ) {

    //La liste déroulante des modules
    var ModulesView = Marionette.ItemView.extend({
        collection : models.Modules
    });
    
    //La liste déroulante des chapitres
    var ChapitresView = Marionette.ItemView.extend({
        collection : models.Chapitres    
    });

    return {'ModulesView' : ModulesView, 'ChapitresView' : ChapitresView};    
});
