<?php

require_once get_stylesheet_directory() . '/ocade-updater.php';
require_once get_stylesheet_directory() . '/hooks/notices.php';
require_once get_stylesheet_directory() . '/hooks/yoast-rest-api.php';

function charger_prism() {
  wp_enqueue_style('prism-css', get_stylesheet_directory_uri() . '/prism/prism.css', [], null);
  wp_enqueue_script('prism-js', get_stylesheet_directory_uri() . '/prism/prism.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'charger_prism');

function personnalisation_gutenberg_colors() {
  add_theme_support('editor-color-palette', [
    ['name'  => __('Orange', 'mon-theme'), 'slug'  => 'orange', 'color' => '#a22f20'],
    ['name'  => __('Bleu', 'mon-theme'), 'slug'  => 'bleu', 'color' => '#1D5670'],
    ['name'  => __('Gris', 'mon-theme'), 'slug'  => 'gris', 'color' => '#f2f2f2'],
    ['name'  => __('Gris Clair', 'mon-theme'), 'slug'  => 'gris-clair', 'color' => '#f4f4f4'],
    ['name'  => __('Nuit', 'mon-theme'), 'slug'  => 'nuit', 'color' => '#32373c'],
    ['name'  => __('Violet', 'mon-theme'), 'slug'  => 'violet', 'color' => '#303579'],
    ['name'  => __('Violet Clair', 'mon-theme'), 'slug'  => 'violet-clair', 'color' => '#ececfe']
  ]);
  add_theme_support('disable-custom-colors');
}
add_action('after_setup_theme', 'personnalisation_gutenberg_colors');

