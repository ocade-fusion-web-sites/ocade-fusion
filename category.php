<?php

$categorie = get_queried_object();
add_filter('ocade_h1', fn($title) => $categorie->name); // Modifier le titre de la page

get_header(); ?>

<main role="main">

  <?php // Vérifier si l'objet catégorie existe et récupérer son slug
  if ($categorie && isset($categorie->slug)) {
    $slug = $categorie->slug;

    // Requête pour vérifier si un CPT 'categorie-articles' a le même slug
    $category_articles_query = new WP_Query(array(
      'post_type'      => 'categorie-articles',
      'post_status'    => 'publish',
      'posts_per_page' => 1,
      'name'           => $slug, // Recherche par slug
      'orderby'        => 'date',
      'order'          => 'DESC',
    ));

    if ($category_articles_query->have_posts()) {
      // Un CPT avec le même slug existe, on l'affiche
      while ($category_articles_query->have_posts()) {
        $category_articles_query->the_post();
        the_content();
      }
    } else {
      // Si aucun CPT n'est trouvé, rechercher le CPT "defaut"
      $default_query = new WP_Query(array(
        'post_type'      => 'categorie-articles',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'name'           => 'defaut', // Recherche par slug "defaut"
      ));

      if ($default_query->have_posts()) {
        while ($default_query->have_posts()) {
          $default_query->the_post();
          the_content();
        }
      } else echo "<p class='alert warning'>Erreur : Aucun modèle trouvé pour '{$slug}'. Veuillez créer un modèle 'Defaut' dans 'Categorie d’articles'.</p>"; // Aucun CPT trouvé ni pour le slug, ni par défaut

      // Nettoyage de la requête "defaut"
      wp_reset_postdata();
    }

    // Nettoyage de la requête principale
    wp_reset_postdata();
  } else echo "<p class='alert error'>Impossible de récupérer le slug de la catégorie.</p>"; // Impossible de récupérer le slug de la catégorie
  ?>

</main>

<?php get_footer();
