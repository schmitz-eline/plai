import {settings} from "./settings";

const burger = {
    init() {
        const burgerButtonElement = document.querySelector(settings.burgerButtonSelector);
        const navElement = document.getElementById(settings.navId);

        burgerButtonElement.addEventListener('click', () => {
            const expanded = burgerButtonElement.getAttribute('aria-expanded') === 'true';
            const newState = !expanded;

            if (newState) {
                burgerButtonElement.setAttribute('aria-expanded', 'true');
            } else {
                burgerButtonElement.setAttribute('aria-expanded', 'false');
            }

            burgerButtonElement.classList.toggle(settings.isOpenClass, newState);
            navElement.classList.toggle(settings.isOpenClass, newState);
        });
    }
}

burger.init();