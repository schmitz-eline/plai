<?php get_header('public'); ?>

    <main class="homepage" itemscope itemtype="https://schema.org/WebPage">
        <?php get_template_part('templates/components/stage') ?>

        <section class="homepage__intro">
            <h2 class="sro">Introduction</h2>
            <?php if (have_rows('home_intro_list')): ?>
                <ul class="homepage__intro__list">
                    <?php while (have_rows('home_intro_list')) : the_row() ?>
                        <?php
                        // Sous-champs
                        $intro_title = get_sub_field('home_intro_item_title');
                        $intro_text = get_sub_field('home_intro_item_text');
                        ?>
                        <li class="homepage__intro__item">
                            <article class="homepage__intro__article">
                                <h3 class="homepage__intro__title third-title"><?= esc_html($intro_title) ?></h3>
                                <p class="homepage__intro__text text"><?= esc_html($intro_text) ?></p>
                            </article>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </section>

        <section class="homepage__content">
            <h2 class="sro">Contenu</h2>
            <?php if (have_rows('cards')) : ?>
                <?php while (have_rows('cards')) : the_row() ?>
                    <?php get_template_part('templates/components/card/card') ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </section>
    </main>

<?php get_footer(); ?>