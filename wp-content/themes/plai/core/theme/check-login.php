<?php

// Création du cookie d’authentification sécurisé (HMAC)
function plai_login(string $email): void
{
    $signature = hash_hmac('sha256', $email, PLAI_SECRET_KEY);
    $value = $email . '|' . $signature;

    setcookie('plai_auth', $value, time() + 3600 * 24 * 30, '/', '', is_ssl(), true);
}

// Vérifie si l’utilisateur est connecté
function plai_is_logged_in(): bool
{
    if (empty($_COOKIE['plai_auth'])) {
        return false;
    }

    $parts = explode('|', $_COOKIE['plai_auth']);
    if (count($parts) !== 2) {
        return false;
    }

    $email = $parts[0];
    $signature = $parts[1];

    $expected = hash_hmac('sha256', $email, PLAI_SECRET_KEY);

    return hash_equals($expected, $signature);
}

// Déconnexion
function plai_logout(): void
{
    setcookie('plai_auth', '', time() - 3600, '/', '', is_ssl(), true);
}

// Protection des pages privées
function plai_require_login(): void
{
    if (!plai_is_logged_in()) {
        wp_redirect('/connexion');
        exit;
    }
}