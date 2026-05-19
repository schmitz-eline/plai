<button class="burger" aria-expanded="false" aria-controls="nav-menu">
    <span class="burger__icon burger__icon--open">
        <!-- TODO: sprite svg avec <svg> et <use> -->
        <img src="<?= get_template_directory_uri() . '/assets/svg/burger.svg' ?>" alt="">
    </span>

    <span class="burger__icon burger__icon--close">
        <!-- TODO: sprite svg avec <svg> et <use> -->
        <img src="<?= get_template_directory_uri() . '/assets/svg/close-burger.svg' ?>" alt="">
    </span>

    <span class="burger__label">Menu</span>
</button>