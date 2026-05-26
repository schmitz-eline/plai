import {settings} from "./settings";

const formSubmit = {
    init() {
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll(settings.formSelector).forEach((formElement) => {
                formElement.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    const formData = new FormData(formElement);
                    const response = await fetch(formElement.action, {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    // Erreur
                    if (!result.success) {
                        this.openErrorModal(result.data?.message || 'Une erreur est survenue.');
                        return;
                    }

                    // Succès
                    const type = formElement.dataset.type;

                    if (type === 'register') {
                        this.openSuccessModal();
                    }

                    if (type === 'login') {
                        window.location.href = 'missions';
                    }
                });
            });
        });
    },

    openErrorModal(message) {
        alert(message)
    },

    openSuccessModal() {
        const successTemplateElement = document.getElementById(settings.successTemplateId);
        const modal = successTemplateElement.content.cloneNode(true).firstElementChild;
        document.body.appendChild(modal);

        // Ouverture
        requestAnimationFrame(() => {
            modal.classList.add(settings.modalIsOpenClass);
        });

        // Fermeture
        modal.querySelector(settings.closeButtonSelector).addEventListener('click', () => {
            modal.classList.remove(settings.modalIsOpenClass);
            modal.addEventListener('transitionend', () => {
                modal.remove();
            })
        }, {once: true});
    }
}

formSubmit.init();