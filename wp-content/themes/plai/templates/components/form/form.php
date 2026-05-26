<?php

// Champs
$email_label = get_field('form_email_label');
$email_placeholder = get_field('form_email_placeholder');
$city_label = get_field('form_city_label');
$city_default = get_field('form_city_default');
$school_label = get_field('form_school_label');
$school_default = get_field('form_school_default');
$button_label = get_field('form_button_label');

// Type : login ou register
$type = $args['type'] ?? 'login';

// Attribut class du formulaire
$class = ($type === 'login') ? 'login__form' : 'register__form';

// Action du formulaire
$action = ($type === 'login')
        ? '/wp-admin/admin-ajax.php?action=login_user'
        : '/wp-admin/admin-ajax.php?action=request_access';
?>

<?php if ($email_label && $city_label && $school_label && $button_label) : ?>
    <form class="<?= esc_attr($class) ?>"
          action="<?= esc_url($action) ?>"
          method="post"
          data-form
          data-type="<?= esc_attr($type) ?>">

        <div class="form__group <?= esc_attr($class) ?>__group <?= esc_attr($class) ?>__group--email">
            <label for="email"><?= esc_html($email_label) ?></label>
            <input id="email"
                   name="email"
                   type="email"
                   placeholder="<?= esc_attr($email_placeholder) ?>"
                   required>
        </div>

        <div class="form__group <?= esc_attr($class) ?>__group <?= esc_attr($class) ?>__group--city">
            <label for="city"><?= esc_html($city_label) ?></label>
            <select id="city" name="city" required>
                <option value="" selected disabled hidden><?= esc_html($city_default) ?></option>
            </select>
        </div>

        <div class="form__group <?= esc_attr($class) ?>__group <?= esc_attr($class) ?>__group--school">
            <label for="school"><?= esc_html($school_label) ?></label>
            <select id="school" name="school" required>
                <option value="" selected disabled hidden><?= esc_html($school_default) ?></option>
            </select>
        </div>

        <?php get_template_part('templates/components/form/fase-card') ?>

        <button type="submit" class="action-submit">
            <span><?= esc_html($button_label) ?></span>
        </button>
    </form>
<?php endif; ?>