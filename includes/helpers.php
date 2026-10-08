<?php
/**
 * Shared view helpers: escaping, SVG icons, avatars and star ratings.
 * Loaded once by includes/header.php.
 */

if (!function_exists('e')) {
    /** Escape output for HTML. */
    function e($value)
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('icon')) {
    /** Inline SVG icon (Lucide-style, inherits currentColor). */
    function icon($name, $size = 18)
    {
        $paths = [
            'plus'        => '<path d="M5 12h14"/><path d="M12 5v14"/>',
            'briefcase'   => '<path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/>',
            'laptop'      => '<path d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16"/>',
            'code'        => '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>',
            'smartphone'  => '<rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/>',
            'pen-tool'    => '<path d="M15.707 21.293a1 1 0 0 1-1.414 0l-1.586-1.586a1 1 0 0 1 0-1.414l5.586-5.586a1 1 0 0 1 1.414 0l1.586 1.586a1 1 0 0 1 0 1.414z"/><path d="m18 13-1.375-6.874a1 1 0 0 0-.746-.776L3.235 2.028a1 1 0 0 0-1.207 1.207L5.35 15.879a1 1 0 0 0 .776.746L13 18"/><path d="m2.3 2.3 7.286 7.286"/><circle cx="11" cy="11" r="2"/>',
            'frame'       => '<path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><rect width="10" height="8" x="7" y="8" rx="1"/>',
            'arrow-right' => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
            'send'        => '<path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/>',
            'map-pin'     => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
            'clock'       => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
            'file'        => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/>',
            'download'    => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/>',
            'alert'       => '<circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/>',
            'user-plus'   => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/>',
            'mail'        => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
            'lock'        => '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
            'eye'         => '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>',
            'user'        => '<circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/>',
            'info'        => '<circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>',
            'check-circle'=> '<circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>',
            'arrow-left'  => '<path d="m12 19-7-7 7-7"/><path d="M19 12H5"/>',
            'calendar'    => '<path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/>',
            'menu'        => '<line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>',
            'send'          => '<path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/>',
            'download'      => '<path d="M12 15V3"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/>',
            'map-pin'       => '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/>',
            'clock'         => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
            'search'        => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
            'chevron-left'  => '<path d="m15 18-6-6 6-6"/>',
            'chevron-right' => '<path d="m9 18 6-6-6-6"/>',
            'chevron-down'  => '<path d="m6 9 6 6 6-6"/>',
            'check'         => '<path d="M20 6 9 17l-5-5"/>',
            'star'        => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
            'quote'       => '<path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V21z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3z"/>',
        ];

        if (!isset($paths[$name])) {
            return '';
        }

        $filled = in_array($name, ['star', 'quote'], true);
        $attrs  = $filled
            ? 'fill="currentColor" stroke="none"'
            : 'fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"';

        return '<svg xmlns="http://www.w3.org/2000/svg" width="' . (int) $size . '" height="' . (int) $size
            . '" viewBox="0 0 24 24" ' . $attrs . ' aria-hidden="true">' . $paths[$name] . '</svg>';
    }
}

if (!function_exists('avatar')) {
    /**
     * Flat illustrated avatar.
     * $style: 'short' | 'long' | 'bun' | 'glasses'
     */
    function avatar($bg, $hair, $style = 'short', $size = 56)
    {
        $ink = '#1E293B';
        $s   = (int) $size;

        $back = '';
        if ($style === 'long') {
            $back = '<path d="M15 36c-3-16 5-25 17-25s20 9 17 25v14H15z" fill="' . e($hair) . '"/>';
        } elseif ($style === 'bun') {
            $back = '<circle cx="32" cy="10" r="6" fill="' . e($hair) . '"/>';
        }

        $front = '<path d="M20.5 29c-.5-11 6-16 12-16s12 5 11.5 16c-4-5-15-7-23.5 0z" fill="' . e($hair) . '"/>';

        $glasses = '';
        if ($style === 'glasses') {
            $glasses = '<circle cx="27.5" cy="31" r="3.6" fill="none" stroke="' . $ink . '" stroke-width="1.5"/>'
                     . '<circle cx="36.5" cy="31" r="3.6" fill="none" stroke="' . $ink . '" stroke-width="1.5"/>'
                     . '<path d="M31 31h2" stroke="' . $ink . '" stroke-width="1.5"/>';
        }

        return '<svg class="avatar" xmlns="http://www.w3.org/2000/svg" width="' . $s . '" height="' . $s
            . '" viewBox="0 0 64 64" aria-hidden="true">'
            . '<circle cx="32" cy="32" r="32" fill="' . e($bg) . '"/>'
            . $back
            . '<path d="M9 66c0-14 10-21 23-21s23 7 23 21z" fill="#fff" stroke="' . $ink . '" stroke-width="2"/>'
            . '<ellipse cx="32" cy="31" rx="11" ry="13" fill="#fff" stroke="' . $ink . '" stroke-width="2"/>'
            . $front
            . '<circle cx="27.5" cy="31" r="1.3" fill="' . $ink . '"/><circle cx="36.5" cy="31" r="1.3" fill="' . $ink . '"/>'
            . $glasses
            . '<path d="M28.5 37q3.5 3 7 0" fill="none" stroke="' . $ink . '" stroke-width="1.6" stroke-linecap="round"/>'
            . '</svg>';
    }
}

if (!function_exists('stars')) {
    /** Five-star rating; the orange fill width follows the rating (e.g. 4.7 = 94%). */
    function stars($rating)
    {
        $pct = max(0, min(100, ($rating / 5) * 100));
        return '<span class="stars" style="--pct: ' . round($pct) . '%" role="img" aria-label="Rated '
            . e($rating) . ' out of 5">★★★★★</span>';
    }
}