<?php
// Champ
$text = get_field('footer_text', 'option');
?>

<footer class="footer" itemscope itemtype="https://schema.org/WPFooter">

    <!-- TODO: sprite svg avec <svg> et <use> -->
    <img src="<?= get_template_directory_uri() . '/assets/svg/logo-footer.svg' ?>" alt="Logo du PLAI">

    <div class="footer__legal">
        <span class="footer__text text"><?= esc_html($text) ?></span>
        <?php wp_nav_menu([
                'theme_location' => 'footer',
                'container' => false
        ]); ?>
    </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>