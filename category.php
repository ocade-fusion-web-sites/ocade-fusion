<?php

$categorie = get_queried_object();

/** Ajouter les meta title et description ACF pour les catégories, tags et taxonomies personnalisées */
add_action('wp_head', 'insert_acf_meta');
function insert_acf_meta() {
  if (is_category() || is_tag() || is_tax()) {
    $queried_object = get_queried_object();
    $taxonomy = $queried_object->taxonomy;
    $term_id = $queried_object->term_id;

    $meta_title = get_field('meta_title', $taxonomy . '_' . $term_id);
    $meta_description = get_field('meta_description', $taxonomy . '_' . $term_id);

    if ($meta_title) echo '<title>' . esc_html($meta_title) . '</title>' . PHP_EOL;
    if ($meta_description) echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . PHP_EOL;
  }
}

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
