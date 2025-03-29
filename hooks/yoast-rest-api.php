<?php
// Expose Yoast SEO meta keys to the REST API for posts

function exposer_meta_yoast_wpseo() {
  // Liste des clés méta utilisées par Yoast SEO que l'on souhaite exposer à l'API REST
  $yoast_keys = [

    // Mot-clé principal (focus keyword)
    // Exemple JSON : "meta": { "_yoast_wpseo_focuskw": "automatisation n8n" }
    '_yoast_wpseo_focuskw',

    // Champ texte brut du mot-clé principal (rarement nécessaire si le précédent est défini)
    // Exemple JSON : "meta": { "_yoast_wpseo_focuskw_text_input": "automatisation n8n" }
    '_yoast_wpseo_focuskw_text_input',

    // Meta description (celle qui apparaît dans les moteurs de recherche)
    // Exemple JSON : "meta": { "_yoast_wpseo_metadesc": "Découvrez comment automatiser vos tâches avec n8n." }
    '_yoast_wpseo_metadesc',

    // Titre SEO personnalisé
    // Exemple JSON : "meta": { "_yoast_wpseo_title": "Titre optimisé pour le SEO | Mon site" }
    '_yoast_wpseo_title',

    // Score de SEO calculé par Yoast (non modifiable, lecture uniquement)
    // Exemple JSON : "meta": { "_yoast_wpseo_linkdex": "74" }
    '_yoast_wpseo_linkdex',

    // Horodatage WordProof (rare, lié à l'extension WordProof)
    // Exemple JSON : "meta": { "_yoast_wpseo_wordproof_timestamp": "2023-08-15T12:00:00Z" }
    '_yoast_wpseo_wordproof_timestamp',

    // Temps de lecture estimé en minutes
    // Exemple JSON : "meta": { "_yoast_wpseo_estimated_reading_time_minutes": "4" }
    '_yoast_wpseo_estimated_reading_time_minutes',

    // Catégorie primaire définie dans Yoast (ID de la taxonomie)
    // Exemple JSON : "meta": { "_yoast_wpseo_primary_category": "7" }
    '_yoast_wpseo_primary_category',

    // Score de lisibilité (lecture uniquement)
    // Exemple JSON : "meta": { "_yoast_wpseo_content_score": "90" }
    '_yoast_wpseo_content_score',

    // Directive personnalisée pour Googlebot
    // Exemple JSON : "meta": { "_yoast_wpseo_googlebot": "index, follow" }
    '_yoast_wpseo_googlebot',

    // Indexation du contenu (yes/no)
    // Exemple JSON : "meta": { "_yoast_wpseo_robots_index": "index" }
    '_yoast_wpseo_robots_index',

    // Suivi des liens (yes/no)
    // Exemple JSON : "meta": { "_yoast_wpseo_robots_follow": "follow" }
    '_yoast_wpseo_robots_follow',

    // Archivage (yes/no)
    // Exemple JSON : "meta": { "_yoast_wpseo_robots_archive": "archive" }
    '_yoast_wpseo_robots_archive',

    // Indexation des images (yes/no)
    // Exemple JSON : "meta": { "_yoast_wpseo_robots_imageindex": "imageindex" }
    '_yoast_wpseo_robots_imageindex',

    // URL canonique (pour éviter le contenu dupliqué)
    // Exemple JSON : "meta": { "_yoast_wpseo_canonical": "https://monsite.com/mon-article" }
    '_yoast_wpseo_canonical',

    // Titre personnalisé dans le fil d’Ariane
    // Exemple JSON : "meta": { "_yoast_wpseo_breadcrumb_title": "Titre court pour les fils d’Ariane" }
    '_yoast_wpseo_breadcrumb_title',

    // Redirection personnalisée (ex : vers une autre URL)
    // Exemple JSON : "meta": { "_yoast_wpseo_redirect": "https://autresite.com/page" }
    '_yoast_wpseo_redirect',

    // Indique si c’est un contenu “cornerstone” (important/fondamental)
    // Exemple JSON : "meta": { "_yoast_wpseo_cornerstone": "1" }
    '_yoast_wpseo_cornerstone'
  ];

  // Enregistrement de chaque clé avec exposition dans l’API REST
  foreach ($yoast_keys as $key) {
    register_meta('post', $key, [
      'show_in_rest' => true,
      'type' => 'string',
      'single' => true,
      'auth_callback' => function () {
        return current_user_can('edit_posts');
      }
    ]);
  }
}
add_action('init', 'exposer_meta_yoast_wpseo');
