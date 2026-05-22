<?php $image = get_sub_field('falc_image'); ?>

<?php if ($image): ?>
    <picture class="falc__picture">
        <!-- WEBP mobile -->
        <source
                srcset="<?= get_template_directory_uri() ?>/assets/images/<?= pathinfo($image['filename'], PATHINFO_FILENAME) ?>-mobile.webp"
                media="(max-width: 999px)"
                type="image/webp">

        <!-- WEBP desktop -->
        <source
                srcset="<?= get_template_directory_uri() ?>/assets/images/<?= pathinfo($image['filename'], PATHINFO_FILENAME) ?>-desktop.webp"
                media="(min-width: 1000px)"
                type="image/webp">

        <!-- Fallback JPG géré par wordpress -->
        <?= wp_get_attachment_image(
            $image['id'],
            'plai-falc-desktop',
            false,
            [
                'class' => 'falc__image',
                'loading' => 'lazy',
                'sizes' => '(min-width: 700px) 60vw, 80vw',
                'itemprop' => 'image',
                'alt' => esc_attr($image['alt'])
            ]
        ) ?>
    </picture>
<?php endif; ?>