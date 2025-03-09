<?php get_header(); ?>

<video
  controls
  autoplay
  muted
  playsinline
  width="100%"
  preload="metadata"
  poster="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/demo-n8n.webp"
  style="margin: 1rem 0;"
>
  <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/videos/demo-n8n.mp4" type="video/mp4">
  <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/videos/demo-n8n.webm" type="video/webm">
  <p>
    Votre navigateur ne supporte pas la vidéo.
    <a href="<?php echo get_stylesheet_directory_uri(); ?>/assets/videos/demo-n8n.mp4">Télécharger la vidéo</a>.
  </p>
</video>

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