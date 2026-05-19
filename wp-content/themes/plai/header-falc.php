<?php get_template_part('templates/components/head'); ?>

<header class="header header--falc" itemscope itemtype="https://schema.org/WPHeader">

    <a class="header__home-link" href="<?php echo home_url(); ?>" title="Retourner sur la page d’accueil">
        <!-- TODO: sprite svg avec <svg> et <use> -->
        <img src="<?= get_template_directory_uri() . '/assets/svg/logo.svg' ?>" alt="Logo du PLAI">
    </a>

    <!-- TODO: sprite svg avec <svg> et <use> -->
    <img class="header__logo-falc" src="<?= get_template_directory_uri() . '/assets/svg/falc.svg' ?>" alt="Logo FALC">

</header>