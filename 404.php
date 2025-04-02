<?php

add_filter('ocade_h1', fn($title) => "Page introuvable..."); // Modifier le titre de la page

get_header(); ?>

<main role="main">

  <?php
  /** Récupération du CPT 404. */
  $error_query = new WP_Query(array(
    'post_type' => '404',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'limit' => 1,
    'orderby' => 'date',
    'order' => 'DESC',
  )) ?? null; ?>

  <?php if ($error_query && $error_query->have_posts()) : ?>
    <?php while ($error_query->have_posts()) : $error_query->the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
  <?php endif; ?>

</main>

<?php get_footer();
