<?php
$title = get_field('form_confirmation_card_title');
$text = get_field('form_confirmation_card_text');
$button = get_field('form_confirmation_card_button_label');
?>

<template id="register-success-modal">
    <div class="card card--pink modal-card">
        <p class="card__title card-title"><?= esc_html($title) ?></p>
        <p class="card__text text"><?= esc_html($text) ?></p>
        <button class="card__close-modal action-modal">
            <span><?= esc_html($button) ?></span>
        </button>
    </div>
</template>