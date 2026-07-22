<?php

if (!function_exists('cleanHtml')) {
    /**
     * Sanitize HTML content to prevent XSS while preserving safe formatting tags.
     * Used for TinyMCE editor content from admin users.
     */
    function cleanHtml(string $html): string
    {
        $allowed = implode(',', [
            'p', 'br', 'hr', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'strong', 'b', 'em', 'i', 'u', 's', 'sub', 'sup',
            'ul', 'ol', 'li', 'dl', 'dt', 'dd',
            'a[href|title|target]', 'img[src|alt|width|height|style]',
            'table', 'thead', 'tbody', 'tfoot', 'tr', 'th[colspan|rowspan]', 'td[colspan|rowspan]',
            'blockquote', 'pre', 'code',
            'div[align|class|style]', 'span[class|style]',
            'table[cellpadding|cellspacing|border|style]',
        ]);

        $html = strip_tags($html, '<' . $allowed . '>');

        $html = preg_replace('/\s+on\w+\s*=\s*["\'][^"\']*["\']/i', '', $html);
        $html = preg_replace('/\s+on\w+\s*=\s*\S+/i', '', $html);
        $html = preg_replace('/javascript\s*:/i', '', $html);
        $html = preg_replace('/vbscript\s*:/i', '', $html);
        $html = preg_replace('/data\s*:/i', '', $html);

        return $html;
    }
}
