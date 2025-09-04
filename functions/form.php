<?php

/**
 * Génère un champ input Bootstrap avec gestion d'erreur depuis la session
 */
function input(string $key, string $type = 'text', ?string $value = null): string
{
    $error = getValidatorError($key);

    // 🔥 On récupère l'ancienne valeur soumise (ou valeur par défaut/DB)
    $value = old($key, $value);

    $isInvalid = $error ? ' is-invalid' : '';
    $errorHtml = $error ? "<div class='invalid-feedback'>{$error}</div>" : '';

    return <<<HTML
<div class="mb-3">
    <label for="{$key}" class="form-label">{$key}</label>
    <input 
        type="{$type}" 
        class="form-control{$isInvalid}" 
        id="{$key}" 
        name="{$key}" 
        value="{$value}">
    {$errorHtml}
</div>
HTML;
}

/**
 * Génère un champ textarea Bootstrap avec gestion d'erreur depuis la session
 */
function textarea(string $key, ?string $value = null, int $rows = 3): string
{
    $error = getValidatorError($key);

    // 🔥 old() gère la récupération
    $value = old($key, $value);

    $isInvalid = $error ? ' is-invalid' : '';
    $errorHtml = $error ? "<div class='invalid-feedback'>{$error}</div>" : '';

    return <<<HTML
<div class="mb-3">
    <label for="{$key}" class="form-label">{$key}</label>
    <textarea 
        class="form-control{$isInvalid}" 
        id="{$key}" 
        name="{$key}" 
        rows="{$rows}">{$value}</textarea>
    {$errorHtml}
</div>
HTML;
}

/**
 * Génère un champ select Bootstrap avec options dynamiques et gestion d'erreur depuis la session
 */
function select(string $key, array $options, ?string $selected = null): string
{
    $error = getValidatorError($key);

    // 🔥 old() gère la sélection après redirect
    $selected = old($key, $selected);

    $isInvalid = $error ? ' is-invalid' : '';
    $errorHtml = $error ? "<div class='invalid-feedback'>{$error}</div>" : '';

    // Génération des options
    $optionsHtml = '';
    foreach ($options as $value => $label) {
        $isSelected = ($selected == $value) ? ' selected' : '';
        $optionsHtml .= "<option value='{$value}'{$isSelected}>{$label}</option>";
    }

    return <<<HTML
<div class="mb-3">
    <label for="{$key}" class="form-label">{$key}</label>
    <select class="form-select{$isInvalid}" id="{$key}" name="{$key}">
        {$optionsHtml}
    </select>
    {$errorHtml}
</div>
HTML;
}
