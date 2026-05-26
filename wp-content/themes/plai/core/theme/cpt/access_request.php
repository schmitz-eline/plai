<?php

function plai_cpt_access_requests(): void
{
    $labels = [
            'name' => 'Demandes d’accès',
            'singular_name' => 'Demande d’accès',
            'view_item' => 'Voir la demande d’accès',
            'search_items' => 'Rechercher une demande d’accès',
            'not_found' => 'Aucune demande d’accès trouvée'
    ];

    $args = [
            'labels' => $labels,
            'description' => 'Les demandes d’accès envoyées par les écoles',
            'menu_position' => 32,
            'public' => false,
            'show_ui' => true,
            'menu_icon' => 'dashicons-admin-comments',
            'supports' => array('title')
    ];

    register_post_type('access_request', $args);
}

// Empêcher la création de nouvelles demandes dans l’admin
add_action('admin_menu', function () {
    remove_submenu_page(
            'edit.php?post_type=access_request',
            'post-new.php?post_type=access_request'
    );
});

add_action('admin_head-edit.php', function () {
    $screen = get_current_screen();

    if ($screen->post_type === 'access_request') {
        echo '<style>
            .page-title-action { display:none !important; }
        </style>';
    }
});

add_action('load-post-new.php', function () {
    if (isset($_GET['post_type']) && $_GET['post_type'] === 'access_request') {
        wp_die('La création manuelle de demandes d’accès est désactivée.');
    }
});

// Empêcher la modification du titre de la demande
add_action('admin_head', function () {
    global $post;

    if ($post && $post->post_type === 'access_request') {
        echo '<style>#titlediv { pointer-events:none; opacity:0.6; }</style>';
    }
});

// Empêcher la modification d’un champ dans l’admin, mais les laisser visibles en ajoutant un panneau personnalisé dans le CPT + ajouter les boutons Accepter / Refuser
add_action('acf/input/admin_head', function () {
    global $post;

    if ($post && $post->post_type === 'access_request') {
        echo '<style>
            .acf-field { display:none !important; }
        </style>';
    }
});

add_action('edit_form_after_title', function ($post) {
    if ($post->post_type !== 'access_request') {
        return;
    }

    // Récupérer les champs ACF
    $email = get_field('request_email', $post->ID);
    $city = get_term(get_field('request_city', $post->ID))->name ?? '';
    // école
    $school_id = get_field('request_school', $post->ID);
    $plai_name = get_the_title($school_id);
    $official_name = get_field('school_name', $school_id);
    $fase = get_field('fase_number', $school_id);
    // boutons radio
    $field = get_field_object('request_status', $post->ID);
    $choices = $field['choices'];
    $status = get_field('request_status', $post->ID);
    $status_label = $choices[$status] ?? 'En attente';

    ?>
    <div class="postbox" style="padding: 20px; margin-top: 20px;">
        <h2 style="text-transform: uppercase;padding: 0;">Détails de la demande</h2>

        <p><strong>Adresse email : </strong><a href="mailto:<?= esc_url($email) ?>" title="Envoyer un email"><?= esc_html($email) ?></a></p>
        <p><strong>Commune : </strong><?= esc_html($city) ?></p>
        <p><strong>École (nom PLAI) : </strong><?= esc_html($plai_name) ?></p>
        <p><strong>Nom officiel et numéro FASE : </strong><?= esc_html($official_name) ?> (<?= esc_html($fase) ?>)</p>
        <p><strong>Statut : </strong><?= esc_html($status_label) ?></p>

        <hr style="margin:20px 0;">

        <?php if ($status === 'pending') : ?>
            <a href="<?= admin_url('admin-post.php?action=accept_access_request&id=' . $post->ID) ?>"
               class="button"
               style="background: #27ae60; color: #fff; border: none;">Accepter</a>

            <a href="<?= admin_url('admin-post.php?action=reject_access_request&id=' . $post->ID) ?>"
               class="button"
               style="background: #db4333; color: #fff; border: none; margin-left: 10px">Refuser</a>
        <?php endif; ?>
    </div>
    <?php
});

// Envoi du mail après avoir accepté la demande
add_action('admin_post_accept_access_request', function () {
    $id = intval($_GET['id']);
    $email = get_field('request_email', $id);

    update_field('request_status', 'accepted', $id);

    wp_mail(
            $email,
            'Votre demande d’accès est acceptée',
            "Bonjour,\n\nVotre demande d’accès a été acceptée.\n\nVous pouvez vous connecter ici : " . home_url('/connexion') . "\n\nBonne journée.\n\nL’équipe du PLAI."
    );

    wp_redirect(admin_url('edit.php?post_type=access_request&message=accepted'));
    exit;
});

// Envoi du mail après avoir refusé la demande
add_action('admin_post_reject_access_request', function () {
    $id = intval($_GET['id']);
    $email = get_field('request_email', $id);

    update_field('request_status', 'rejected', $id);

    wp_mail(
            $email,
            'Votre demande d’accès est refusée',
            "Bonjour,\n\nNous sommes désolés, votre demande d’accès a été refusée.\n\nBonne journée.\n\nL’équipe du PLAI."
    );

    wp_redirect(admin_url('edit.php?post_type=access_request&message=rejected'));
    exit;
});

// Ajouter la colonne Statut
add_filter('manage_access_request_posts_columns', function ($columns) {
    $columns['request_status'] = 'Statut';
    return $columns;
});

// Ajouter les données dans la colonne, avec une couleur de fond
add_action('manage_access_request_posts_custom_column', function ($column, $post_id) {

    if ($column === 'request_status') {

        // Champ ACF
        $field = get_field_object('request_status', $post_id);
        $choices = $field['choices'];
        $status = get_field('request_status', $post_id);
        $label = $choices[$status] ?? 'En attente';

        // Couleurs
        $colors = [
                'pending' => '#9b6308',
                'accepted' => '#1c7d44',
                'rejected' => '#ba3021'
        ];

        $bg_colors = [
                'pending' => '#fef3e2',
                'accepted' => '#def7e8',
                'rejected' => '#fae3e1'
        ];

        $color = $colors[$status] ?? '#9b6308';
        $bg_color = $bg_colors[$status] ?? '#fef3e2';

        echo '<span style="
            display: inline-block;
            padding: 4px 8px;
            border: 1px solid ' . $color . ';
            border-radius: 50px;
            color: ' . $color . ';
            font-weight: 600;
            background: ' . $bg_color . ';
            width: 72px;
            text-align: center;
        ">' . esc_html($label) . '</span>';
    }

}, 10, 2);

// Rendre la colonne triable
add_filter('manage_edit-access_request_sortable_columns', function ($columns) {
    $columns['request_status'] = 'request_status';
    return $columns;
});

// Ajouter un filtre par statut
add_action('restrict_manage_posts', function ($post_type) {

    if ($post_type !== 'access_request') {
        return;
    }

    // Récupérer les choices ACF
    $field = get_field_object('request_status', 0);
    if (!$field || empty($field['choices'])) {
        return;
    }

    $choices  = $field['choices'];
    $selected = $_GET['filter_status'] ?? '';

    echo '<select name="filter_status" style="margin-left:8px;">';
    echo '<option value="">Toutes les demandes</option>';

    foreach ($choices as $value => $label) {

        if ($value !== 'pending') {
            $label .= 's';
        }

        echo '<option value="' . esc_attr($value) . '" '
                . selected($selected, $value, false)
                . '>'
                . esc_html($label)
                . '</option>';
    }

    echo '</select>';
});

add_action('pre_get_posts', function ($query) {

    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->get('post_type') !== 'access_request') {
        return;
    }

    // Ordre par défaut : les demandes les plus récentes en haut
    if (!$query->get('orderby')) {
        $query->set('orderby', 'date');
        $query->set('order', 'DESC');
    }

    // filtrer les statuts
    if (!empty($_GET['filter_status'])) {

        $status = sanitize_text_field($_GET['filter_status']);

        $meta_query = $query->get('meta_query');

        if (!is_array($meta_query)) {
            $meta_query = [];
        }

        $meta_query[] = [
                'key'   => 'request_status',
                'value' => $status
        ];

        $query->set('meta_query', $meta_query);
    }
});

// Retirer le filtre par date
add_filter('months_dropdown_results', function ($months, $post_type) {
    if ($post_type === 'access_request') {
        return [];
    }
    return $months;
}, 10, 2);