<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <nav role="navigation" aria-label="Accès rapide">
    <a href="#menu-principal" class="skiplink" onclick="document.getElementById('menu-principal').setAttribute('aria-expanded', 'true')">Menu Principal</a>
    <a href="#footer" class="skiplink">Pied de page</a>
  </nav>

  <header>
    <?php if (has_custom_logo()) the_custom_logo(); ?>
    <nav role="navigation" aria-label="Menu principal">
      <button id="menu-principal" title="Menu principal" aria-expanded="false" aria-controls="menu-principal">
        <svg class="burger" width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
        <svg class="cross" style="display:none" width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
      </button>

      <ul  role="menu" id="list-menu-principal">
        <li><span role="presentation">N8N</span></li>
        <li role="menuitem"><a href="/installation-n8n">Installation</a></li>
        <li role="menuitem"><a href="/noeuds-n8n">Noeuds</a></li>
        <li role="menuitem"><a href="/agents-ia-n8n">Agents IA</a></li>
        <li role="menuitem"><a href="/workflows-n8n">Workflows</a>
        </li>
      </ul>
    </nav>
  </header>