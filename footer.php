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

<footer id="footer" class="alignfull" tabindex="0">
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
</script>

</body>

</html>
