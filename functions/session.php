<?php

const SESSION_FLASH_MESSAGE_KEY = "FLASH_MESSAGE";
const SESSION_INPUT_ERROR_KEY = "INPUT_ERRORS";
const SESSION_OLD_INPUT_KEY = 'OLD_INPUTS';


/**
 * Enregistre un message flash en session
 *
 * @param string $key
 * @param string $message
 * @return void
 */
function flashMessage(string $key, string $message): void
{
    $_SESSION[SESSION_FLASH_MESSAGE_KEY][$key] = $message;
}

/**
 * Récupère tous les messages flash et les supprime de la session
 *
 * @return array
 */
function flashMessages(): array
{
    if (!isset($_SESSION[SESSION_FLASH_MESSAGE_KEY])) {
        return [];
    }

    $flashMessages = $_SESSION[SESSION_FLASH_MESSAGE_KEY];
    unset($_SESSION[SESSION_FLASH_MESSAGE_KEY]);
    return $flashMessages;
}

/**
 * Enregistre un message d'erreur pour un champ de formulaire
 *
 * @param string $key
 * @param string $message
 * @return void
 */
function addInputError(string $key, string $message): void
{
    $_SESSION[SESSION_INPUT_ERROR_KEY][$key] = $message;
}

function addInputErrors(array $errors): void
{
    $_SESSION[SESSION_INPUT_ERROR_KEY] = $errors;
}

function clearErrorsInputs(): void
{
    unset($_SESSION[SESSION_INPUT_ERROR_KEY]);
}


/**
 * Récupère le message d'erreur pour un champ et le supprime de la session
 *
 * @param string $key
 * @return string|null
 */
function getValidatorError(string $key): ?string
{
   // On n'affiche l'erreur que si POST existe ou si OLD_INPUTS est présent
    if ((empty($_POST) && empty($_SESSION[SESSION_OLD_INPUT_KEY])) || !isset($_SESSION[SESSION_INPUT_ERROR_KEY][$key])) {
        return null;
    }

    $error = $_SESSION[SESSION_INPUT_ERROR_KEY][$key] ?? null;

    // Une fois affichée, on peut la supprimer
    unset($_SESSION[SESSION_INPUT_ERROR_KEY][$key]);

    return $error;
}



/**
 * Sauvegarde les inputs dans la session avant redirect
 */
function saveOldInputs(array $inputs): void
{
    $_SESSION[SESSION_OLD_INPUT_KEY] = $inputs;
}

/**
 * Récupère une ancienne valeur d'input après redirect
 */
function old(string $key, $default = ''): ?string
{
    if (!isset($_SESSION[SESSION_OLD_INPUT_KEY])) {
        return $default;
    }

    $value = $_SESSION[SESSION_OLD_INPUT_KEY][$key] ?? $default;

    return $value;
}

/**
 * Nettoie les anciennes valeurs après affichage
 */
function clearOldInputs(): void
{
    unset($_SESSION[SESSION_OLD_INPUT_KEY]);
}
