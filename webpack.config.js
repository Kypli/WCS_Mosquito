// webpack.config.js
var Encore = require('@symfony/webpack-encore');

Encore
// directory where all compiled assets will be stored
    .setOutputPath('web/build/')

    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath('/build')

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // will output as web/build/app.js
    .createSharedEntry('app', './assets/js/main.js')

    // will output as web/build/api.js
    .addEntry('api', './assets/js/apiosm.js')

    // will output as web/build/api.js
    .addEntry('apimap', './assets/js/apimap.js')

    // will output as web/build/auto-specimen.js
    .addEntry('auto-specimen', './assets/js/auto-specimen.js')

    // will output as web/build/global.css
    .addStyleEntry('global', './assets/css/global.scss')


    // allow sass/scss files to be processed
    .enableSassLoader()

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .enableSourceMaps(!Encore.isProduction())

// create hashed filenames (e.g. app.abc123.css)
// .enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();