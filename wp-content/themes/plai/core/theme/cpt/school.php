<?php

function plai_cpt_schools(): void
{
    $labels = [
        'name' => 'Écoles',
        'singular_name' => 'École',
        'add_new_item' => 'Ajouter une école',
        'edit_item' => 'Modifier l’école',
        'new_item' => 'Nouvelle école',
        'view_item' => 'Voir l’école',
        'search_items' => 'Rechercher une école',
        'not_found' => 'Aucune école trouvée',
        'not_found_in_trash' => 'Aucune école dans la corbeille'
    ];

    $args = [
        'labels' => $labels,
        'description' => 'Les écoles aidées par le PLAI',
        'menu_position' => 20,
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => ['title', 'custom-fields']
    ];

    register_post_type('school', $args);
}

// Ajouter une colonne Numéro FASE, Commune et Référent
add_filter('manage_school_posts_columns', function ($columns) {
    $columns['fase'] = 'Numéro FASE';
    $columns['commune'] = 'Commune';
    $columns['referent'] = 'Référent';
    return $columns;
});

// Afficher les données dans les colonnes
add_action('manage_school_posts_custom_column', function ($column, $post_id) {
    if ($column === 'fase') {
        echo esc_html(get_field('fase_number', $post_id));
    }

    if ($column === 'commune') {
        $terms = get_the_terms($post_id, 'city');
        if ($terms && !is_wp_error($terms)) {
            echo esc_html($terms[0]->name);
        } else {
            echo '—';
        }
    }

    if ($column === 'referent') {

        $referent = get_field('school_referent', $post_id);

        if ($referent) {
            $first = get_field('referent_first_name', $referent->ID);
            $last = get_field('referent_last_name', $referent->ID);

            echo esc_html(trim("$first $last"));
        } else {
            echo '—';
        }
    }
}, 10, 2);

// Rendre les colonnes triables
add_filter('manage_edit-school_sortable_columns', function ($columns) {
    $columns['fase'] = 'fase';
    $columns['commune'] = 'commune';
    $columns['referent'] = 'referent';
    return $columns;
});

add_action('pre_get_posts', function ($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->get('post_type') !== 'school') {
        return;
    }

    // Ordre alphabétique des titres par défaut
    if ($query->get('post_type') === 'school' && !$query->get('orderby')) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
    }

    // Tri par FASE
    if ($query->get('orderby') === 'fase') {
        $query->set('meta_key', 'fase_number');
        $query->set('orderby', 'meta_value_num');
    }

    // Tri par Commune
    if ($query->get('orderby') === 'commune') {
        $query->set('orderby', 'title');
    }

    // Tri par Référent
    if ($query->get('orderby') === 'referent') {
        $query->set('meta_key', 'school_referent');
        $query->set('orderby', 'meta_value');
    }

    // Filtre Commune
    if (!empty($_GET['city_filter'])) {
        $query->set('tax_query', [
            [
                'taxonomy' => 'city',
                'field' => 'term_id',
                'terms' => intval($_GET['city_filter'])
            ]
        ]);
    }

    // Filtre Référent
    if (!empty($_GET['referent_filter'])) {
        $query->set('meta_query', [
            [
                'key' => 'school_referent',
                'value' => intval($_GET['referent_filter'])
            ]
        ]);
    }
});

// Filtres par communes et par référents (ajouter les dropdowns)
add_action('restrict_manage_posts', function () {
    global $typenow;

    if ($typenow !== 'school') {
        return;
    }

    // Filtre Commune
    $cities = get_terms(['taxonomy' => 'city', 'hide_empty' => false]);
    echo '<select name="city_filter">';
    echo '<option value="">Toutes les communes</option>';
    foreach ($cities as $city) {
        $selected = ($_GET['city_filter'] ?? '') == $city->term_id ? 'selected' : '';
        echo "<option value='{$city->term_id}' $selected>{$city->name}</option>";
    }
    echo '</select>';

    // Filtre Référent
    $referents = get_posts([
        'post_type' => 'referent',
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ]);
    echo '<select name="referent_filter">';
    echo '<option value="">Tous les référents</option>';
    foreach ($referents as $ref) {
        $selected = ($_GET['referent_filter'] ?? '') == $ref->ID ? 'selected' : '';
        echo "<option value='{$ref->ID}' $selected>{$ref->post_title}</option>";
    }
    echo '</select>';
});

// Retirer le filtre par date
add_filter('months_dropdown_results', function ($months, $post_type) {
    if ($post_type === 'school') {
        return [];
    }
    return $months;
}, 10, 2);