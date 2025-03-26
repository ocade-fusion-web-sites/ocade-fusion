<?php

// Variables globales pour les templates 
global $_IS_SOMMARY;
$_URL_CURRENT =  $_SERVER['REQUEST_URI']; // Récupère l'URL actuelle
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
    <button onclick="document.getElementById('footer').scrollIntoView({ behavior: 'smooth' })" class="skiplink">Pied de page</button>
  </nav>

  <header role="banner" class="alignfull">
    <a href="https://www.ocadefusion.fr/" class="custom-logo-link" rel="home">
      <img
        width="60"
        height="60"
        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svgs/logo.svg"
        class="custom-logo lazy loaded"
        alt="OCADE Fusion est un outil d'automatisation des processus d'intégration de données qui permet aux entreprises de rationaliser leurs opérations et d'améliorer leur efficacité."
        decoding="async"
        fetchpriority="high">
    </a>

    <h1><?php echo apply_filters('ocade_h1', get_the_title()); ?></h1>
    <nav id="menu-principal-nav" role="navigation" aria-label="Menu principal">
      <button id="menu-principal" title="Menu principal" aria-expanded="false" aria-controls="list-menu-principal">
        <svg class="burger" width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
        <svg class="cross" style="display:none" width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
            <li role="menuitem" class="<?php echo ($_URL_CURRENT == '/n8n/installation/installer-n8n-sur-le-cloud/') ? 'current' : ''; ?>">
              <a href="/n8n/installer-n8n-sur-le-cloud/">Sur le Cloud</a>
            </li>
            <li role="menuitem" class="<?php echo ($_URL_CURRENT == '/n8n/installation/installer-n8n-avec-docker-compose/') ? 'current' : ''; ?>">
              <a href="/n8n/installer-n8n-avec-docker-compose/">Avec Docker Compose</a>
            </li>
          </ul>
        </li>

        <li role="menuitem">
          <button aria-controls="menu-noeuds-n8n">Noeuds</button>
          <ul id="menu-noeuds-n8n" role="menu">
            <li role="menuitem" class="<?php echo ($_URL_CURRENT == '/n8n/noeuds/noeud-n8n-edit/') ? 'current' : ''; ?>">
              <a href="/n8n/noeuds/noeud-n8n-edit/">Edit</a>
            </li>
            <li role="menuitem" class="<?php echo ($_URL_CURRENT == '/n8n/noeuds/noeud-n8n-if/') ? 'current' : ''; ?>">
              <a href="/n8n/noeuds/noeud-n8n-if/">If</a>
            </li>
          </ul>
        </li>


        <li role="menuitem" class="<?php echo ($_URL_CURRENT == '/author/ocade-fusion/') ? 'current' : ''; ?>">
          <a href="/author/ocade-fusion/">Qui est Valentin Charrier ?</a>
        </li>
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