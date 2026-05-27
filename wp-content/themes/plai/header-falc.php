<?php get_template_part('templates/components/head'); ?>

<header class="header header--falc" itemscope itemtype="https://schema.org/WPHeader">

    <a class="header__home-link" href="<?php echo home_url(); ?>" title="Retourner sur la page d’accueil">
        <svg class="icon">
            <use href="<?= get_template_directory_uri() . '/assets/svg/sprite.svg' ?>#logo"></use>
        </svg>
    </a>

    <svg class="icon header__logo-falc">
        <use href="<?= get_template_directory_uri() . '/assets/svg/sprite.svg' ?>#falc"></use>
    </svg>

</header>