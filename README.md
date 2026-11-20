# simplesamlphp-notakey-theme

Simple responsive theme for SimpleSAMLphp.

Version 2.x requires SimpleSAMLphp 2.5 or newer and PHP 8.3 or newer. Use 1.x releases with SimpleSAMLphp 1.x.

## Configuration

`config/config.php`:

```php
'module.enable' => ['ntktheme' => true],
'theme.use' => 'ntktheme:ntktheme',
'theme.controller' => '\SimpleSAML\Module\ntktheme\NtkThemeController',
// optional
'webapptitle' => 'SSO login',          // or ['en' => '...', 'lv' => '...']
'footer.tagline' => '...',             // or per-language array
'customcss' => '/userlogos/custom.css', // must be same-origin with the default security headers
'favicon' => '/userlogos/favicon.png',
```

## Building the stylesheet

```shell
npm install
npm run build
```

The build writes `public/assets/css/stylesheet.css` and copies the Font Awesome fonts to `public/assets/fonts/`.
Node.js 12 is required (node-sass 4.x).
