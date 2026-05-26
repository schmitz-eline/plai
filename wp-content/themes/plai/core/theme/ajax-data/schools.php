<?php

add_action('wp_ajax_get_schools', 'ajax_get_schools');
add_action('wp_ajax_nopriv_get_schools', 'ajax_get_schools');

function ajax_get_schools(): void
{
    $city_slug = sanitize_text_field($_GET['city']);
    $city_term = get_term_by('slug', $city_slug, 'city');

    if (!$city_term) {
        wp_send_json([]);
    }

    $city_id = $city_term->term_id;

    $schools = get_posts([
        'post_type' => 'school',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
        'tax_query' => [
            [
                'taxonomy' => 'city',
                'field' => 'term_id',
                'terms' => $city_id
            ]
        ]
    ]);

    $response = [];

    foreach ($schools as $school) {
        $fase = get_field('fase_number', $school->ID);
        $name = get_field('school_name', $school->ID);

        $response[] = [
            'id' => $school->ID,
            'slug' => $school->post_name,
            'name' => $name . ' (' . $fase . ')'
        ];
    }

    wp_send_json($response);
}