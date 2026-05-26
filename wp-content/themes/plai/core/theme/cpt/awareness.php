<?php

function plai_cpt_awareness(): void
{
    $labels = [
        'name' => 'Sensibilisations',
        'singular_name' => 'Sensibilisation',
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
        'menu_position' => 24,
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-lightbulb',
        'supports' => ['title', 'custom-fields']
    ];

    register_post_type('awareness', $args);
}