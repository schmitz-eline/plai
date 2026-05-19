<?php

// Page FALC
if (is_page('falc')) {
    get_header('falc');
    the_content();
    get_footer('falc');
    return;
}

// Pages privées
$private_pages = ['missions', 'sensibilisations', 'ressources', 'contact'];

if (is_page($private_pages)) {
    get_header('private');
    the_content();
    get_footer();
    return;
}

// Pages publiques
get_header('public');
the_content();
get_footer();