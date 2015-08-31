<?php

// 支持中文名
function ludou_non_strict_login( $username, $raw_username, $strict ) {
    if( !$strict )
        return $username;

    return sanitize_user(stripslashes($raw_username), false);
}
add_filter('sanitize_user', 'ludou_non_strict_login', 10, 3);