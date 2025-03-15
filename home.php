<?php get_header(); ?>

<?php 
/** Récupération du CPT Actualités. */
  $actualites_query = new WP_Query(array(
    'post_type' => 'actualites',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'limit' => 1,
    'orderby' => 'date',
    'order' => 'DESC',
  )) ?? null; ?>

  <?php if ($actualites_query && $actualites_query->have_posts()) : ?>
    <?php while ($actualites_query->have_posts()) : $actualites_query->the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
  <?php endif;

get_footer(); ?>