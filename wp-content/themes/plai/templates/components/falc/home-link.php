<?php
$home_link = get_field('falc_home_link');
$home_link_label = get_field('falc_home_link_label');
?>

<?php if ($home_link && $home_link_label): ?>
    <a class="falc__home-link action-falc"
       href="<?= esc_url($home_link['url']) ?>"
       title="<?= esc_attr($home_link['title']) ?>">
        <span><?= esc_html($home_link_label) ?></span>
    </a>
<?php endif; ?>