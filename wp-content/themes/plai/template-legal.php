<?php
/*
Template Name: Mentions légales
*/

session_start();
$header_type = $_SESSION['last_page_type'] ?? 'public';

get_header($header_type === 'private' ? 'private' : 'public');

// Champs
$int_prop_title = get_field('legal_int_prop_title');
$int_prop_text = get_field('legal_int_prop_text');
$host_title = get_field('legal_host_title');
$host_text = get_field('legal_host_text');
$host_address = get_field('legal_host_address');
$resp_title = get_field('legal_resp_title');
$resp_text = get_field('legal_resp_text');
$rgpd_title = get_field('legal_rgpd_title');
$rgpd_text = get_field('legal_rgpd_text');
?>

    <main class="legal" itemscope itemtype="https://schema.org/WebPage">
        <?php if (have_rows('stage')) : ?>
            <?php while (have_rows('stage')) : the_row() ?>
                <?php get_template_part('templates/components/stage') ?>
            <?php endwhile; ?>
        <?php endif; ?>

        <div class="legal__content" itemprop="mainContentOfPage">
            <ul class="legal__list">
                <li class="legal__item">
                    <article class="legal__article">
                        <?php if ($int_prop_title): ?>
                            <h2 class="legal__title secondary-title"><?= esc_html($int_prop_title) ?></h2>
                        <?php endif; ?>
                        <?php if ($int_prop_text): ?>
                            <p class="legal__text text" itemprop="description">
                                <?= esc_html($int_prop_text) ?>
                            </p>
                        <?php endif; ?>
                    </article>
                </li>

                <li class="legal__item">
                    <article class="legal__article">
                        <?php if ($host_title): ?>
                            <h2 class="legal__title secondary-title"><?= esc_html($host_title) ?></h2>
                        <?php endif; ?>
                        <?php if ($host_text): ?>
                            <div class="legal__text text" itemprop="description">
                                <?= wp_kses_post($host_text) ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($host_address): ?>
                            <address class="legal__address text" itemprop="address">
                                <?= esc_html($host_address) ?>
                            </address>
                        <?php endif; ?>
                    </article>
                </li>

                <li class="legal__item">
                    <article class="legal__article">
                        <?php if ($resp_title): ?>
                            <h2 class="legal__title secondary-title"><?= esc_html($resp_title) ?></h2>
                        <?php endif; ?>
                        <?php if ($resp_text): ?>
                            <p class="legal__text text" itemprop="description">
                                <?= esc_html($resp_text) ?>
                            </p>
                        <?php endif; ?>
                    </article>
                </li>

                <li class="legal__item">
                    <article class="legal__article">
                        <?php if ($rgpd_title): ?>
                            <h2 class="legal__title secondary-title"><?= esc_html($rgpd_title) ?></h2>
                        <?php endif; ?>
                        <?php if ($rgpd_text): ?>
                            <p class="legal__text text" itemprop="description">
                                <?= esc_html($rgpd_text) ?>
                            </p>
                        <?php endif; ?>
                    </article>
                </li>
            </ul>
        </div>
    </main>

<?php get_footer(); ?>