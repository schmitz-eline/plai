<?php
/*
Template Name: Contacter le référent
*/

// Récupérer l’école de l’utilisateur connecté
$school_id = get_current_user_school_id();

// Récupérer le référent lié à l’école
$referent = get_field('school_referent', $school_id);

// Récupérer les coordonnées du référent
$first_name = $referent ? get_field('referent_first_name', $referent) : null;
$last_name = $referent ? get_field('referent_last_name', $referent) : null;
$email = $referent ? get_field('referent_email', $referent) : null;
$phone = $referent ? get_field('referent_phone', $referent) : null;

// Page privée qui nécessite une connexion
plai_require_login();

get_header('private');
?>

    <main class="contact" itemscope itemtype="https://schema.org/WebPage">
        <?php if (have_rows('stage')) : ?>
            <?php while (have_rows('stage')) : the_row() ?>
                <?php get_template_part('templates/components/stage') ?>
            <?php endwhile; ?>
        <?php endif; ?>

        <section class="contact__content" itemprop="mainContentOfPage">
            <h2 class="sro">Contactez le référent de votre école</h2>

            <div class="contact__details">
                <?php if ($first_name && $last_name) : ?>
                    <span class="contact__name"><?= esc_html($first_name . ' ' . $last_name) ?></span>

                    <?php if ($email) : ?>
                        <a class="contact__email"
                           href="mailto:<?= esc_html($email) ?>"
                           title="Envoyer un email à <?= esc_attr($first_name . ' ' . $last_name) ?>"
                           target="_blank">
                            <span><?= esc_html($email) ?></span>
                        </a>
                    <?php endif; ?>

                    <?php if ($phone) : ?>
                        <a class="contact__phone"
                           href="tel:<?= esc_html($phone) ?>"
                           title="Téléphoner à <?= esc_attr($first_name . ' ' . $last_name) ?>"
                           target="_blank">
                            <span><?= esc_html($phone) ?></span>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <?php if (have_rows('cards')) : ?>
                <?php while (have_rows('cards')) : the_row() ?>
                    <?php get_template_part('templates/components/card/card') ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </section>
    </main>

<?php get_footer() ?>