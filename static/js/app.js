//L'application principale VirtUAPI-DZ 

define(["when",
        "marionette",
        "config",
        "tpl!templates/req_error.html"        
], function ( when, Marionette, config, req_error_template ) {

//Créer l'application
var app = new Marionette.Application();

//Vue d'erreur de requête, contient un lien pour renvoyer la requête.
app.ErrReqView = Marionette.ItemView.extend({
    
    //Template pour une erreur de requête
    template : req_error_template,

    //Un wrapper autour du template d'erreur
    wrapper : $("<tr class='error'></tr>"),
        
    events : {
        "click a" : "renvoyer"
    },
        
    initialize : function ( options ) {
        this.$el = this.wrapper.insertBefore(options['el']);
        this.obj = options['obj'];
        this.method = options['method'];
    },
    
    //Renvoyer la requête  
    renvoyer : function() {
        this.obj[this.method]();
    }        
});

//Gérer la visibilité de l'icône de chargement
app.loaderImg = {

    //Initialiser la récupération de l'icone
    init : function () {
        var imgDeferred = when.defer();
        this.imgPromise = imgDeferred.promise;
        require(["image!" + this.loaderImgUrl], function ( img ) {
            imgDeferred.resolve(img);
        });
    },

    //L'URL du loader
    loaderImgUrl : config.baseUrl + 'static/img/loader.gif',

    //Récupérer un élement clone de l'icone
    getLoaderImg : function ( img ) {
        /*Create a clone image,
          with the appropriate parameters*/
        var clone = $(img).clone();
        clone.addClass("loader");
        return clone;
    },
    
    //Afficher l'icône de chargement
    show : function (context) {
        var _this = this;
        this.imgPromise.then(function ( img ) {
            context.$el.before(_this.getLoaderImg( img ));
        });
    },
    
    //Enlever l'icône de chargement
    remove : function (context) {
        context.$el.parent().find('.loader').remove();
    }
};

/*Initialiser la récupération 
  de l'icone de chargement*/
app.loaderImg.init();

//Exporter les configurations de l'application
app.baseUrl = config.baseUrl;
app.CIBaseUrl = config.CIBaseUrl;

return app;
});
