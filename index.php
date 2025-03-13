<?php 

get_header();

// Afficher le contenu de la page
if (have_posts()) {
  while (have_posts()) {
    the_post();
    the_content();
  }
}

get_footer();