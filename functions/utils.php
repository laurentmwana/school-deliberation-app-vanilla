<?php


/**
 * Génère une URL à partir du nom d’une route
 *
 * @param string $name Nom de la route (ex: 'year.show')
 * @param array $params Paramètres à injecter (ex: ['id' => 5])
 * @return string URL générée
 */
function route(string $name, array $params = []): string
{
    if (!isset(ROUTES[$name])) {
        throw new InvalidArgumentException("Route '$name' non définie.");
    }

    $path = ROUTES[$name];

    // Remplace les paramètres dynamiques dans le chemin
    foreach ($params as $key => $value) {
        if (str_contains($path, ':' . $key)) {
            $path = str_replace(':' . $key, (string)$value, $path);
            unset($params[$key]); // déjà utilisé
        }
    }

    // Ajoute les paramètres restants en query string
    if (!empty($params)) {
        $path .= '?' . http_build_query($params);
    }

    return $path;
}

/**
 * Résout une URL et renvoie le nom de la route + ses paramètres.
 *
 * @param string $url URL courante (ex: "/year/12/edit")
 * @return array|null [ 'name' => 'year.edit', 'params' => ['id' => 12] ]
 */
function matchRoute(string $url): ?array
{
    foreach (ROUTES as $name => $pattern) {
        $regex = preg_replace('#:([a-zA-Z_]+)#', '(?P<$1>[^/]+)', $pattern);
        $regex = "#^$regex$#";

        if (preg_match($regex, $url, $matches)) {
            return [
                'name'   => $name,
                'params' => array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY),
            ];
        }
    }
    return null;
}

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
    // URL courante sans query string
    $currentUrl = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

    // Normaliser les deux (supprimer éventuels / finaux sauf pour "/")
    $normalize = function ($u) {
        $u = rtrim($u, '/');
        return $u === '' ? '/' : $u;
    };

    $currentUrl = $normalize($currentUrl);
    $url        = $normalize($url);

    // Vérifie égalité stricte
    return $currentUrl === $url;
}


/**
 * Fournit une connexion PDO unique (pattern Singleton via variable statique).
 *
 * - Utilise une connexion persistante pour éviter de recréer l'objet à chaque appel.
 * - Configure PDO pour lever des exceptions et désactiver l’émulation des requêtes préparées.
 *
 * @return PDO Instance unique de PDO connectée à la base de données.
 */
function getPdo(): PDO
{
    static $pdo = null; 

    if ($pdo === null) {
        try {
            $pdo = new PDO(
                sprintf("mysql:host=localhost;dbname=%s;charset=utf8mb4", DB_NAME),
                DB_USERNAME,
                DB_PWD,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  
                    PDO::ATTR_EMULATE_PREPARES   => false,                 
                ]
            );
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    return $pdo;
}

/**
 * Retourne une date relative en français (ex: "il y a 3 jours", "à l’instant").
 *
 * @param string|DateTime $datetime Date/heure en format compatible avec DateTime (ex: "2025-09-01 12:30:00").
 * @return string Chaîne en français représentant la différence de temps.
 */
function ago(string|DateTime $datetime): string
{
    $now = new DateTime();
    $past = $datetime instanceof DateTime ? $datetime : new DateTime($datetime);
    $diff = $now->diff($past);

    if ($diff->y > 0) {
        return "il y a {$diff->y} an(s)";
    }
    if ($diff->m > 0) {
        return "il y a {$diff->m} m";
    }
    if ($diff->d > 0) {
        return "il y a {$diff->d} jr(s)";
    }
    if ($diff->h > 0) {
        return "il y a {$diff->h} hr(s)";
    }
    if ($diff->i > 0) {
        return "il y a {$diff->i} min(s)";
    }

    return "à l’instant";
}

/**
 * @param mixed[] $args
 * @return void
 */
function dd(mixed ...$args): void
{
    echo "<pre>";
    print_r($args);
    echo "</pre>";
}

/**
 * x
 * @param string $string
 * @param int $length
 * @param string $ellipsis
 * @return string
 */
function excerpt(string $string, int $length = 100, string $ellipsis = "..."): string
{
    if (strlen($string) <= $length) {
        return $string;
    }

    return substr($string, 0, $length) . $ellipsis;
}

