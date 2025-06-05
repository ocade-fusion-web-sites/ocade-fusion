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

  <?php if (have_posts()) : ?>
    <ul class="actualites-list">
      <?php while (have_posts()) : the_post(); ?>
        <li>
          <h2><?php the_title(); ?></h2>
          <p><?php the_excerpt(); ?></p>
        </li>
      <?php endwhile; ?>
    </ul>

    <nav class="pagination" aria-label="Pagination">
      <?php
      echo paginate_links([
        'base' => trailingslashit(get_pagenum_link(1)) . 'page/%#%/',
        'format' => '',
        'current' => max(1, get_query_var('paged')),
        'total' => $GLOBALS['wp_query']->max_num_pages,
        'prev_text' => __('&laquo; Précédent', 'ocade'),
        'next_text' => __('Suivant &raquo;', 'ocade'),
        'type' => 'list',
      ]);
      ?>
    </nav>

  <?php else : ?>
    <p>Aucun article trouvé.</p>
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
