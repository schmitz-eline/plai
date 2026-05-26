<?php

add_action('wp_ajax_login_user', 'ajax_login_user');
add_action('wp_ajax_nopriv_login_user', 'ajax_login_user');

function ajax_login_user(): void
{
    // Récupération des données
    $email = sanitize_email($_POST['email'] ?? '');
    $school_slug = sanitize_text_field($_POST['school'] ?? '');

    // Validation de l’adresse email
    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Adresse email invalide.']);
    }

    if (!$email || !$school_slug) {
        wp_send_json_error(['message' => 'Email ou école manquant(e).']);
    }

    // Récupérer l’école
    $school_post = get_page_by_path($school_slug, OBJECT, 'school');

    if (!$school_post) {
        wp_send_json_error(['message' => 'École invalide.']);
    }

    // Chercher une demande acceptée correspondant à email + école
    $requests = get_posts([
        'post_type' => 'access_request',
        'numberposts' => 1,
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => 'request_email',
                'value' => $email
            ],
            [
                'key' => 'request_school',
                'value' => $school_post->ID
            ],
            [
                'key' => 'request_status',
                'value' => 'accepted'
            ]
        ]
    ]);

    if (empty($requests)) {
        wp_send_json_error([
            'message' => 'La combinaison de cette adresse email et de cette école est invalide ou n’a pas été acceptée.'
        ]);
    }

    // Connexion sécurisée via le cookie HMAC
    plai_login($email);

    // Succès
    wp_send_json_success([
        'message' => 'Connexion réussie.',
        'redirect' => '/missions'
    ]);
}