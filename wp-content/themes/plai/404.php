<?php
session_start();
$header_type = $_SESSION['last_page_type'] ?? 'public';

get_header($header_type === 'private' ? 'private' : 'public');

// Champs
$title = get_field('not_found_title', 'option');
$text = get_field('not_found_text', 'option');
$back_link_label = get_field('not_found_back_link_label', 'option');
$back_link_title = get_field('not_found_back_link_title', 'option');
$image = get_field('not_found_image', 'option');
?>

    <main class="not-found">
        <?php if ($title): ?>
            <h1 class="not-found__title main-title"><?= esc_html($title) ?></h1>
        <?php endif; ?>

        <?php if ($text): ?>
            <p class="not-found__text stage-text"><?= esc_html($text) ?></p>
        <?php endif; ?>

        <?php if ($back_link_label && $back_link_title): ?>
            <a class="not-found__back-link action back"
               href="javascript:history.back()"
               title="<?= esc_attr($back_link_title) ?>">
                <span><?= esc_html($back_link_label) ?></span>
            </a>
        <?php endif; ?>

        <?php if ($image): ?>
            <picture class="not-found__bg">
                <!-- WEBP mobile -->
                <source
                        srcset="<?= get_template_directory_uri() ?>/assets/images/<?= pathinfo($image['filename'], PATHINFO_FILENAME) ?>-mobile.webp"
                        media="(max-width: 699px)"
                        type="image/webp">

                <!-- WEBP desktop -->
                <source
                        srcset="<?= get_template_directory_uri() ?>/assets/images/<?= pathinfo($image['filename'], PATHINFO_FILENAME) ?>-desktop.webp"
                        media="(min-width: 700px)"
                        type="image/webp">

                <!-- Fallback JPG géré par wordpress -->
                <?= wp_get_attachment_image(
                        $image['id'],
                        'plai-full-desktop',
                        false,
                        [
                                'class' => 'not-found__image',
                                'loading' => 'eager',
                                'sizes' => '100vw',
                                'itemprop' => 'image',
                                'alt' => '' // décoratif
                        ]
                ) ?>
            </picture>
        <?php endif; ?>
    </main>

<?php get_footer(); ?>