<?php if (have_rows('card_detailed_list')) : ?>
    <dl class="card__detailed-list">
        <?php while (have_rows('card_detailed_list')) : the_row() ?>
            <?php
            $title = get_sub_field('card_detailed_list_title');
            $text = get_sub_field('card_detailed_list_text');
            ?>
            <dt class="card__detailed-list__title card-secondary-text"><?= esc_html($title) ?></dt>
            <dd class="card__detailed-list__text text"><?= esc_html($text) ?></dd>
        <?php endwhile; ?>
    </dl>
<?php endif; ?>