let mix = require("laravel-mix");

mix.sass("src/assets/scss/style.scss", "public/assets/css")
    .sourceMaps()
    .options({
        processCssUrls: false,
    });
