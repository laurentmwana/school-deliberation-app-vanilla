<?php

/**
 * Redirige vers une autre page.
 * 
 * @param string $url L'URL de destination
 * @param int $statusCode Code HTTP de redirection (par défaut 303)
 * @return void
 */
function redirect(string $url, int $statusCode = 303): void
{
    // Empêche l'exécution du reste du script après la redirection
    header("Location: $url", true, $statusCode);
    exit; // Toujours ajouter exit après une redirection
}


/**
 * Vérifie si un menu doit être actif en fonction de l'URL courante.
 *
 * Exemple : pour un menu "Accueil" qui pointe sur "/", 
 * si l'utilisateur est sur "/about", il ne sera pas actif.
 *
 * @param string $url L'URL ou le chemin à comparer (ex : "/about")
 * @return bool Retourne true si l'URL courante contient $url, false sinon
 */
function isMenuActive(string $url): bool
{
    // Récupère l'URL courante, fallback sur "/"
    $currentUrl = $_SERVER['REQUEST_URI'] ?? '/';

    // Vérifie si l'URL demandée est contenue dans l'URL courante
    return str_contains($currentUrl, $url);
}
