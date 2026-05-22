<?php
$awareness_list = get_posts([
        'post_type'      => 'awareness',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'ASC'
]);
?>

<?php if (!empty($awareness_list)) : ?>
    <ul class="card__awareness-list">
        <?php foreach ($awareness_list as $awareness) : ?>
            <li class="card__awareness-list__item card-secondary-text">
                <?= esc_html(get_the_title($awareness)) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>