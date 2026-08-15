<?php
/**
 * Shared template data (defined here so every partial can rely on them).
 * Returned values come from data/projects.php.
 */
function portfolio_data() {
    static $data = null;
    if ($data === null) {
        $data = include __DIR__ . '/../data/projects.php';
    }
    return $data;
}

function portfolio_profile() {
    $d = portfolio_data();
    return $d['profile'];
}
?>
