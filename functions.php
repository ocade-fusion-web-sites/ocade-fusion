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

  // Vérifie que le fichier existe avant d'injecter le lien
  if (file_exists($css_full_path)) {
    $version = filemtime($css_full_path);
    $css_url = content_url($css_relative_path) . '?ver=' . $version;
    ?>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        setTimeout(function () {
          const link = document.createElement("link");
          link.rel = "stylesheet";
          link.href = "<?php echo esc_url($css_url); ?>";
          link.type = "text/css";
          link.media = "all";
          document.head.appendChild(link);
        }, 3000);
      });
    </script>
    <?php
  }
}, 1); // priorité basse

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

/************************ MATOMO ***********************************/
function ocadefusion_matomo_script() {
?>
  <script>
    (function() {
      const _paq = (window._paq = window._paq || []);
      _paq.push(['disableCookies']);
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      _paq.push(['setTrackerUrl', 'https://matomo.ocadefusion.fr/matomo.php']);
      _paq.push(['setSiteId', '1']);

      const loadMatomo = () => {
        const g = document.createElement('script');
        g.src = 'https://matomo.ocadefusion.fr/matomo.js';
        g.async = true;
        document.head.appendChild(g);
      };

      if ('requestIdleCallback' in window) {
        requestIdleCallback(loadMatomo, {
          timeout: 3000
        });
      } else {
        setTimeout(loadMatomo, 3000);
      }
    })();
  </script>
<?php
}
add_action('wp_footer', 'ocadefusion_matomo_script', 100);
/***************************************************************/
