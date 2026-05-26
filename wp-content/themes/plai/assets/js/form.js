import {settings} from "./settings";

const form = {
    init() {
        this.citySelectElement = document.getElementById(settings.citySelectId);
        this.cityDefaultText = this.citySelectElement.querySelector(settings.hiddenOptionSelector).textContent;

        this.schoolSelectElement = document.getElementById(settings.schoolSelectId);
        this.schoolDefaultText = this.schoolSelectElement.querySelector(settings.hiddenOptionSelector).textContent;

        // Les écoles sont chargées quand on choisit une commune
        this.citySelectElement.addEventListener('change', () => {
            this.updateSchoolSelect();
            this.loadSchools(this.citySelectElement.value);
        });

        // Les communes sont chargées au début
        document.addEventListener('DOMContentLoaded', () => {
            this.loadCities();
            this.updateSchoolSelect();
            this.createBlockedSchoolsOption();
        });
    },

    // Communes --------------------

    loadCities() {
        fetch('/wp-admin/admin-ajax.php?action=get_cities')
            .then(response => response.json())
            .then(cities => {
                this.updateCitySelect();
                this.createCityOptions(cities);
            })
            .catch(error => console.error('Erreur AJAX communes : ', error));
    },

    updateCitySelect() {
        this.citySelectElement.innerHTML = settings.cityOptionHtml(this.cityDefaultText);
    },

    createCityOptions(cities) {
        cities.forEach(city => {
            const cityOptionElement = document.createElement('option');
            cityOptionElement.value = city.slug;
            cityOptionElement.textContent = city.name;
            this.citySelectElement.appendChild(cityOptionElement);
        });
    },

    // Écoles --------------------

    updateSchoolSelect() {
        this.schoolSelectElement.innerHTML = settings.schoolOptionHtml(this.schoolDefaultText);
    },

    loadSchools(citySlug) {
        if (!citySlug) {
            this.updateSchoolSelect();
            this.createBlockedSchoolsOption();
            return;
        }

        fetch(`/wp-admin/admin-ajax.php?action=get_schools&city=${citySlug}`)
            .then(response => response.json())
            .then(schools => {
                this.updateSchoolSelect();
                this.createSchoolOptions(schools);
            })
            .catch(error => console.error('Erreur AJAX écoles : ', error));
    },

    createSchoolOptions(schools) {
        schools.forEach((school) => {
            const schoolOptionElement = document.createElement('option');
            schoolOptionElement.value = school.slug;
            schoolOptionElement.textContent = school.name;
            this.schoolSelectElement.appendChild(schoolOptionElement);
        });
    },

    createBlockedSchoolsOption() {
        const blockedSchoolsOptionElement = document.createElement('option');
        blockedSchoolsOptionElement.value = '';
        blockedSchoolsOptionElement.disabled = true;
        blockedSchoolsOptionElement.classList.add(settings.blockedSchoolsClass);
        blockedSchoolsOptionElement.textContent = settings.blockedSchoolText;
        this.schoolSelectElement.appendChild(blockedSchoolsOptionElement);
    }
}

form.init();