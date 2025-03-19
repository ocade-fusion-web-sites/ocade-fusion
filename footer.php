<?php

global $_HAS_GO_TO_TOP, $_IS_ARTICLE;

/** Récupération du CPT footer. */
$footer_query = new WP_Query(array(
  'post_type' => 'footer',
  'post_status' => 'publish',
  'posts_per_page' => 1,
  'limit' => 1,
  'orderby' => 'date',
  'order' => 'DESC'
)) ?? null; ?>

<footer id="footer" class="alignfull" tabindex="0">
  <?php if ($footer_query && $footer_query->have_posts()) : ?>
    <?php while ($footer_query->have_posts()) : $footer_query->the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
  <?php endif; ?>
</footer>

<?php if ($_IS_ARTICLE) : ?>
  <nav id="mobile-footer-menu" class="alignfull" role="navigation" aria-label="Mobile Footer Menu">
    <ul role="menu">
      <?php if ($_IS_ARTICLE) : ?>
        <li role="menuitem" class="sommaire-item">
          <button id="sommaire-button" title="Sommaire de la page" onclick="sommaireOpen()">
            <span class="skiplink">Sommaire</span>
          </button>
        </li>
      <?php endif; ?>
      <?php if ($_HAS_GO_TO_TOP) : ?>
        <li role="menuitem" class="go-to-top"><button title="Retour en haut de page" onclick="window.scrollTo({top:0,behavior:'smooth'})"><span class="skiplink">Retour haut de page</span></button></li>
      <?php endif; ?>
    </ul>
  </nav>
  <script defer src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/sommaire.js"></script>
<?php endif; ?>

<?php /** Implémentation des scripts */ wp_footer(); ?>

<script>
  // **************** Gestion de l'ouverture/fermeture des menus ****************
  document.addEventListener("DOMContentLoaded", function() {
    const menuButtons = document.querySelectorAll('button[aria-controls]');

    menuButtons.forEach(button => {
      // Gestion du clic pour ouvrir/fermer le menu
      button.addEventListener("click", function() {
        this.setAttribute("aria-expanded", this.getAttribute("aria-expanded") === "true" ? "false" : "true");
      });

      // Gestion de la touche Échap pour fermer le menu correspondant
      document.addEventListener("keydown", function(e) {
        if (e.key === "Escape" && button.getAttribute("aria-expanded") === "true") button.setAttribute("aria-expanded", "false");
      });
    });
  });

  // **************** Gestion des z-index des Panneaux de navigation ****************
  let zIndexCounter = 1000;
  const observer = new MutationObserver(mutations => {
    mutations.forEach(mutation => {
      if (mutation.type === "attributes" && mutation.attributeName === "aria-expanded") {
        let expandedElement = mutation.target;
        let isExpanded = expandedElement.getAttribute("aria-expanded") === "true";
        if (isExpanded) {
          // Vérifier si l'élément est une <nav>, sinon trouver son parent navigation
          let navElement = expandedElement.closest("nav") || expandedElement;
          // Appliquer l'incrémentation du z-index sur la navigation trouvée
          zIndexCounter++;
          navElement.style.zIndex = zIndexCounter;
        }
      }
    });
  });
  // Sélectionne tout les panels (panneau de navigation) et observe les changements d'attribut
  document.querySelectorAll(".expanded").forEach(expandEl => observer.observe(expandEl, {
    attributes: true
  }));

  // **************** Sticky Logo ****************
  let lastScrollY = window.scrollY,
    ticking = false
  const handleScroll = () => {
    let currentScrollY = window.scrollY
    let isAtBottom = window.innerHeight + currentScrollY >= document.documentElement.scrollHeight - 10
    let isAtTop = currentScrollY <= 10
    if (!isAtBottom && !isAtTop)
      document.documentElement.classList.toggle("hide-logo", currentScrollY > lastScrollY)
    lastScrollY = window.scrollY
    ticking = false
  }

  document.addEventListener("scroll", () => {
    if (!ticking) {
      requestAnimationFrame(handleScroll)
      ticking = true
    }
  })
</script>

</body>

</html>