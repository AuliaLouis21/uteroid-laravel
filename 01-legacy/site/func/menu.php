<?php
function page($include, $slug)
{
    return ($include === $slug) ? 'id="current"' : '';
}

function pageql($slug, $slugql)
{
    // Pastikan nilainya berupa string agar aman di PHP 8
    $slug = (string)($slug ?? '');
    $slugql = (string)($slugql ?? '');

    return ($slug === $slugql) ? 'id="current"' : '';
}
?>