<?php

include('core/theme/configuration.php');

// CPT
include('core/theme/cpt/access_request.php');
include('core/theme/cpt/awareness.php');
include('core/theme/cpt/referent.php');
include('core/theme/cpt/school.php');

// Taxonomies
include('core/theme/taxonomies/cities.php');

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
add_action('init', 'plai_cpt_awareness');

// CPT Écoles
add_action('init', 'plai_cpt_schools');

// CPT Référents
add_action('init', 'plai_cpt_referents');

// CPT Demandes d’accès
add_action('init', 'plai_cpt_access_requests');

// Taxonomie Communes
add_action('init', 'plai_tax_cities');

// Charger les données AJAX
foreach (glob(get_template_directory() . '/core/theme/ajax-data/*.php') as $file) {
    require_once $file;
}

// Gérer la connexion / déconnexion + vérifier si l’utilisateur est connecté pour lui donner accès aux pages privées
require_once 'core/theme/check-login.php';

// Déconnexion
add_action('init', function () {
    if (isset($_GET['plai_logout'])) {
        plai_logout();
        wp_redirect('/connexion');
        exit;
    }
});

// Récupérer l’id du CPT École de l’utilisateur connecté
function get_current_user_school_id() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return $_SESSION['user_school_id'] ?? null;
}

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