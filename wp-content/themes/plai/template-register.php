<?php
/*
Template Name: Demande d’accès
*/

get_header('public');
?>

    <main class="register" itemscope itemtype="https://schema.org/WebPage">
        <?php if (have_rows('stage')) : ?>
            <?php while (have_rows('stage')) : the_row() ?>
                <?php get_template_part('templates/components/stage') ?>
            <?php endwhile; ?>
        <?php endif; ?>

        <section class="register__content" itemprop="mainContentOfPage">
            <h2 class="sro">Formulaire de demande d’accès</h2>

            <?php get_template_part('templates/components/form/form', null, ['type' => 'register']) ?>

            <?php get_template_part('templates/components/form/modal') ?>

            <?php if (have_rows('cards')) : ?>
                <?php while (have_rows('cards')) : the_row() ?>
                    <?php get_template_part('templates/components/card/card') ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </section>
    </main>

<?php get_footer() ?>