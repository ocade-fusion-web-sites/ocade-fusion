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
<?php endif; ?>
<script defer src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/menu-et-sommaire.js"></script>

<?php /** Implémentation des scripts */ wp_footer(); ?>

</body>

</html>