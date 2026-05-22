<?php if (have_rows('falc_simple_list')) : ?>
    <ul class="falc__simple-list">
        <?php while (have_rows('falc_simple_list')) : the_row() ?>
            <?php $item = get_sub_field('falc_simple_list_item'); ?>
            <li class="falc__simple-list__item falc-text">
                <?= esc_html($item) ?>
            </li>
        <?php endwhile; ?>
    </ul>
<?php endif; ?>