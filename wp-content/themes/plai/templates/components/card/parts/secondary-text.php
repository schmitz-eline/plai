<?php $secondary_text = get_sub_field('card_secondary_text') ?>

<?php if ($secondary_text): ?>
    <p class="card__secondary-text card-secondary-text" itemprop="description">
        <?= esc_html($secondary_text) ?>
    </p>
<?php endif; ?>