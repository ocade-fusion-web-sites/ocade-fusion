<?php

$author = get_queried_object();

add_filter('ocade_h1', fn($title) => $author->nickname); // Modifier le titre de la page
get_header(); ?>

<main role="main" aria-label="Contenu principal du site">

  <?php // Vérifier si l'objet catégorie existe et récupérer son slug
  if ($author) {
    $slug = $author->user_nicename;

    // Requête pour vérifier si un CPT 'categorie-articles' a le même slug
    $author_query = new WP_Query(array(
      'post_type'      => 'authors',
      'post_status'    => 'publish',
      'posts_per_page' => 1,
      'name'           => $slug, // Recherche par slug
      'orderby'        => 'date',
      'order'          => 'DESC',
    ));

    if ($author_query->have_posts()) {
      // Un CPT avec le même slug existe, on l'affiche
      while ($author_query->have_posts()) {
        $author_query->the_post();
        the_content();
      }
    } else {
      echo "<p class='alert warning'>Erreur : Aucun modèle trouvé pour '{$authorName}'. Veuillez créer un modèle 'Defaut' dans 'Authors'.</p>"; // Aucun CPT trouvé ni pour le slug, ni par défaut

      // Nettoyage de la requête "defaut"
      wp_reset_postdata();
    }

    // Nettoyage de la requête principale
    wp_reset_postdata();
  } else echo "<p class='alert error'>Impossible de récupérer le slug de l'auteur '{$authorName}'.</p>"; // Impossible de récupérer le slug de la catégorie
  ?>

</main>

<?php get_footer(); ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "<?php echo esc_html($author->nickname); ?>",
  "description": "<?php echo esc_html($author->description); ?>",
  "author": {
    "@type": "Person",
    "name": "<?php echo esc_html($author->display_name); ?>"
  }
}
</script>
