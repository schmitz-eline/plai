<?php

function plai_tax_cities(): void
{
    $labels = [
        'name' => 'Communes',
        'singular_name' => 'Commune'
    ];

    $args = [
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'hierarchical' => false,
    ];

    register_taxonomy('city', ['school'], $args);
}