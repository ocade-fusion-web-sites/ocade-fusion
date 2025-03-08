<?php

/** Récupération du CPT footer. */
$footer_query = new WP_Query(array(
  'post_type' => 'footer',
  'post_status' => 'publish',
  'posts_per_page' => 1,
  'limit' => 1,
  'orderby' => 'date',
  'order' => 'DESC'
)) ?? null; ?>

<footer id="footer" tabindex="0">
  <?php if ($footer_query && $footer_query->have_posts()) : ?>
    <?php while ($footer_query->have_posts()) : $footer_query->the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
  <?php endif; ?>
</footer>

<?php /** Implémentation des scripts */ wp_footer(); ?>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const menuButton = document.querySelector('button[aria-controls="menu-principal"]');
    if (!menuButton) return;
    // Gestion du clic pour ouvrir/fermer le menu
    menuButton.addEventListener("click", function() {
      this.setAttribute("aria-expanded", this.getAttribute("aria-expanded") === "true" ? "false" : "true");
    });
    // Gestion de la touche Échap pour fermer le menu
    document.addEventListener("keydown", e => e.key === "Escape" && menuButton.setAttribute("aria-expanded", "false"));
  });
</script>
</body>

</html>