<?php get_template_part('templates/components/head'); ?>

<header class="header header--public" itemscope itemtype="https://schema.org/WPHeader">

    <a class="header__home-link" href="<?php echo home_url(); ?>" title="Retourner sur la page d’accueil">
        <!-- TODO: sprite svg avec <svg> et <use> -->
        <img src="<?= get_template_directory_uri() . '/assets/svg/logo.svg' ?>" alt="Logo du PLAI">
    </a>

    <?php get_template_part('templates/components/burger'); ?>

    <nav class="header__nav" id="nav-menu">
        <?php wp_nav_menu([
                'theme_location' => 'menu_public',
                'container' => false
        ]); ?>
    </nav>

</header>