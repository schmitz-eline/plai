<?php
/*
Template Name: Ressources
*/

// Récupérer les bonnes sensibilisations à afficher pour l’école de l’utilisateur connecté
$school_id = get_current_user_school_id();
$awareness_list = get_field('followed_awareness', $school_id);

// Page privée qui nécessite une connexion
plai_require_login();

get_header('private');
?>

    <main class="resources" itemscope itemtype="https://schema.org/WebPage">
        <?php if (have_rows('stage')) : ?>
            <?php while (have_rows('stage')) : the_row() ?>
                <?php get_template_part('templates/components/stage') ?>
            <?php endwhile; ?>
        <?php endif; ?>

        <section class="resources__content" itemprop="mainContentOfPage">
            <h2 class="sro">Les ressources disponibles pour votre école</h2>

            <?php if (have_rows('cards')) : ?>
                <?php while (have_rows('cards')) : the_row() ?>

                    <?php if (get_row_layout() === 'card_followed_awareness') : ?>
                        <?php
                        $title = get_sub_field('card_title');
                        $color = get_sub_field('card_color');
                        $color_class = 'card--' . $color;
                        ?>
                        <article class="card <?= esc_attr($color_class) ?>" itemscope
                                 itemtype="https://schema.org/WebPageElement">
                            <?php if ($title) : ?>
                                <h3 class="card__title card-title" itemprop="name">
                                    <?= esc_html($title) ?>
                                </h3>
                                <ul class="card__awareness-list">
                                    <?php if (!empty($awareness_list)) : ?>
                                        <?php foreach ($awareness_list as $awareness) : ?>
                                            <li class="card__awareness-list__item card-secondary-text">
                                                <?= esc_html(get_the_title($awareness)) ?>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <li class="card-secondary-text">Aucune</li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>
                        </article>
                    <?php endif; ?>

                    <?php if (!empty($awareness_list) && (get_row_layout() === 'card_awareness_resources')) : ?>
                        <?php foreach ($awareness_list as $awareness) : ?>
                            <?php
                            $title = get_the_title($awareness);
                            $color = get_sub_field('card_color');
                            $color_class = 'card--' . $color;
                            ?>
                            <article class="card <?= esc_attr($color_class) ?>" itemscope
                                     itemtype="https://schema.org/WebPageElement">
                                <h3 class="card__title card-title" itemprop="name">
                                    <?= esc_html($title) ?>
                                </h3>

                                <ul class="card__resource__list">
                                    <?php if (have_rows('awareness_resources', $awareness)) : ?>
                                        <?php while (have_rows('awareness_resources', $awareness)) : the_row() ?>
                                            <?php
                                            $file = get_sub_field('resource_file');
                                            $link = get_sub_field('resource_link');
                                            $image = get_sub_field('resource_image');
                                            $video = get_sub_field('resource_video');
                                            $description = get_sub_field('resource_description');
                                            ?>

                                            <li class="card__resource-list__item">

                                                <?php if ($file) : ?>
                                                    <a class="card__resource__link card__resource__link--file" href="<?= esc_url($file['url']) ?>"
                                                       title="Télécharger le fichier" target="_blank" download>
                                                        <span class="card__resource__description text"><?= esc_html($description) ?></span>
                                                    </a>

                                                <?php elseif ($link) : ?>
                                                    <a class="card__resource__link card__resource__link--link" href="<?= esc_url($link['url']) ?>"
                                                       title="Ouvrir le lien dans un nouvel onglet" target="_blank">
                                                        <span class="card__resource__description text"><?= esc_html($description) ?></span>
                                                    </a>

                                                <?php elseif ($image) : ?>
                                                    <a class="card__resource__link card__resource__link--image" href="<?= esc_url($image['url']) ?>"
                                                       title="Télécharger l’image" target="_blank" download>
                                                        <span class="card__resource__description text"><?= esc_html($description) ?></span>
                                                    </a>

                                                <?php elseif ($video) : ?>
                                                    <a class="card__resource__link card__resource__link--video" href="<?= esc_url($video['url']) ?>"
                                                       title="Télécharger la vidéo" target="_blank" download>
                                                        <span class="card__resource__description text"><?= esc_html($description) ?></span>
                                                    </a>

                                                <?php else : ?>
                                                    Aucune ressource disponible pour cette sensibilisation
                                                <?php endif; ?>

                                            </li>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </ul>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>

                <?php endwhile; ?>
            <?php endif; ?>
        </section>
    </main>

<?php get_footer() ?>