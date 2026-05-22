<?php
/*
Template Name: Nos missions
*/

get_header('private');
?>

    <main class="missions" itemscope itemtype="https://schema.org/WebPage">
        <?php if (have_rows('stage')) : ?>
            <?php while (have_rows('stage')) : the_row() ?>
                <?php get_template_part('templates/components/stage') ?>
            <?php endwhile; ?>
        <?php endif; ?>

        <section class="missions__content" itemprop="mainContentOfPage">
            <h2 class="sro">Nos différentes missions</h2>
            <?php if (have_rows('cards')) : ?>
                <?php while (have_rows('cards')) : the_row() ?>
                    <?php get_template_part('templates/components/card/card') ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </section>
    </main>

<?php get_footer() ?>