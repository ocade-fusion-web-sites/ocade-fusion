<?php

if (is_admin())  require_once get_stylesheet_directory() . '/ocade-updater.php'; // Mettre à jour le thème depuis un dépôt Git

require_once get_stylesheet_directory() . '/hooks/notices.php';
require_once get_stylesheet_directory() . '/hooks/yoast-rest-api.php';

// Supprime les scripts et styles emojis de WordPress 
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
add_action('wp_enqueue_scripts', function () {
  wp_dequeue_style('wp-block-library');
}, 100); // Supprime le CSS de Gutenberg

/*************** CSS ADMIN ***********************************/
function add_editor_style_file() {
  wp_enqueue_style(
    'mon-editor-css-global',
    get_stylesheet_directory_uri() . '/editor.css',
    [],
    filemtime(get_stylesheet_directory() . '/editor.css')
  );
}
add_action('enqueue_block_editor_assets', 'add_editor_style_file');
/***************************************************************/

/************** CSS FRONT ***********************************/
function ocadefusion_enqueue_front_css() {
  $handle = 'front-css-global';
  $dir = get_stylesheet_directory();
  $uri = get_stylesheet_directory_uri();

  $files = [
    'front.min.css',
    'front.css'
  ];

  foreach ($files as $file) {
    $path = $dir . '/' . $file;
    if (file_exists($path)) {
      wp_enqueue_style($handle, $uri . '/' . $file, [], filemtime($path));
      break;
    }
  }
}
add_action('wp_enqueue_scripts', 'ocadefusion_enqueue_front_css', 100);
/***************************************************************/

/************** ACCESSIBILITY ***********************************/
add_action('wp_head', function () {
  $css_relative_path = 'accessconfig/css/accessconfig.min.css';
  $css_full_path = WP_CONTENT_DIR . '/' . $css_relative_path;

  if (file_exists($css_full_path)) {
    $version = filemtime($css_full_path);
    $css_url = content_url($css_relative_path) . '?ver=' . $version;
    ?>
    <link rel="stylesheet" href="<?php echo esc_url($css_url); ?>" media="print" onload="this.media='all'">
    <noscript>
      <link rel="stylesheet" href="<?php echo esc_url($css_url); ?>">
    </noscript>
    <?php
  }
}, 1);

/***************************************************************/

function charger_prism() {
  if (is_singular() && has_block('core/code')) {
    $dir = get_stylesheet_directory();
    $uri = get_stylesheet_directory_uri();

    $css_file = '/prism/prism.css';
    $js_file  = '/prism/prism.js';

    // Version basée sur la date de modification du fichier
    $css_path = $dir . $css_file;
    $js_path  = $dir . $js_file;

    $css_version = file_exists($css_path) ? filemtime($css_path) : null;
    $js_version  = file_exists($js_path)  ? filemtime($js_path)  : null;

    wp_enqueue_style('prism-css', $uri . $css_file, [], $css_version);
    wp_enqueue_script('prism-js', $uri . $js_file, [], $js_version, true);
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

/************************ Google Analytics ***********************************/
function ocadefusion_google_analytics_script() {
  ?>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-2XMPEMWDSK"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-2XMPEMWDSK');
  </script>
  <?php
}
add_action('wp_footer', 'ocadefusion_google_analytics_script', 100);
/***************************************************************/

/************************ HREFLANG ***********************************/
function ocade_print_hreflang() {
  $languages = ['fr', 'en', 'de', 'es', 'hi', 'it', 'ja', 'pl', 'pt', 'th'];

  $current_path = trim($_SERVER['REQUEST_URI'], '/');

  $path_parts = explode('/', $current_path);
  $current_lang = in_array($path_parts[0], $languages) ? $path_parts[0] : 'fr';

  if ($current_lang !== 'fr') {
    array_shift($path_parts);
  }
  $clean_path = implode('/', $path_parts);

  // Ajoute un slash final propre
  $clean_path = $clean_path ? '/' . $clean_path . '/' : '/';

  // Générer l'URL propre
  $url = home_url(($current_lang !== 'fr' ? '/' . $current_lang : '') . $clean_path);
  $url = rtrim($url, '/') . '/'; // Ajout sûr du slash final

  echo '<link rel="alternate" hreflang="' . esc_attr($current_lang) . '" href="' . esc_url($url) . '">' . "\n";

  $url_default = home_url($clean_path);
  $url_default = rtrim($url_default, '/') . '/'; // Ajout sûr du slash final
  echo '<link rel="alternate" hreflang="x-default" href="' . esc_url($url_default) . '">' . "\n";
}
add_action('wp_head', 'ocade_print_hreflang', 1);
/********************************************************************/

/************************ JSON-LD Utilisation Images ***********************************/
// Démarre la capture du HTML avant affichage
add_action('template_redirect', function () {
  ob_start('ocadefusion_inject_jsonld_images');
});

function ocadefusion_inject_jsonld_images($html) {
  if (is_admin() || strpos($html, '<html') === false) return $html; // Ne pas injecter dans l'admin ou si le HTML n'est pas présent
  // Extraction des images dans tout le HTML
  preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $html, $matches);
  $image_urls = [];
  if (!empty($matches[1])) {
    foreach ($matches[1] as $src) {
      if (strpos($src, 'data:image') === 0) continue;
      if (strpos($src, '/') === 0 && strpos($src, '//') !== 0) $src = home_url($src);
      if (strpos($src, 'http') === 0) $image_urls[] = esc_url($src);
    }
  }
  if (!empty($image_urls)) {
    $image_metadata = [];
    foreach ($image_urls as $img_url) {
      $image_metadata[] = [
        "@context" => "https://schema.org",
        "@type" => "ImageObject",
        "contentUrl" => $img_url,
        "license" => "https://ocadefusion.fr/conditions-utilisation-images",
        "acquireLicensePage" => "https://ocadefusion.fr/contact",
        "creator" => [
          "@type" => "Person",
          "name" => "Valentin Charrier"
        ],
        "copyrightNotice" => "© Valentin Charrier " . date('Y'),
        "creditText" => "Valentin Charrier"
      ];
    }
    $jsonld_script = '<script type="application/ld+json">' . wp_json_encode($image_metadata, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>';
    // Injecter juste avant </body>
    $html = str_replace('</body>', $jsonld_script . "\n</body>", $html);
  }
  return $html;
}
/********************************************************************/

/***************************** OWASP Security **********************************/
// Supprimer la balise <meta name="generator" content="WordPress x.x.x" />
remove_action('wp_head', 'wp_generator');

// Supprimer la version des scripts et styles
function ocade_remove_wp_version_from_assets($src) {
  if (strpos($src, 'ver=')) $src = remove_query_arg('ver', $src);
  return $src;
}
add_filter('style_loader_src', 'ocade_remove_wp_version_from_assets', 9999);
add_filter('script_loader_src', 'ocade_remove_wp_version_from_assets', 9999);
add_filter('xmlrpc_enabled', '__return_false');
/********************************************************************/

/****************** Rich Result Enrichir Yoast **********************/
add_action('wp_head', function () {
    ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "@id": "https://www.ocadefusion.fr/#organization",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "1 chemin du vieil availles",
        "addressLocality": "Sèvres-Anxaumont",
        "postalCode": "86800",
        "addressCountry": "FR"
      }
    }
    </script>
    <?php
});
/********************************************************************/