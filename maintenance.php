<?php add_filter('ocade_h1', fn($title) => 'Site en maintenance...'); ?>
<?php get_header(); ?>

<main role="main">

  <?php
  /** Récupération du CPT Actualités. */
  $maintenance_query = new WP_Query(array(
    'post_type' => 'maintenance',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'limit' => 1,
    'orderby' => 'date',
    'order' => 'DESC',
  )) ?? null; ?>

  <?php if ($maintenance_query && $maintenance_query->have_posts()) : ?>
    <?php while ($maintenance_query->have_posts()) : $maintenance_query->the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
  <?php endif; ?>

</main>

<?php get_footer(); ?>