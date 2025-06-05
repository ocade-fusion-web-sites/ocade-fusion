<?php

$tag = get_queried_object();
add_filter('ocade_h1', fn($title) => $tag->name);

get_header(); ?>

<main role="main" aria-label="Contenu principal du site">

  <?php
  // Afficher en haut un bloc tag-articles personnalisé si un CPT correspond au slug de l’étiquette
  if ($tag && isset($tag->slug)) {
    $slug = $tag->slug;

    $tag_articles_query = new WP_Query([
      'post_type'      => 'tag-articles',
      'post_status'    => 'publish',
      'posts_per_page' => 1,
      'name'           => $slug,
      'orderby'        => 'date',
      'order'          => 'DESC',
    ]);

    if ($tag_articles_query->have_posts()) {
      while ($tag_articles_query->have_posts()) {
        $tag_articles_query->the_post();
        the_content();
      }
    } else {
      // Si aucun modèle spécifique, on cherche un modèle "defaut"
      $default_query = new WP_Query([
        'post_type'      => 'tag-articles',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'name'           => 'defaut',
      ]);

      if ($default_query->have_posts()) {
        while ($default_query->have_posts()) {
          $default_query->the_post();
          the_content();
        }
      } else {
        echo "<p class='alert warning'>Aucun modèle trouvé pour l’étiquette « {$slug} » et aucun modèle « defaut » défini.</p>";
      }

      wp_reset_postdata();
    }

    wp_reset_postdata();
  }
  ?>
</main>

<?php get_footer(); ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "<?php echo esc_js($tag->name); ?>",
  "url": "<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
}
</script>