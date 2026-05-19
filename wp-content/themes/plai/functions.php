<?php

include('core/theme/configuration.php');

// Déclaration des menus
register_nav_menu('menu_public', 'Menu du header public');
register_nav_menu('menu_private', 'Menu du header privé');
register_nav_menu('footer', 'Menu du footer');

// Gestion du header pour mentions légales et 404
function track_last_page(): void
{
    if (!session_id()) {
        session_start();
    }

    if (!is_page('mentions-legales') && !is_404()) {
        $_SESSION['last_page_type'] = is_page(['missions', 'sensibilisations', 'ressources', 'contact'])
            ? 'private'
            : 'public';
    }
}

add_action('template_redirect', 'track_last_page');

// Images
add_image_size('plai-mobile', 768);
add_image_size('plai-desktop', 1920);

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