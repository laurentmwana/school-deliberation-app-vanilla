<?php

const SESSION_FLASH_MESSAGE_KEY = "FLASH_MESSAGE";
const SESSION_INPUT_ERROR_KEY = "INPUT_ERRORS";

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
function inputError(string $key, string $message): void
{
    $_SESSION[SESSION_INPUT_ERROR_KEY][$key] = $message;
}

/**
 * Récupère le message d'erreur pour un champ et le supprime de la session
 *
 * @param string $key
 * @return string|null
 */
function inputErrors(string $key): ?string
{
    if (!isset($_SESSION[SESSION_INPUT_ERROR_KEY][$key])) {
        return null;
    }

    $message = $_SESSION[SESSION_INPUT_ERROR_KEY][$key];
    unset($_SESSION[SESSION_INPUT_ERROR_KEY][$key]);

    return $message;
}
