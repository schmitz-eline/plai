<?php

function plai_cpt_referents(): void
{
    $labels = [
        'name' => 'Référents',
        'singular_name' => 'Référent',
        'add_new_item' => 'Ajouter un référent',
        'edit_item' => 'Modifier le référent',
        'new_item' => 'Nouveau référent',
        'view_item' => 'Voir le référent',
        'search_items' => 'Rechercher un référent',
        'not_found' => 'Aucun référent trouvé',
        'not_found_in_trash' => 'Aucun référent dans la corbeille'
    ];

    $args = [
        'labels' => $labels,
        'description' => 'Les référents qui travaillent au PLAI',
        'menu_position' => 24,
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-businesswoman',
        'supports' => ['title', 'custom-fields']
    ];

    register_post_type('referent', $args);
}

// Voir les écoles attribuées à chaque référent dans le CPT
add_action('add_meta_boxes', function ($post) {
    global $post;

    add_meta_box(
        'referent_schools_box',
        'Écoles attribuées à ' . esc_html(get_field('referent_first_name', $post->ID) . ' ' . get_field('referent_last_name', $post->ID)),
        'plai_render_referent_schools_box',
        'referent',
        'normal'
    );
});

function plai_render_referent_schools_box($post): void
{
    global $post;

    $schools = get_posts([
        'post_type' => 'school',
        'numberposts' => -1,
        'meta_key' => 'school_referent',
        'meta_value' => $post->ID,
        'orderby' => 'title',
        'order' => 'ASC'
    ]);

    if (empty($schools)) {
        echo '<p>Aucune école attribuée à ' . esc_html(get_field('referent_first_name', $post->ID) . ' ' . get_field('referent_last_name', $post->ID)) . '</p>';
        return;
    }

    echo '
    <table class="widefat fixed striped" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>NOM PLAI</th>
                <th>NOM OFFICIEL ET NUMÉRO FASE</th>
                <th>COMMUNE</th>
            </tr>
        </thead>
        <tbody>
    ';

    foreach ($schools as $school) {

        // Commune (taxonomie city)
        $city_terms = get_the_terms($school->ID, 'city');
        $city = $city_terms && !is_wp_error($city_terms)
            ? $city_terms[0]->name
            : '—';

        // Nom PLAI (titre du CPT school)
        $plai_name = $school->post_title;

        // Nom officiel
        $official_name = get_field('school_name', $school->ID);

        // Numéro FASE
        $fase = get_field('fase_number', $school->ID);

        echo '
        <tr>
            <td>' . esc_html($plai_name) . '</td>
            <td>' . esc_html($official_name) . ' (' . esc_html($fase) . ')</td>
            <td>' . esc_html($city) . '</td>
        </tr>';
    }

    echo '
        </tbody>
    </table>';
}

// Ajouter des colonnes Prénom, Nom et Nombre d’écoles
add_filter('manage_referent_posts_columns', function ($columns) {
    $columns['first_name'] = 'Prénom';
    $columns['last_name'] = 'Nom';
    $columns['school_count'] = 'Nombre d’écoles';
    return $columns;
});

// Afficher les données dans les colonnes
add_action('manage_referent_posts_custom_column', function ($column, $post_id) {
    if ($column === 'first_name') {
        $first_name = get_field('referent_first_name');

        if ($first_name) {
            echo esc_html(trim("$first_name"));
        } else {
            echo '—';
        }
    }

    if ($column === 'last_name') {
        $last_name = get_field('referent_last_name');

        if ($last_name) {
            echo esc_html(trim("$last_name"));
        } else {
            echo '—';
        }
    }

    if ($column === 'school_count') {
        $schools = get_posts([
            'post_type' => 'school',
            'numberposts' => -1,
            'meta_key' => 'school_referent',
            'meta_value' => $post_id
        ]);

        echo count($schools);
    }
}, 10, 2);

// Rendre les colonnes triables
add_filter('manage_edit-referent_sortable_columns', function ($columns) {
    $columns['first_name'] = 'first_name';
    $columns['last_name'] = 'last_name';
    $columns['school_count'] = 'school_count';
    return $columns;
});

add_action('pre_get_posts', function ($query) {

    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->get('post_type') !== 'referent') {
        return;
    }

    $orderby = $query->get('orderby');
    $order = strtoupper($query->get('order') ?: 'ASC');

    // Ordre alphabétique des titres par défaut
    if (!$orderby) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        return;
    }

    // Tri par prénom
    if ($orderby === 'first_name') {
        $query->set('meta_key', 'referent_first_name');
        $query->set('orderby', 'meta_value');
        return;
    }

    // Tri par nom
    if ($orderby === 'last_name') {
        $query->set('meta_key', 'referent_last_name');
        $query->set('orderby', 'meta_value');
        return;
    }

    // Tri par nombre d’écoles
    if ($orderby === 'school_count') {

        // On récupère tous les référents
        $referents = get_posts([
            'post_type' => 'referent',
            'numberposts' => -1
        ]);

        // On construit un tableau [referent_id => count]
        $counts = [];
        foreach ($referents as $ref) {
            $schools = get_posts([
                'post_type' => 'school',
                'numberposts' => -1,
                'meta_key' => 'school_referent',
                'meta_value' => $ref->ID
            ]);
            $counts[$ref->ID] = count($schools);
        }

        // Tri ASC ou DESC
        if ($order === 'ASC') {
            asort($counts);
        } else {
            arsort($counts);
        }

        // IDs triés
        $sorted_ids = array_keys($counts);
        $query->set('meta_query', []);

        // On force WordPress à respecter cet ordre
        $query->set('post__in', $sorted_ids);
        $query->set('orderby', 'post__in');
        $query->set('order', $order);
    }
});

// Retirer le filtre par date
add_filter('months_dropdown_results', function ($months, $post_type) {
    if ($post_type === 'referent') {
        return [];
    }
    return $months;
}, 10, 2);