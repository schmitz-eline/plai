<?php if (have_rows('falc_detailed_list')) : ?>
    <ul class="falc__detailed-list">
        <?php while (have_rows('falc_detailed_list')) : the_row() ?>
            <?php
            $title = get_sub_field('falc_detailed_list_title');
            $text = get_sub_field('falc_detailed_list_text');
            ?>
            <?php if ($title) : ?>
                <li class="falc__detailed-list__title falc-text">
                    <?= esc_html($title) ?>
                    <?php if ($text) : ?>
                        <ul>
                            <li class="falc__detailed-list__text falc-text"><?= esc_html($text) ?></li>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
        <?php endwhile; ?>
    </ul>
<?php endif; ?>