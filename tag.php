<?php

$tag = get_queried_object();
add_filter('ocade_h1', fn($title) => $tag->name); // Modifier le titre de la page

get_header(); ?>

<main role="main" aria-label="Contenu principal du site">

  <?php
  // Vérifier si l'objet tag existe et récupérer son slug
  if ($tag && isset($tag->slug)) {
    $slug = $tag->slug;

    // Requête pour vérifier si un CPT 'tag-articles' a le même slug
    $tag_articles_query = new WP_Query(array(
      'post_type'      => 'tag-articles',
      'post_status'    => 'publish',
      'posts_per_page' => 1,
      'name'           => $slug, // Recherche par slug
      'orderby'        => 'date',
      'order'          => 'DESC',
    ));

    if ($tag_articles_query->have_posts()) {
      // Un CPT avec le même slug existe, on l'affiche
      while ($tag_articles_query->have_posts()) {
        $tag_articles_query->the_post();
        the_content();
      }
    } else {
      // Si aucun CPT n'est trouvé, rechercher le CPT "defaut"
      $default_query = new WP_Query(array(
        'post_type'      => 'tag-articles',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'name'           => 'defaut', // Recherche par slug "defaut"
      ));

      if ($default_query->have_posts()) {
        while ($default_query->have_posts()) {
          $default_query->the_post();
          the_content();
        }
      } else echo "<p class='alert warning'>Erreur : Aucun modèle trouvé pour '{$slug}'. Veuillez créer un modèle 'Defaut' dans 'Etiquettes d’articles'.</p>"; // Aucun CPT trouvé ni pour le slug, ni par défaut

      // Nettoyage de la requête "defaut"
      wp_reset_postdata();
    }

    // Nettoyage de la requête principale
    wp_reset_postdata();
  } else echo "<p class='alert error'>Impossible de récupérer le slug de l'étiquette.</p>"; // Impossible de récupérer le slug de l'étiquette

  ?>

</main>


<?php get_footer();
