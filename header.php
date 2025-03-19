<?php

// Variables globales pour les templates 
global $_HAS_GO_TO_TOP, $_IS_ARTICLE;
$_HAS_GO_TO_TOP = true;
$_IS_ARTICLE = is_singular('post');

?>

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

  <header class="alignfull">
    <?php if (has_custom_logo()) the_custom_logo(); ?>
    <h1><?php echo apply_filters('ocade_h1', get_the_title()); ?></h1>
    <nav role="navigation" aria-label="Menu principal">
      <button id="menu-principal" class="expanded" title="Menu principal" aria-expanded="false" aria-controls="menu-principal">
        <svg class="burger" width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
        <svg class="cross" style="display:none" width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
      </button>

      <ul role="menu" id="list-menu-principal">
        <li class="entete accueil"><a href="/"><span role="presentation">Ocade Fusion</span></a></li>
        <li class="entete"><span role="presentation">N8N</span></li>

        <li role="menuitem">
          <button href="/installation-n8n" aria-controls="menu-installation-n8n">Installation</button>
          <ul id="menu-installation-n8n" role="menu">
            <li role="menuitem"><a href="/n8n/installer-n8n-sur-le-cloud/">Sur le Cloud</a></li>
            <li role="menuitem"><a href="/n8n/installer-n8n-avec-docker-compose/">Avec Docker Compose</a></li>
          </ul>
        </li>

        <li role="menuitem">
          <button href="/noeuds-n8n" aria-controls="menu-noeuds-n8n">Noeuds</button>
          <ul id="menu-noeuds-n8n" role="menu">
            <li role="menuitem"><a href="/noeud-n8n-edit">Edit</a></li>
            <li role="menuitem"><a href="/noeud-n8n-if">If</a></li>
          </ul>
        </li>

        <li role="menuitem"><a href="/agents-ia-n8n">Agents IA</a></li>
        <li role="menuitem"><a href="/workflows-n8n">Workflows</a>
        </li>
      </ul>
    </nav>
    <?php if ($_IS_ARTICLE) : ?>
      <script>
        const sommaireClose = () => {
          document.getElementById('sommaire').setAttribute('aria-expanded', 'false');
          document.getElementById('sommaire-button').classList.remove('expanded');
        }

        const sommaireOpen = () => {
          const sommairePanel = document.getElementById('sommaire');
          if (sommairePanel.getAttribute('aria-expanded') === 'true') {
            sommaireClose();
            return;
          }
          sommairePanel.setAttribute('aria-expanded', 'true');
          document.getElementById('sommaire-button').classList.add('expanded');
        }
      </script>
      <nav class="sommaire expanded" id="sommaire" aria-expanded="false" role="navigation" aria-label="Sommaire">
        <p class="sommaire-title">Sommaire <button onclick="sommaireClose()">Fermer</button></p>
        <ul class="sommaire-list"></ul>
      </nav>
    <?php endif; ?>
  </header>