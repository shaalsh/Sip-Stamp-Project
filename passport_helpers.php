<?php

// Define a function for displaying database text safely inside HTML
function passportEscape($value) {
    return htmlspecialchars($value);
}

// Define a function that returns the requested SVG icon
function passportIcon($name) {
    $paths = array(
        "cup" => '<path d="M4 8h12v6a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5V8Z"/><path d="M16 9h2a3 3 0 0 1 0 6h-2M3 22h16M8 2v3M12 2v3"/>',
        "cafe" => '<path d="M3 10h18l-2-6H5l-2 6ZM5 10v10h14V10M9 20v-6h6v6M3 10a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"/>',
        "stamp" => '<path d="M9 15v-3a5 5 0 1 1 6 0v3M6 15h12l2 5H4l2-5ZM4 23h16"/>',
        "lock" => '<rect x="5" y="10" width="14" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/>',
        "pencil" => '<path d="m15 5 4 4M4 20l1-5L16 4a3 3 0 0 1 4 4L9 19l-5 1Z"/>'
    );
    return '<svg class="passport-icon" viewBox="0 0 24 26" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">' . $paths[$name] . '</svg>';
}
