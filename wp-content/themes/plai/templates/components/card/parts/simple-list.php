<?php if (have_rows('card_simple_list')) : ?>
    <ul class="card__simple-list">
        <?php while (have_rows('card_simple_list')) : the_row() ?>
            <?php $item = get_sub_field('card_simple_list_item') ?>
            <li class="card__simple-list__item card-secondary-text"><?= esc_html($item) ?></li>
        <?php endwhile; ?>
    </ul>
<?php endif; ?>