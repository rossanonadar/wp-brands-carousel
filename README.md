# Yotpo Theme

A starter WordPress theme that uses Webpack to compile JavaScript and SCSS assets.

## Getting started

1. From this theme directory run `npm install` to pull in the build tooling.
2. Use `npm run dev` during development for watched builds, or `npm run build` for a production build.
3. Activate the **Yotpo Theme** inside the WordPress admin.

Compiled assets are emitted to `assets/js/app.js` and `assets/css/app.css` and are automatically versioned in `functions.php` using the file modification time.

## Fonts

- Inter is loaded from Google Fonts inside `src/scss/app.scss`.
- To load an Adobe Fonts (Typekit) kit, either provide the kit ID via the `yotpo_theme_typekit_kit_id` filter, or create an ACF option field named `typekit_kit_id` on the Theme Settings options page. When the kit ID is present the theme enqueues `https://use.typekit.net/{kit-id}.css` automatically.
# wp-brands-carousel
