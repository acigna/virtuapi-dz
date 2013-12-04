requirejs.config({
    baseUrl : '/codeigniter/static/js/',
    paths : {
        tpl : 'libs/requirejs/tpl',
        json2 : 'libs/json2',
        jquery : 'libs/jquery.min',
        underscore : 'libs/lodash.underscore.min',
        backbone : 'libs/backbone-min',
        marionette : 'libs/backbone.marionette.min'
    },
    shim : {
        'backbone' : {
            deps : ['underscore', 'jquery', 'json2', 'tpl'],
            exports : 'Backbone'
        },
        
        'marionette' : {
            deps : ['backbone'],
            exports : 'Marionette'
        }
    }    
});

