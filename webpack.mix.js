const mix = require('laravel-mix');

const PATHS = {
    js: 'resources/assets/site/js',
    scss: 'resources/assets/site/scss',
    cache: 'public/site/cache'
};

/* Settings */
mix.options({
    processCssUrls: false,
    terser: { extractComments: false }
});

mix.webpackConfig({
    module: {
        rules: [{
            test: /\.(js|jsx)$/,
            use: [{
                loader: 'babel-loader',
                options: {
                    presets: ['@babel/preset-env']
                }
            }],
            exclude: /(bower_components)/,
        }]
    }
});


/* Assets */
mix.sass(`${PATHS.scss}/app.scss`, PATHS.cache);
mix.sass(`${PATHS.scss}/vendor.scss`, PATHS.cache, { processUrls: true });

mix.js(`${PATHS.js}/app/app.js`, PATHS.cache);
mix.js(`${PATHS.js}/vendor/vendor.js`, PATHS.cache);


/* BrowserSync */
mix.browserSync({
    proxy: process.env.APP_URL
});


/* Versions */
if (mix.inProduction()) {
    mix.version();
}
