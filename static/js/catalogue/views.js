//Les vues javascript de la partie catalogue

define(['underscore',
        'marionette',
        'app',
        'catalogue/models', 
        'tpl!catalogue/templates/select_template.html'
], function ( _, Marionette, app, models, template ) {

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
        
        err_template : "<option>Erreur de chargement des modules...</option>",
        
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

        //Charger les modules de l'année spécifiée
        chargerModules : function () {
        
            //Afficher le message de chargement dans le select
            this.$el.html("<option>Chargement des modules...</option>");
            
            //Désactiver le select
            this.$el.attr('disabled', true);
            
            //Cacher les erreurs de chargement
            if(this.err_view) {
                this.err_view.remove();
            }
            
            //Afficher l'icône de chargement
            this.$el.before(app.loaderImg());
            
            //Récupérer la liste des modules
            this.collection.fetch({reset : true, 
                                   error : _.bind(function () {
                                       this.$el.html(this.err_template);
                                       this.$el.parent().find('.loader').remove();
                                       this.err_view = new app.ErrReqView({el : this.$el.parent().parent(), obj : this, method : "chargerModules"}).render();
                                   }, this)
            });
        },
        
        //Afficher les modules
        afficherModules : function () {app.loaderImg()
            //Supprimer le loader
            this.$el.parent().find('.loader').remove();
            
            //Activer le select
            this.$el.attr('disabled', false);
            
            //Reafficher le template
            this.render();
            
            //Déclencher l'évenement de changement
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
        
        err_template : "<option>Erreur de chargement des chapitres...</option>",
        
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
            this.$el.before(app.loaderImg());
            if(this.err_view) {
                this.err_view.remove();
            }
            this.collection.fetch({reset : true,
                                   error : _.bind(function () {
                                       this.$el.html(this.err_template);
                                       this.$el.parent().find('.loader').remove();
                                       this.err_view = new app.ErrReqView({el : this.$el.parent().parent(), obj : this, method : "chargerChapitres"}).render();
                                   }, this)});
        },
        
        afficherChapitres : function () {
            this.$el.parent().find('.loader').remove();
            this.$el.attr('disabled', false);
            this.render();
        }
    });

    return {'AnneeView' : AnneeView, 'ModulesView' : ModulesView, 'ModuleView' : ModuleView, 'ChapitresView' : ChapitresView};    
});
