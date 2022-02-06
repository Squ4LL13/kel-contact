/**
 * Init TinyMCE
 */
tinymce.init({
    selector: "textarea",
    language_url: "/languages/fr_FR.js",
    branding: false,
    elementpath: false,
    height: 300,
    max_height: 500,
    min_height: 200,
    max_width: 500,
    min_width: 200,
    content_css: "/assets/css/style.css",
    content_style: "body {padding: 10px;}",
    preview_styles: true,
});
