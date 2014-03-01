requirejs.config({
    baseUrl: '/virtuapi-dz-0.2/static/js/',
    paths: {
        when: 'libs/when',
        image: 'libs/requirejs/image',
        tpl: 'libs/requirejs/tpl',
        json2: 'libs/json2',
        jquery: 'libs/jquery.min',
        underscore: 'libs/lodash.underscore.min',
        backbone: 'libs/backbone-min',
        marionette: 'libs/backbone.marionette.min'
    },
    shim: {
        backbone: {
            deps: [ 'underscore', 'jquery', 'json2', 'tpl' ],
            exports: 'Backbone'
        },
        
        marionette: {
            deps: [ 'backbone' ],
            exports : 'Marionette'
        }
    }    
});


/*Les outils de base*/

//replaceAll
function replaceAll( txt, replace, with_this ) {
    return txt.replace(new RegExp(replace, 'g'), with_this);
}