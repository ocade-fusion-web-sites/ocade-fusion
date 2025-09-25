<?php
// Header
function Ocade_Link($text, $href, $extra_class = '', $id = '', $target = '_self', $follow = 'follow') {
  $current_url = $_SERVER['REQUEST_URI'];
  $is_active = ($current_url === $href);
  $classes = trim("$extra_class " . ($is_active ? 'current' : ''));
  $class_attr = $classes ? ' class="' . esc_attr($classes) . '"' : '';
  $id_attr = $id ? ' id="' . esc_attr($id) . '"' : '';
  $rel_attr = ' rel="' . esc_attr($follow) . '"';
  $text_attr = ' title="' . esc_attr($text) . '"';
  if ($is_active) $text_attr .= ' aria-current="page"';

  echo '<li role="menuitem"' . $class_attr . '>';
  echo '<a href="' . esc_url($href) . '"' . $id_attr . $text_attr . $rel_attr . ' target="' . esc_attr($target) . '">' . esc_html($text) . '</a>';
  echo '</li>';
}

global $_IS_SOMMARY;
$_URL_CURRENT = $_SERVER['REQUEST_URI'];
$_IS_ARTICLE = is_singular('post');
$_IS_AUTHOR = is_author();
$_IS_SOMMARY = $_IS_ARTICLE || $_IS_AUTHOR;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <!-- Google Analytics avec exclusion IP -->
  <script>
    const blockedIPs = ['31.35.151.43', '80.14.29.51', '57.129.71.26'];
    const blockedSubnets = ['172.68.234.']; // Plage IP (exclusion par début)

    fetch('https://api.ipify.org?format=json')
      .then(res => res.json())
      .then(data => {
        const ip = data.ip;
        const isExactBlocked = blockedIPs.includes(ip);
        const isSubnetBlocked = blockedSubnets.some(prefix => ip.startsWith(prefix));

        if (!isExactBlocked && !isSubnetBlocked) {
          // IP autorisée → injecter Google Analytics
          const gtagScript = document.createElement('script');
          gtagScript.src = "https://www.googletagmanager.com/gtag/js?id=G-2XMPEMWDSK";
          gtagScript.async = true;
          document.head.appendChild(gtagScript);

          window.dataLayer = window.dataLayer || [];

          function gtag() {
            dataLayer.push(arguments);
          }
          gtag('js', new Date());
          gtag('config', 'G-2XMPEMWDSK');
        } else {
          console.log("GA bloqué pour IP : " + ip);
        }
      })
      .catch(err => console.warn("Erreur IP : ", err));
  </script>
  <!-- Fin GA -->

  <!-- Hotjar Tracking Code for https://www.ocadefusion.fr -->
  <script>
      (function(h,o,t,j,a,r){
          h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
          h._hjSettings={hjid:6529563,hjsv:6};
          a=o.getElementsByTagName('head')[0];
          r=o.createElement('script');r.async=1;
          r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
          a.appendChild(r);
      })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
  </script>

  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="max-image-preview:large">

  <link rel="manifest" href="<?php echo get_stylesheet_directory_uri(); ?>/manifest.json">
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" sizes="180x180" href="/favicon.ico">
  <link rel="icon" type="image/x-icon" href="/favicon.ico" />

  <script>
    document.documentElement.classList.add(window.innerWidth < 768 ? 'is-mobile' : 'is-desktop'); // Script ultra légé et util pour charger des async/sync en fonction mobile/desktop
  </script>
  <?php wp_head(); ?>
</head>

<body id="body" data-theme-uri="<?php echo get_stylesheet_directory_uri(); ?>" <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <?php do_action('ocade_search_form'); ?>

  <nav role="navigation" aria-label="Accès rapide">
    <button data-action="open-search" class="skiplink">Recherche Articles</button>
    <button data-action="open-menu" class="skiplink">Menu Principal</button>
    <?php if ($_IS_SOMMARY) : ?>
      <button data-action="open-sommaire" class="skiplink">Sommaire</button>
    <?php endif; ?>
    <button data-action="scroll-footer" class="skiplink">Pied de page</button>
  </nav>

  <header role="banner" aria-label="En-tête du site" class="alignfull">
    <a href="https://www.ocadefusion.fr/" class="custom-logo-link" rel="home">
      <img width="120" height="120"
        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svgs/logo.svg"
        class="custom-logo lazy"
        alt="Logo Ocade Fusion"
        decoding="async"
        loading="lazy"
        fetchpriority="low">
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
          <a href="/" id="entete-accueil-link"><span>Ocade Fusion</span></a>
        </li>
        <li class="entete"><span>N8N</span></li>
        <li role="menuitem">
          <button aria-controls="menu-installation-n8n">Installation</button>
          <ul id="menu-installation-n8n" role="menu">
            <?php Ocade_Link('Sur le Cloud', '/n8n/installation/installer-n8n-sur-le-cloud/'); ?>
            <?php Ocade_Link('Avec Docker Compose', '/n8n/installation/installer-n8n-avec-docker-compose/'); ?>
          </ul>
        </li>
        <li role="menuitem">
          <button aria-controls="menu-credentials-n8n">Credentials</button>
          <ul id="menu-credentials-n8n" role="menu">
            <?php
            Ocade_Link('Discord', '/n8n/credentials/credentials-discord/');
            Ocade_Link('Google', '/n8n/credentials/credentials-google/');
            Ocade_Link('LinkedIn', '/n8n/credentials/credentials-linkedin/');
            ?>
          </ul>
        </li>
        <li role="menuitem">
          <button aria-controls="menu-noeuds-n8n">Noeuds</button>
          <ul id="menu-noeuds-n8n" role="menu">
            <?php
            Ocade_Link('AI Agent', '/n8n/noeuds/ai-agent/');
            Ocade_Link('Basic LLM Chain', '/n8n/noeuds/basic-llm-chain/');
            Ocade_Link('Chat Trigger', '/n8n/noeuds/chat-trigger/');
            Ocade_Link('Classifier Documents', '/n8n/noeuds/classifier-documents/');
            Ocade_Link('Edit', '/n8n/noeuds/edit-fields/');
            Ocade_Link('Form', '/n8n/noeuds/form/');
            Ocade_Link('HTTP Request', '/n8n/noeuds/http-request/');
            Ocade_Link('If', '/n8n/noeuds/if/');
            Ocade_Link('Information Extractor', '/n8n/noeuds/maitrisez-le-noeud-information-extractor/');
            Ocade_Link('Merge', '/n8n/noeuds/maitriser-le-noeud-merge-pour-automatiser-efficacement/');
            Ocade_Link('Schedule Trigger', '/n8n/noeuds/schedule-trigger/');
            Ocade_Link('Switch', '/n8n/noeuds/switch/');
            Ocade_Link('Webhook', '/n8n/noeuds/webhook/');
            ?>
          </ul>
        </li>

        <li role="menuitem">
          <button aria-controls="menu-workflows-n8n">Workflows</button>
          <ul id="menu-workflows-n8n" role="menu">
            <?php
            Ocade_Link('Asynchrone', '/n8n/workflows/asynchrone-lance-en-parallele/');
            Ocade_Link('Extraction Content File', '/n8n/workflows/extraction-content-file/');
            Ocade_Link('MCP Serveur', '/n8n/workflows/serveurs-mcp-model-context-protocol/');
            Ocade_Link('Watermarks', '/n8n/workflows/watermarks/');
            ?>
          </ul>
        </li>

        <li role="menuitem">
          <button aria-controls="menu-actualites-n8n">Actualités</button>
          <ul id="menu-actualites-n8n" role="menu">
            <?php
            Ocade_Link('Automatiser Tâches Répétitives PME', '/actualites/comment-automatiser-les-taches-repetitives-en-pme-sans-embaucher/');
            Ocade_Link('Découvrez Nocodb', '/actualites/integration-airtable-et-nocodb-simplifiee/');
            ?>
          </ul>
        </li>

        <?php
        Ocade_Link("A propos d'Ocade Fusion", '/a-propos-ocade-fusion/');
        Ocade_Link('Qui est Valentin Charrier ?', '/author/ocade-fusion/');
        Ocade_Link('Qualité Web Opquast', '/certificat-opquast/');
        Ocade_Link("Glossaire Ocade Fusion", '/glossaire/');
        Ocade_Link('Plan du site', '/plan-du-site/');
        Ocade_Link('Contact Email', 'mailto:contact@ocadefusion.fr', 'email-link', 'contact-email-link', '_blank');
        Ocade_Link('Contact Téléphone', 'tel:+33634892265', 'phone-link', 'contact-phone-link', '_blank');
        Ocade_Link('Contact Discord', 'https://discordapp.com/users/1175045336490848306', 'discord-link', 'contact-discord-link', '_blank', 'nofollow');
        Ocade_Link("Contact What'sApp", 'https://wa.me/33634892265', 'whatsapp-link', 'contact-whatsapp-link', '_blank', 'nofollow');
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
    <a href="https://wa.me/33634892265" id="contact-whatsapp-link-header" title="Contact What'sApp" rel="nofollow" target="_blank"></a>
    <a href="https://discordapp.com/users/1175045336490848306" id="contact-discord-link-header" title="Contact Discord" rel="nofollow" target="_blank"></a>
  </header>

  <div id="mobile-footer-placeholder">
    <div id="mobile-footer-skeleton">
      <div class="menu-item-placeholder"></div>
      <div class="menu-item-placeholder"></div>
      <div class="menu-item-placeholder"></div>
      <div class="menu-item-placeholder"></div>
      <div class="menu-item-placeholder"></div>
      <div class="menu-item-placeholder media-query-visible-400"></div>
      <div class="menu-item-placeholder media-query-visible-450"></div>
    </div>

  </div>

