<?php

global $_IS_SOMMARY;

/** Récupération du CPT footer. */
$footer_query = new WP_Query(array(
  'post_type' => 'footer',
  'post_status' => 'publish',
  'posts_per_page' => 1,
  'limit' => 1,
  'orderby' => 'date',
  'order' => 'DESC'
)) ?? null; ?>

<footer role="contentinfo" id="footer" class="alignfull" tabindex="0">
  <?php if ($footer_query && $footer_query->have_posts()) : ?>
    <?php while ($footer_query->have_posts()) : $footer_query->the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
  <?php endif; ?>
</footer>

<nav id="mobile-footer-menu" aria-expanded="false" class="alignfull" role="navigation" aria-label="Mobile Footer Menu">
  <ul role="menu">
    <li role="menuitem" class="ocade-search-button"><button id="open-search-modal" title="Effectuer une recherche d'article" onclick="document.getElementById('ocade-search-dialog').showModal();document.getElementById('ocade-search-input').focus();"><span class="skiplink">Effectuer une recherche d'article</span></button></li>
    <?php if ($_IS_SOMMARY) : ?>
      <li role="menuitem" class="sommaire-item">
        <button
          id="sommaire-button" title="Sommaire de la page"
          onclick="(() => {
              const sommaire = document.getElementById('sommaire');
              document.getElementById('menu-principal').setAttribute('aria-expanded', false);
              const expanded = sommaire.getAttribute('aria-expanded') === 'true';
              sommaire.setAttribute('aria-expanded', expanded ? 'false' : 'true');
              if (!expanded) document.getElementById('sommaire-title-link').focus();
            })();">
          <span class="skiplink">Sommaire</span>
        </button>
      </li>
    <?php endif; ?>
    <li role="menuitem" class="go-to-top"><button title="Retour en haut de page" onclick="window.scrollTo({top:0,behavior:'smooth'})"><span class="skiplink">Retour haut de page</span></button></li>
  </ul>
</nav>
<script defer src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/menu-et-sommaire.js"></script>


<script>
  // CHARGEMENT DES SCRIPTS DE LA LIBRAIRIE N8N-DEMO
  function loadScriptWithFallback(primarySrc, fallbackSrc, isModule = false) {
    const script = document.createElement('script');
    script.src = primarySrc;
    script.defer = true;
    script.async = true;
    if (isModule) script.type = 'module';
    script.onerror = () => {
      const fallback = document.createElement('script');
      fallback.src = fallbackSrc;
      fallback.defer = true;
      fallback.async = true;
      if (isModule) fallback.type = 'module';
      document.head.appendChild(fallback);
    };
    document.head.appendChild(script);
  }

  function loadN8nDemoLibrary() {
    loadScriptWithFallback(
      '<?php echo get_stylesheet_directory_uri(); ?>/assets/js/n8n-demo-librairie/webcomponents-loader.js',
      'https://cdn.jsdelivr.net/npm/@webcomponents/webcomponentsjs@2.0.0/webcomponents-loader.js'
    );
    loadScriptWithFallback(
      '<?php echo get_stylesheet_directory_uri(); ?>/assets/js/n8n-demo-librairie/polyfill-support.js',
      'https://unpkg.com/lit@2.0.0-rc.2/polyfill-support.js'
    );
    loadScriptWithFallback(
      '<?php echo get_stylesheet_directory_uri(); ?>/assets/js/n8n-demo-librairie/n8n-demo.bundled.js',
      'https://cdn.jsdelivr.net/npm/@n8n_io/n8n-demo-component@latest/n8n-demo.bundled.js',
      true
    );
  }
  // Observer la présence de <n8n-demo> dans le viewport
  document.addEventListener('DOMContentLoaded', () => {
    const el = document.querySelector('n8n-demo');
    if (!el) return;
    // IntersectionObserver pour ne charger que si l’élément est visible
    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          loadN8nDemoLibrary();
          observer.disconnect(); // Arrêter l’observation
        }
      });
    });
    observer.observe(el);
  });


  /** AU CLICK SUR LE BLOCK YOUTUBE LITE, CHARGEMENT DE L'IFRAME YOUTUBE */
  document.querySelectorAll(".wp-block-ocade-blocks-youtube-lite").forEach((el) => {
    const videoId = el.dataset.videoId;
    const valueLazy = el.dataset.lazyloading;
    const loadIframe = () => {
      const iframe = document.createElement("iframe");
      iframe.src = `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1`;
      iframe.title = "Lecture vidéo YouTube";
      iframe.name = `youtube-video-${videoId}`;
      iframe.loading = valueLazy;
      iframe.allow =
        "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture";
      iframe.allowFullscreen = true;
      iframe.frameBorder = "0";
      iframe.referrerPolicy = "no-referrer";
      iframe.sandbox = "allow-scripts allow-same-origin allow-presentation";
      iframe.style.width = "100%";
      iframe.style.height = "100%";
      iframe.style.border = "none";
      el.innerHTML = ""; // Supprime le fond (background-image)
      el.classList.add("is-playing");
      el.appendChild(iframe);
    };
    // Click souris
    el.addEventListener("click", loadIframe);
    // Accessibilité clavier (Enter ou barre espace)
    el.addEventListener("keydown", (e) => {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        loadIframe();
      }
    });
  });
</script>

<?php /** Implémentation des scripts */ wp_footer(); ?>

</body>

</html>