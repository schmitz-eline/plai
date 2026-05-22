<?php if (have_rows('card_detailed_list')) : ?>
    <dl class="card__detailed-list">
        <?php while (have_rows('card_detailed_list')) : the_row() ?>
            <?php
            $title = get_sub_field('card_detailed_list_title');
            $text = get_sub_field('card_detailed_list_text');
            ?>
            <div class="card__detailed-list__item">
                <?php if ($title) : ?>
                    <dt class="card__detailed-list__title card-secondary-text" itemprop="name">
                        <?= esc_html($title) ?>
                    </dt>
                <?php endif; ?>
                <?php if ($text) : ?>
                    <dd class="card__detailed-list__text text" itemprop="description">
                        <?= esc_html($text) ?>
                    </dd>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </dl>
<?php endif; ?>