//Les vues javascript de la partie catalogue

define(['underscore',
        'marionette',
        'catalogue/models', 
        'tpl!catalogue/templates/select_template.html'
], function ( _, Marionette, models, template ) {

    //Vue d'erreur de serveur, contient un lien pour renvoyer la requête.
    var ErrView = Marionette.ItemView.extend({
        template : _.template('<td class="right"></td><td class="left" style="font-size:13px;color:red;">Impossible d\'envoyer la requête, <a href="#">cliquer ici</a> pour renvoyer</td>'),
        events : {
            "click a" : "renvoyer"
        },
        
        initialize : function ( options ) {
            this.$el = $("<tr class='error'></tr>").insertBefore(options['el']);
            window.el = this.$el;
            this.obj = options['obj'];
            this.method = options['method'];
        },
        
        renvoyer : function() {
            this.obj[this.method]();
        }        
    });

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
            if(this.err_view) {
                this.err_view.remove();
            }
            this.$el.before('<img alt="loading..." src="' + this.loaderUrl + '" class="loader" style="height:20px;"/>');
            this.collection.fetch({reset : true, 
                                   error : _.bind(function () {
                                       this.$el.html("<option>Erreur de chargement des modules...</option>");
                                       this.$el.parent().find('.loader').remove();
                                       this.err_view = new ErrView({el : this.$el.parent().parent(), obj : this, method : "chargerModules"}).render();
                                   }, this)
            });
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
            if(this.err_view) {
                this.err_view.remove();
            }
            this.collection.fetch({reset : true,
                                   error : _.bind(function () {
                                       this.$el.html("<option>Erreur de chargement des chapitres...</option>");
                                       this.$el.parent().find('.loader').remove();
                                       this.err_view = new ErrView({el : this.$el.parent().parent(), obj : this, method : "chargerChapitres"}).render();
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
