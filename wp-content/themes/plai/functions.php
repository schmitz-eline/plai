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

// Images full-width (stage et page 404)
add_image_size('plai-full-mobile', 768);
add_image_size('plai-full-desktop', 1920);

// Images des cartes
add_image_size('plai-card-mobile', 480);
add_image_size('plai-card-desktop', 720);

// Images de la page FALC
add_image_size('plai-falc-mobile', 600);
add_image_size('plai-falc-desktop', 1200);

// CPT Sensibilisations
function plai_register_cpt_awareness(): void
{
    $labels = [
        'name' => 'Sensibilisations',
        'add_new_item' => 'Ajouter une sensibilisation',
        'edit_item' => 'Modifier la sensibilisation',
        'new_item' => 'Nouvelle sensibilisation',
        'view_item' => 'Voir la sensibilisation',
        'search_items' => 'Rechercher une sensibilisation',
        'not_found' => 'Aucune sensibilisation trouvée',
        'not_found_in_trash' => 'Aucune sensibilisation dans la corbeille'
    ];

    $args = [
        'labels' => $labels,
        'description' => 'Les sensibilisations proposées par le PLAI',
        'menu_position' => 20,
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-lightbulb',
        'supports' => array('title')
    ];

    register_post_type('awareness', $args);
}

add_action('init', 'plai_register_cpt_awareness');

// Assets

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