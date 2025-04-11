<?php
// Fonction utilitaire pour générer un lien dans un <li>
function Ocade_Link($text, $href, $extra_class = '', $id = '') {
  $current_url = $_SERVER['REQUEST_URI'];
  $is_active = ($current_url === $href);
  $classes = trim("$extra_class " . ($is_active ? 'current' : ''));
  $class_attr = $classes ? ' class="' . esc_attr($classes) . '"' : '';
  $id_attr = $id ? ' id="' . esc_attr($id) . '"' : '';

  // Ajout du préfixe si c’est la page active
  if ($is_active) $text = 'Page active : ' . $text;

  $text_attr = ' title="' . esc_attr($text) . '"';

  echo '<li role="menuitem"' . $class_attr . '>';
  echo '<a href="' . esc_url($href) . '"' . $id_attr . $text_attr . '>' . esc_html($text) . '</a>';
  echo '</li>';
}

// Variables globales pour les templates 
global $_IS_SOMMARY;
$_URL_CURRENT = $_SERVER['REQUEST_URI'];
$_IS_ARTICLE = is_singular('post');
$_IS_AUTHOR = is_author();
$_IS_SOMMARY = $_IS_ARTICLE || $_IS_AUTHOR;
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/manifest.json">
  <?php wp_head(); ?>
</head>

<body id="body" <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <?php do_action('ocade_search_form'); ?>

  <nav role="navigation" aria-label="Accès rapide">
    <button onclick="document.getElementById('ocade-search-dialog').showModal();document.getElementById('ocade-search-input').focus();document.body.classList.add('modal-open');" class="skiplink">Recherche Articles</button>
    <button onclick="(function(event){ event.stopPropagation(); document.getElementById('menu-principal').setAttribute('aria-expanded', true); document.getElementById('entete-accueil-link').focus(); })(event)" class="skiplink">Menu Principal</button>
    <?php if ($_IS_SOMMARY) : ?>
      <button class="skiplink" onclick="document.getElementById('menu-principal').setAttribute('aria-expanded', false); document.getElementById('sommaire').setAttribute('aria-expanded', true); document.getElementById('sommaire-title-link').focus();">Sommaire</button>
    <?php endif; ?>
    <button onclick="const footer = document.getElementById('footer'); footer.scrollIntoView({ behavior: 'smooth' }); footer.focus();" class="skiplink">Pied de page</button>
  </nav>

  <header role="banner" class="alignfull">
    <a href="https://www.ocadefusion.fr/" class="custom-logo-link" rel="home">
      <img
        width="60"
        height="60"
        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svgs/logo.svg"
        class="custom-logo lazy loaded"
        alt="OCADE Fusion est un outil d'automatisation des processus d'intégration de données qui permet aux entreprises de rationaliser leurs opérations et d'améliorer leur efficacité."
        decoding="sync"
        loading="eager"
        fetchpriority="auto">
    </a>

    <h1><?php echo apply_filters('ocade_h1', get_the_title()); ?></h1>

    <nav id="menu-principal-nav" role="navigation" aria-label="Menu principal">
      <button id="menu-principal" title="Menu principal" aria-expanded="false" aria-controls="list-menu-principal">
        <svg class="burger" width="34" height="34" viewBox="0 0 24 24" fill="none">
          <path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
        <svg class="cross" style="display:none" width="34" height="34" viewBox="0 0 24 24" fill="none">
          <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
      </button>

      <ul role="menu" id="list-menu-principal">
        <li class="entete accueil <?php echo ($_URL_CURRENT == '/') ? 'current' : ''; ?>">
          <a href="/" id="entete-accueil-link">
            <span role="presentation">Ocade Fusion</span>
          </a>
        </li>
        <li class="entete"><span role="presentation">N8N</span></li>

        <li role="menuitem">
          <button aria-controls="menu-installation-n8n">Installation</button>
          <ul id="menu-installation-n8n" role="menu">
            <?php
            Ocade_Link('Sur le Cloud', '/n8n/installation/installer-n8n-sur-le-cloud/');
            Ocade_Link('Avec Docker Compose', '/n8n/installation/installer-n8n-avec-docker-compose/');
            ?>
          </ul>
        </li>

        <li role="menuitem">
          <button aria-controls="menu-noeuds-n8n">Noeuds</button>
          <ul id="menu-noeuds-n8n" role="menu">
            <?php
            Ocade_Link('Edit', '/n8n/noeuds/edit-fields/');
            Ocade_Link('Form', '/n8n/noeuds/form/');
            Ocade_Link('If', '/n8n/noeuds/if/');
            Ocade_Link('Switch', '/n8n/noeuds/switch/');
            ?>
          </ul>
        </li>

        <?php
        Ocade_Link('Qualité Web Opquast', '/certificat-opquast/');
        Ocade_Link('Qui est Valentin Charrier ?', '/author/ocade-fusion/');
        ?>
      </ul>
    </nav>

    <?php if ($_IS_SOMMARY) : ?>
      <nav class="sommaire" id="sommaire" aria-expanded="false" role="navigation" aria-label="Sommaire">
        <p class="sommaire-title">
          <a href="#body" id="sommaire-title-link" title="Sommaire - Haut de page">Sommaire - Haut de page</a>
          <button onclick="document.getElementById('sommaire').setAttribute('aria-expanded', false); document.getElementById('sommaire-button').focus();">Fermer</button>
        </p>
        <ul class="sommaire-list"></ul>
      </nav>
    <?php endif; ?>
  </header>

  <nav id="mobile-footer-menu" aria-expanded="false" class="alignfull" role="navigation" aria-label="Mobile Footer Menu">
    <ul role="menu">
      <li role="menuitem" class="ocade-search-button">
        <button id="open-search-modal" title="Effectuer une recherche d'article" onclick="document.getElementById('ocade-search-dialog').showModal();document.getElementById('ocade-search-input').focus();document.body.classList.add('modal-open');"></button>
      </li>
      <?php if ($_IS_SOMMARY) : ?>
        <li role="menuitem" class="sommaire-item">
          <button
            id="sommaire-button"
            title="Sommaire de la page"
            aria-label="Sommaire de la page"
            onclick="(() => {
            const sommaire = document.getElementById('sommaire');
            document.getElementById('menu-principal').setAttribute('aria-expanded', false);
            const expanded = sommaire.getAttribute('aria-expanded') === 'true';
            sommaire.setAttribute('aria-expanded', expanded ? 'false' : 'true');
            if (!expanded) document.getElementById('sommaire-title-link').focus();
          })();">
          </button>
        </li>
      <?php endif; ?>
      <li role="menuitem" class="formulaire-contact">
        <button title="Remplir une demande de contact" onclick="window.location.href='/contact/'"></button>
      </li>
      <li role="menuitem" class="formulaire-tel">
        <button title="Téléphone à OCade Fusion" onclick="window.location.href='tel:0634892265';"></button>
      </li>
      <li role="menuitem" class="go-to-top">
        <button title="Retour en haut de page" onclick="window.scrollTo({top:0,behavior:'smooth'})"></button>
      </li>
    </ul>
  </nav>