//Les vues javascript de la partie catalogue

define(['underscore',
        'marionette',
        'app',
        'catalogue/models', 
        'tpl!catalogue/templates/select_module_template.html',
        'tpl!catalogue/templates/select_chapitre_template.html'
], function ( _, Marionette, app, models, select_module_template,
              select_chapitre_template ) {

    //L'année selectionnée dans la liste déroulante
    var AnneeView = Marionette.ItemView.extend({
    
        //Les évenements DOM
        events : {
            "change" : "setAnnee"
        },
        
        //Fixer l'année dans le modèle
        setAnnee : function () {
            this.model.set({"id" : this.$el.val(), "nom" : this.$el.find('[value="' + this.$el.val() + '"]').html()});
        }
    });
    
    //La liste déroulante des modules
    var ModulesView = Marionette.ItemView.extend({
    
        //Template de la liste déroulante
        template : select_module_template,
        
        //Template de chargement
        load_template : "<option>Chargement des modules...</option>",
        
        //Template d'erreur de chargement
        err_template : "<option>Erreur de chargement des modules...</option>",
        
        //Les évenements DOM
        events : {
            "change" : "chargerChapitres"
        },
        
        //Initilisation de la vue
        initialize : function ( options ) {
        
            //Affecter l'attribut annee, et observer son changement
            this.annee = options['annee'];
            this.listenTo( this.annee, "change", this.chargerModules );

            //Observer l'event 'reset' de la collection pour réafficher les modules
            this.listenTo( this.collection, "reset", this.afficherModules );
        },

        //Charger les modules de l'année spécifiée
        chargerModules : function () {
        
            //Afficher le message de chargement dans la liste
            this.$el.html(this.load_template);
            
            //Désactiver le select
            this.$el.attr('disabled', true);
            
            //Enlever les erreurs de chargement
            if(this.err_view) {
                this.err_view.remove();
            }
            
            //Afficher l'icône de chargement
            app.loaderImg.show(this);

            //Récupérer la liste des modules
            this.collection.fetch({ reset : true, 
                                    error : _.bind(function () {
                                        //Afficher le template d'erreur de chargement dans la liste
                                        this.$el.html(this.err_template);
                                       
                                        //Enlever l'icone de chargement
                                        app.loaderImg.remove(this);
                                       
                                        //Afficher le message d'erreur contenant le lien de rechargement
                                        this.err_view = new app.ErrReqView({el : this.$el.parent().parent(), obj : this, method : "chargerModules"}).render();
                                    }, this)
                                 });
        },
        
        //Afficher les modules
        afficherModules : function () {
        
            //Supprimer l'icone de chargement
            app.loaderImg.remove(this);
            
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
        
        //Les évenements DOM
        events : {
            "change" : "setModule"
        },
        
        //Fixer le module dans le modèle
        setModule : function () {
            this.model.set({"id" : this.$el.val(), "nom" : this.$el.find('[value="' + this.$el.val() + '"]').html()});
        }
        
    });
    
    //La liste déroulante des chapitres
    var ChapitresView = Marionette.ItemView.extend({
    
        //Template de la liste déroulante
        template : select_chapitre_template,
        
        //Template de chargement
        load_template : "<option>Chargement des chapitres...</option>",
        
        //Template d'erreur de chargement
        err_template : "<option>Erreur de chargement des chapitres...</option>",
        
        //Initilisation de la vue
        initialize : function ( options ) {
        
            //Affecter l'attribut annee, et observer son changement
            this.module = options['module'];
            this.listenTo( this.module, "change", this.chargerChapitres );
            
            //Observer l'event 'reset' de la collection pour le recharger
            this.listenTo( this.collection, "reset", this.afficherChapitres );            
        
        },
                        
        chargerChapitres : function () {
            //Afficher le message de chargement dans la liste
            this.$el.html(this.load_template);
            
            //Désactiver le select
            this.$el.attr('disabled', true);
            
            
            //Enlever les erreurs de chargement
            if(this.err_view) {
                this.err_view.remove();
            }
            
            //Afficher l'icône de chargement
            app.loaderImg.show(this);

            //Récupérer la liste des modules
            this.collection.fetch({ reset : true,
                                    error : _.bind(function () {
                                        //Afficher le template d'erreur de chargement dans la liste
                                        this.$el.html(this.err_template);
                                
                                        //Enlever l'icone de chargement
                                        app.loaderImg.remove(this);
                                       
                                        //Afficher le message d'erreur contenant le lien de rechargement
                                        this.err_view = new app.ErrReqView({el : this.$el.parent().parent(), obj : this, method : "chargerChapitres"}).render();
                                    }, this)
                                 });


        },
        
        //Afficher les chapitres
        afficherChapitres : function () {
            //Supprimer l'icone de chargement
            app.loaderImg.remove(this);
            
            //Activer le select
            this.$el.attr('disabled', false);
            
            //Reafficher le template
            this.render();
        }
    });

    return {'AnneeView' : AnneeView, 'ModulesView' : ModulesView, 'ModuleView' : ModuleView, 'ChapitresView' : ChapitresView};    
});
