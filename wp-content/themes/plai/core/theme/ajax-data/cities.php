<?php

add_action('wp_ajax_get_cities', 'ajax_get_cities');
add_action('wp_ajax_nopriv_get_cities', 'ajax_get_cities');

function ajax_get_cities(): void
{
    $cities = get_terms([
        'taxonomy' => 'city',
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC'
    ]);

    $response = [];

    foreach ($cities as $city) {
        $response[] = [
            'id' => $city->term_id,
            'slug' => $city->slug,
            'name' => $city->name
        ];
    }

    wp_send_json($response);
}