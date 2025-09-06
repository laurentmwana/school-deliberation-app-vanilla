<?php

/**
 * Génère un champ input Bootstrap avec gestion d'erreur depuis la session
 */
function input(string $key, string $type = 'text', ?string $value = null, ?string $label = null): string
{
    $error = getValidatorError($key);

    $value = old($key, $value);
    $label = $label ?? ucfirst($key);

    $isInvalid = $error ? ' is-invalid' : '';
    $errorHtml = $error ? "<div class='invalid-feedback'>{$error}</div>" : '';

    return <<<HTML
<div class="mb-3">
    <label for="{$key}" class="form-label">{$label}</label>
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
function textarea(string $key, ?string $value = null, int $rows = 3, ?string $label = null): string
{
    $error = getValidatorError($key);

    $value = old($key, $value);
    $label = $label ?? ucfirst($key);

    $isInvalid = $error ? ' is-invalid' : '';
    $errorHtml = $error ? "<div class='invalid-feedback'>{$error}</div>" : '';

    return <<<HTML
<div class="mb-3">
    <label for="{$key}" class="form-label">{$label}</label>
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
function select(string $key, array $options, ?string $selected = null, ?string $label = null): string
{
    $error = getValidatorError($key);

    $selected = old($key, $selected);
    $label = $label ?? ucfirst($key);

    $isInvalid = $error ? ' is-invalid' : '';
    $errorHtml = $error ? "<div class='invalid-feedback'>{$error}</div>" : '';

    $optionsHtml = "<option value=''>Sélectionne une valeur</option>";
    foreach ($options as $value => $optionLabel) {
        $isSelected = ($selected == $value) ? ' selected' : '';
        $optionsHtml .= "<option value='{$value}'{$isSelected}>{$optionLabel}</option>";
    }

    return <<<HTML
<div class="mb-3">
    <label for="{$key}" class="form-label">{$label}</label>
    <select class="form-select{$isInvalid}" id="{$key}" name="{$key}">
        {$optionsHtml}
    </select>
    {$errorHtml}
</div>
HTML;
}
