<?php
/*
Template Name: FALC (facile à lire et à comprendre)
*/

get_header('falc');
?>

    <main class="falc" itemscope itemtype="https://schema.org/WebPage" itemprop="mainContentOfPage">
        <h1 class="sro" itemprop="name">FALC (Facile à lire et à comprendre)</h1>

        <?php get_template_part('templates/components/falc/home-link') ?>

        <?php if (have_rows('falc_sections')) : ?>
            <?php while (have_rows('falc_sections')) : the_row() ?>
                <?php get_template_part('templates/components/falc/section/section') ?>
            <?php endwhile; ?>
        <?php endif; ?>

        <?php get_template_part('templates/components/falc/home-link') ?>
    </main>

<?php get_footer('falc') ?>