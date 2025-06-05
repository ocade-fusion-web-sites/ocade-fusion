<?php
// Forcer le H1 sur cette page
add_filter('ocade_h1', fn($title) => 'Actualités Ocade Fusion');

get_header();
?>

<main role="main" aria-label="Contenu principal du site">

  <?php
  // Récupération du CPT "actualites"
  $actualites_query = new WP_Query([
    'post_type'      => 'actualites',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ]);
  ?>

  <?php if ($actualites_query->have_posts()) : ?>
    <?php while ($actualites_query->have_posts()) : $actualites_query->the_post(); ?>
      <?php the_content(); // Injecte ici ton bloc Gutenberg ?>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
  <?php endif; ?>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "Ocade Fusion",
  "url": "https://www.ocadefusion.fr/"
}
</script>

<?php get_footer(); ?>
 