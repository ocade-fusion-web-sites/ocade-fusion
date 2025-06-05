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

  <?php if (have_posts()) : ?>
    <ul class="tag-posts">
      <?php while (have_posts()) : the_post(); ?>
        <li>
          <h2><?php the_title(); ?></h2>
          <p><?php the_excerpt(); ?></p>
        </li>
      <?php endwhile; ?>
    </ul>

    <nav class="pagination">
      <?php
      echo paginate_links([
        'base'      => trailingslashit(get_pagenum_link(1)) . 'page/%#%/',
        'format'    => '',
        'current'   => max(1, get_query_var('paged')),
        'total'     => $GLOBALS['wp_query']->max_num_pages,
        'prev_text' => __('&laquo; Précédent', 'ocade'),
        'next_text' => __('Suivant &raquo;', 'ocade'),
        'type'      => 'list',
      ]);
      ?>
    </nav>
  <?php else : ?>
    <p>Aucun article trouvé pour cette étiquette.</p>
  <?php endif; ?>

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