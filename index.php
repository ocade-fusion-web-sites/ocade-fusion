<?php

get_header(); ?>

<main role="main" aria-label="Contenu principal du site">
  <?php if (have_posts()) {
    while (have_posts()) {
      the_post();
      the_content();
    }
  }
  ?>
</main>

<?php get_footer();
