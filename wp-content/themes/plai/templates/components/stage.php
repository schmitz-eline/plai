<?php
$title = get_sub_field('page_title');
$text = get_sub_field('stage_text');
$secondary_text = get_sub_field('stage_secondary_text');
$home_link = get_sub_field('stage_home_link');
$home_link_label = get_sub_field('stage_home_link_label');
$contact_link = get_sub_field('stage_contact_link');
$contact_link_label = get_sub_field('stage_contact_link_label');
$image = get_sub_field('stage_image');
?>

<section class="stage">
    <?php if ($title): ?>
        <h1 class="stage__title main-title" itemprop="name">
            <?= esc_html($title) ?>
        </h1>
    <?php endif; ?>

    <?php if ($text): ?>
        <p class="stage__text stage-text" itemprop="description">
            <?= esc_html($text) ?>
        </p>
    <?php endif; ?>

    <?php if ($secondary_text): ?>
        <p class="stage__secondary-text stage-secondary-text" itemprop="text">
            <?= esc_html($secondary_text) ?>
        </p>
    <?php endif; ?>

    <?php if ($home_link): ?>
        <a class="stage__home-link action"
           href="<?= esc_url($home_link['url']) ?>"
           title="<?= esc_attr($home_link['title']) ?>">
            <span><?= esc_html($home_link_label) ?></span>
        </a>
    <?php elseif ($contact_link): ?>
        <a class="stage__contact-link action"
           href="<?= esc_url($contact_link['url']) ?>"
           title="<?= esc_attr($contact_link['title']) ?>">
            <span><?= esc_html($contact_link_label) ?></span>
        </a>
    <?php endif; ?>

    <?php if ($image): ?>
        <picture class="stage__bg">
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
                            'class' => 'stage__image',
                            'loading' => 'eager',
                            'sizes' => '100vw',
                            'itemprop' => 'image',
                            'alt' => '' // décoratif
                    ]
            ) ?>
        </picture>
    <?php endif; ?>
</section>