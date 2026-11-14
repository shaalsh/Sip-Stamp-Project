<?php

// Define a function for displaying database text safely inside HTML
function passportEscape($value) {
    return htmlspecialchars($value);
}

// Return the local image used for this icon
function passportIcon($name) {
    $labels = array(
        "cup" => "Coffee",
        "cafe" => "Cafe",
        "stamp" => "Stamp",
        "lock" => "Account",
        "pencil" => "Edit name"
    );
    return '<img class="passport-icon" src="images/icons/' . $name . '.png" alt="' . $labels[$name] . '">';
}
