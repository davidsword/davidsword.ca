<?php

// [YEARS] shortcode
add_shortcode('years', function ($atts) {
    $a = shortcode_atts(array(
        'since' => date('r')
    ), $atts);
    $then = new DateTime($a['since']);
    $now = new DateTime();
    $interval = date_diff($then, $now);
    return $interval->y;
});

// [skilltags] shortcode
add_shortcode('skilltags', function ($args, $content) {
    $return = '';
    $tags = explode(',', $content);
    foreach ($tags as $tag)
        $return .= "<span class='skilltag'>" . ltrim(rtrim(ltrim($tag))) . "</span> ";
    return "<div class='skilltags'>" . $return . "</div>";
});