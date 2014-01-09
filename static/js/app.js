//L'application principale VirtUAPI-DZ 

define(["marionette",
        "tpl!templates/req_error.html"        
], function ( Marionette, req_error_template ) {

//Créer l'application
var app = new Marionette.Application();

//Vue d'erreur de requête, contient un lien pour renvoyer la requête.
app.ErrReqView = Marionette.ItemView.extend({
    template : req_error_template,
        
    wrapper : $("<tr class='error'></tr>"),
        
    events : {
        "click a" : "renvoyer"
    },
        
    initialize : function ( options ) {
        this.$el = this.wrapper.insertBefore(options['el']);
        this.obj = options['obj'];
        this.method = options['method'];
    },
        
    renvoyer : function() {
        this.obj[this.method]();
    }        
});


//Gérer la visibilité de l'icône de chargement
app.loaderImg = {
    getLoaderImg : function () {
        return '<img alt="Chargement..." src="' + window.baseUrl + 'static/img/loader.gif" class="loader"/>';
    },
    
    //Afficher l'icône de chargement
    show : function (context) {
        context.$el.before(this.getLoaderImg());
    },
    
    //Enlever l'icône de chargement
    remove : function (context) {
        context.$el.parent().find('.loader').remove();
    }
};

return app;
});
