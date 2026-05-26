export const settings = {
    // Burger
    burgerButtonSelector: '.burger',
    navId: 'nav-menu',
    isOpenClass: 'is-open',

    // Formulaires
    citySelectId: 'city',
    schoolSelectId: 'school',
    hiddenOptionSelector: 'option[hidden]',
    blockedSchoolText: 'Veuillez d’abord sélectionner la commune de votre école.',
    blockedSchoolsClass: 'blocked-schools',
    cityOptionHtml(text) {
        return `<option value="" selected disabled hidden>${text}</option>`;
    },
    schoolOptionHtml(text) {
        return `<option value="" selected disabled hidden>${text}</option>`;
    },

    // Soumission des formulaires
    formSelector: '[data-form]',
    successTemplateId: 'register-success-modal',
    modalIsOpenClass: 'modal-is-open',
    closeButtonSelector: '.card__close-modal'
}