<?php get_template_part('templates/components/head'); ?>

<header class="header header--private" itemscope itemtype="https://schema.org/WPHeader">

    <a class="header__home-link" href="<?php echo site_url('/missions'); ?>" title="Vers la page de nos missions">
        <svg class="icon">
            <use href="<?= get_template_directory_uri() . '/assets/svg/sprite.svg' ?>#logo"></use>
        </svg>
    </a>

    <?php get_template_part('templates/components/burger'); ?>

    <nav class="header__nav" id="nav-menu">
        <?php wp_nav_menu([
                'theme_location' => 'menu_private',
                'container' => false
        ]); ?>
    </nav>

</header>