<?php
$link = get_sub_field('card_link');
$link_label = get_sub_field('card_link_label');
?>

<?php if ($link && $link_label): ?>
    <a class="card__link action page"
       href="<?= esc_url($link['url']) ?>"
       title="<?= esc_attr($link['title']) ?>">
        <span><?= esc_html($link_label) ?></span>
    </a>
<?php endif; ?>