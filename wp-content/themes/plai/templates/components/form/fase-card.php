<?php
$title = get_field('form_fase_card_title');
$text = get_field('form_fase_card_text');
?>

<div class="card card--green">
    <?php if ($title) : ?>
        <p class="card__title card__title--info card-title">
            <?= esc_html($title) ?>
        </p>
    <?php endif; ?>

    <?php if ($text) : ?>
        <p class="card__text text">
            <?= esc_html($text) ?>
        </p>
    <?php endif; ?>
</div>