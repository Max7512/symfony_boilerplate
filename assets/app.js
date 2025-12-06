import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/base.css';
import './styles/accueil.css';
import './styles/compte.css';
import './styles/connexion-inscription.css';
import './styles/panier.css';
import './styles/vinyle.css';
import './styles/dashboard.css';

const localeSelect = document.getElementById("localeSelect")

const urlLocaleSwitch = "/switch-locale/"

localeSelect.addEventListener("change", (ev) => {
    location.href = urlLocaleSwitch + ev.target.value
})

const rechercheInput = document.getElementById("rechercheInput")

if (rechercheInput)
    rechercheInput.addEventListener("change", (ev) => {
        location.href = `${location.pathname}?search=${rechercheInput.value}`
    })