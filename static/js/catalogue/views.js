//Les vues javascript de la partie catalogue

define(['marionette',
        'catalogue/models', 
        'tpl!catalogue/templates/select_template.html'
], function ( Marionette, models, template ) {

    //L'année selectionnée dans la liste déroulante
    var AnneeView = Marionette.ItemView.extend({
        events : {
            "change" : "setAnnee"
        },
        
        setAnnee : function () {
            this.model.set({"id" : this.$el.val(), "nom" : this.$el.find('[value="' + this.$el.val() + '"]').html()});
        }
    });
    
    //La liste déroulante des modules
    var ModulesView = Marionette.ItemView.extend({
        template : template,
        events : {
            "change" : "chargerChapitres"
        },
        
        initialize : function ( options ) {
        
            //Affecter l'attribut annee, et observer son changement
            this.annee = options['annee'];
            this.listenTo( this.annee, "change", this.chargerModules );
            
            //Observer l'event 'reset' de la collection pour le recharger
            this.listenTo( this.collection, "reset", this.render );
        },

        chargerModules : function () {
            this.collection.fetch({reset : true});
        },
        
    });
    
    //La liste déroulante des chapitres
    var ChapitresView = Marionette.ItemView.extend({
        collection : models.Chapitres    
    });

    return {'AnneeView' : AnneeView, 'ModulesView' : ModulesView, 'ChapitresView' : ChapitresView};    
});
