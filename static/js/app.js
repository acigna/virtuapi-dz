//Le module principal de VirtUAPI-DZ 

define(['marionette',
        'config',
        'tpl!templates/req_error.html'        
], function ( Marionette, config, req_error_template ) {

//Créer l'application
var app = new Marionette.Application();

//Vue d'erreur de requête, contient un lien pour renvoyer la requête.
app.ErrReqView = Marionette.ItemView.extend({
    
    //Template pour une erreur de requête
    template: req_error_template,

    //Un wrapper autour du template d'erreur
    wrapper: $( '<tr class="error"></tr>'),
        
    events: {
        "click a": "renvoyer"
    },
        
    initialize: function ( options ) {
        this.$el = this.wrapper.insertBefore( options[ 'el' ] );
        this.obj = options[ 'obj' ];
        this.method = options[ 'method' ];
    },
    
    //Renvoyer la requête  
    renvoyer: function() {
        this.obj[ this.method ]();
    }        
});

//Gérer la visibilité de l'icône de chargement
app.loaderImg = {
    loaded: false,
    
    //Initialiser la récupération de l'icone
    init: function () {
        var _this = this;
        require([ 'image!' + this.loaderImgUrl ], function ( img ) {
            _this.loaded = true;
            _this.img = img;
        });
    },

    //L'URL du loader
    loaderImgUrl: config.baseUrl + 'static/img/loader.gif',

    //Récupérer un élement clone de l'icone
    getLoaderImg: function ( img ) {
        /*Créer un clone de l'objet img,
          avec les paramètres appropriés*/
        var clone = $( img  ).clone();
        clone.addClass( 'loader' );
        return clone;
    },
    
    //Afficher l'icône de chargement
    show: function ( context ) {
        if( this.loaded ) {
            context.$el.before( this.getLoaderImg( this.img ) );
        }
    },
    
    //Enlever l'icône de chargement
    remove: function ( context ) {
        context.$el.parent().find( '.loader' ).remove();
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