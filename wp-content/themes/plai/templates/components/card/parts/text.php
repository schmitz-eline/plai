<?php $text = get_sub_field('card_text') ?>

<?php if ($text): ?>
    <p class="card__text text" itemprop="description">
        <?= esc_html($text) ?>
    </p>
<?php endif; ?>