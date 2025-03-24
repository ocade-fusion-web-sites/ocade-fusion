<?php

global $_HAS_GO_TO_TOP, $_IS_SOMMARY;

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

<?php if ($_IS_SOMMARY) : ?>
  <nav id="mobile-footer-menu" aria-expanded="false" class="alignfull" role="navigation" aria-label="Mobile Footer Menu">
    <ul role="menu">
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
      <?php if ($_HAS_GO_TO_TOP) : ?>
        <li role="menuitem" class="go-to-top"><button title="Retour en haut de page" onclick="window.scrollTo({top:0,behavior:'smooth'})"><span class="skiplink">Retour haut de page</span></button></li>
      <?php endif; ?>
    </ul>
  </nav>
  <script defer src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/menu-et-sommaire.js"></script>
<?php endif; ?>

<script>
  // Utilitaire pour charger un script avec fallback
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

  // Charger les scripts de la librairie n8n-demo
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
</script>


<?php /** Implémentation des scripts */ wp_footer(); ?>

</body>

</html>