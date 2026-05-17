<?php

include('core/theme/configuration.php');

function plai_asset(string $filename): string
{
    $manifest_path = get_theme_file_path('public/.vite/manifest.json');

    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), true);

        if (isset($manifest['wp-content/themes/plai/assets/css/styles.scss']) && $filename === 'css') {
            return get_theme_file_uri('public/' . $manifest['wp-content/themes/plai/assets/css/styles.scss']['file']);
        }

        if (isset($manifest['wp-content/themes/plai/assets/js/main.js']) && $filename === 'js') {
            return get_theme_file_uri('public/' . $manifest['wp-content/themes/plai/assets/js/main.js']['file']);
        }
    }

    return get_template_directory_uri() . '/public/' . $filename;
}

function plai_allow_svg_uploads($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'plai_allow_svg_uploads');