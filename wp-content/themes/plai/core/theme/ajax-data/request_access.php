<?php

add_action('wp_ajax_request_access', 'ajax_request_access');
add_action('wp_ajax_nopriv_request_access', 'ajax_request_access');

function ajax_request_access(): void
{
    // Récupération des données
    $email = sanitize_email($_POST['email'] ?? '');
    $city_slug = sanitize_text_field($_POST['city'] ?? '');
    $school_slug = sanitize_text_field($_POST['school'] ?? '');

    // Validation de l’adresse email
    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Adresse email invalide.']);
    }

    // Validation de l’adresse email institutionnelle
    $allowed_domains = [
        '@ens.ecl.be',
        '@ecl.be',
        '@neupre.be'
    ];

    $is_valid_email = false;

    foreach ($allowed_domains as $domain) {
        if (str_ends_with($email, $domain)) {
            $is_valid_email = true;
            break;
        }
    }

    if (!$is_valid_email) {
        wp_send_json_error([
            'message' => 'Veuillez utiliser votre adresse email institutionnelle.'
        ]);
    }

    // Validation de la commune
    $city_term = get_term_by('slug', $city_slug, 'city');
    if (!$city_term) {
        wp_send_json_error([
            'message' => 'Commune invalide.'
        ]);
    }

    // Validation de l’école
    $school_post = get_page_by_path($school_slug, OBJECT, 'school');
    if (!$school_post) {
        wp_send_json_error([
            'message' => 'École invalide.'
        ]);
    }

    // Création de la demande
    $post_id = wp_insert_post([
        'post_type' => 'access_request',
        'post_status' => 'publish',
        'post_title' => 'Demande de : ' . $email
    ]);

    if (!$post_id) {
        wp_send_json_error([
            'message' => 'Erreur lors de la création de la demande.'
        ]);
    }

    // Remplir les champs ACF
    update_field('request_email', $email, $post_id);
    update_field('request_city', $city_term->term_id, $post_id);
    update_field('request_school', $school_post->ID, $post_id);
    update_field('request_status', 'pending', $post_id);

    // Réponse
    wp_send_json_success(['ok' => true]);
}