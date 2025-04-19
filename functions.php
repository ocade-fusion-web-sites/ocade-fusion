<?php

if (is_admin())  require_once get_stylesheet_directory() . '/ocade-updater.php'; // Mettre à jour le thème depuis un dépôt Git

require_once get_stylesheet_directory() . '/hooks/notices.php';
require_once get_stylesheet_directory() . '/hooks/yoast-rest-api.php';

// Supprime les scripts et styles emojis de WordPress 
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

function add_editor_style_file() {
  wp_enqueue_style(
    'mon-editor-css-global',
    get_stylesheet_directory_uri() . '/editor.css',
    [],
    filemtime(get_stylesheet_directory() . '/editor.css')
  );
}
add_action('admin_enqueue_scripts', 'add_editor_style_file');

function charger_prism() {
  if (is_singular() && has_block('core/code')) {
    wp_enqueue_style('prism-css', get_stylesheet_directory_uri() . '/prism/prism.css', [], null);
    wp_enqueue_script('prism-js', get_stylesheet_directory_uri() . '/prism/prism.js', [], null, true);
  }
}
add_action('wp_enqueue_scripts', 'charger_prism');

add_filter('script_loader_tag', function ($tag, $handle) {
  if ($handle === 'prism-js') return str_replace('<script ', '<script async ', $tag);
  return $tag;
}, 10, 2);

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


/** Modifier le titre de l'auteur Ocade Fusion dans Yoast SEO */
function custom_author_title_ocadefusion($title) {
  if (is_author('ocade-fusion') || is_author('n8n')) return 'Tutoriels n8n par Ocade Fusion – Automatisation & No Code';
  return $title;
}
add_filter('wpseo_title', 'custom_author_title_ocadefusion');

/** Modifier la description de l'auteur Ocade Fusion dans Yoast SEO */
function custom_author_metadesc_ocadefusion($desc) {
  if (is_author('ocade-fusion') || is_author('n8n')) return 'Retrouvez tous les tutoriels, guides et astuces sur n8n publiés par Ocade Fusion, spécialiste de l’automatisation.';
  return $desc;
}
add_filter('wpseo_metadesc', 'custom_author_metadesc_ocadefusion');