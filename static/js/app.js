//L'application principale VirtUAPI-DZ 

define(["jquery",
        "marionette",
        "config",
        "tpl!templates/req_error.html"        
], function ( $, Marionette, config, req_error_template ) {

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
    loaderImgUrl : config.baseUrl + 'static/img/loader.gif',
    getLoaderImg : function ( img ) {
        /*Create a clone image,
          with the appropriate parameters*/
        var clone = $(img).clone();
        clone.attr("alt", "Chargement...");
        clone.addClass("loader");
        return clone;
    },
    
    //Afficher l'icône de chargement
    show : function (context) {
        var _this = this;
        var deferred = $.Deferred();
        require(["image!" + this.loaderImgUrl], function ( img ) {
            context.$el.before(_this.getLoaderImg( img ));
            deferred.resolve();
        });
        return deferred.promise();
    },
    
    //Enlever l'icône de chargement
    remove : function (context) {
        context.$el.parent().find('.loader').remove();
    }
};

//Exporter les configurations de l'application
app.baseUrl = config.baseUrl;
app.CIBaseUrl = config.CIBaseUrl;

return app;
});
