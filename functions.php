<?php

require_once get_stylesheet_directory() . '/ocade-updater.php';

function charger_prism() {
  wp_enqueue_style('prism-css', get_stylesheet_directory_uri() . '/prism/prism.css', [], null);
  wp_enqueue_script('prism-js', get_stylesheet_directory_uri() . '/prism/prism.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'charger_prism');