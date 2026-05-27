<button class="burger" aria-expanded="false" aria-controls="nav-menu">
    <span class="burger__icon burger__icon--open">
        <svg class="icon">
            <use href="<?= get_template_directory_uri() . '/assets/svg/sprite.svg' ?>#burger"></use>
        </svg>
    </span>

    <span class="burger__icon burger__icon--close">
        <svg class="icon">
            <use href="<?= get_template_directory_uri() . '/assets/svg/sprite.svg' ?>#close-burger"></use>
        </svg>
    </span>

    <span class="burger__label">Menu</span>
</button>