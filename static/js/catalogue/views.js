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
            
            //Récupérer l'URL du Loader GIF
            this.loaderUrl = options['loaderUrl'];
               
            //Observer l'event 'reset' de la collection pour le recharger
            this.listenTo( this.collection, "reset", this.afficherModules );
        },

        chargerModules : function () {
            this.$el.html("<option>Chargement des modules...</option>");
            this.$el.attr('disabled', true);
            this.$el.before('<img alt="loading..." src="' + this.loaderUrl + '" class="loader" style="height:20px;"/>');
            this.collection.fetch({reset : true});
        },
        
        afficherModules : function () {
            this.$el.parent().find('.loader').remove();
            this.$el.attr('disabled', false);
            this.render();
            this.$el.trigger('change');
        }
        
    });
    
    //Le module selectionné dans la liste déroulante
    var ModuleView = Marionette.ItemView.extend({
        events : {
            "change" : "setModule"
        },
        
        setModule : function () {
            this.model.set({"id" : this.$el.val(), "nom" : this.$el.find('[value="' + this.$el.val() + '"]').html()});
        }
        
    });
    
    //La liste déroulante des chapitres
    var ChapitresView = Marionette.ItemView.extend({
        template : template,
        
        initialize : function ( options ) {
        
            //Affecter l'attribut annee, et observer son changement
            this.module = options['module'];
            this.listenTo( this.module, "change", this.chargerChapitres );
            
            //Récupérer l'URL du Loader GIF
            this.loaderUrl = options['loaderUrl'];
               
            //Observer l'event 'reset' de la collection pour le recharger
            this.listenTo( this.collection, "reset", this.afficherChapitres );            
        
        },
        
        chargerChapitres : function () {
            this.$el.html("<option>Chargement des chapitres...</option>");
            this.$el.attr('disabled', true);
            this.$el.before('<img alt="loading..." src="' + this.loaderUrl + '" class="loader" style="height:20px;"/>');
            this.collection.fetch({reset : true});
        },
        
        afficherChapitres : function () {
            this.$el.parent().find('.loader').remove();
            this.$el.attr('disabled', false);
            this.render();
        }
    });

    return {'AnneeView' : AnneeView, 'ModulesView' : ModulesView, 'ModuleView' : ModuleView, 'ChapitresView' : ChapitresView};    
});
