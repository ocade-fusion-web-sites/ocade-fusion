<?php
/**
 * Template Name: Plan du site
 */
get_header();
?>

<main id="primary" class="site-main site-map" role="main">

  <section aria-labelledby="sitemap-pages">
    <h2 id="sitemap-pages">Pages</h2>
    <ul>
      <?php
      $pages = get_pages(['sort_column' => 'menu_order']);
      foreach ($pages as $page) :
        if (!in_array($page->post_title, ['Plan du site'])) : // évite la boucle sur elle-même
          echo '<li><a href="' . get_permalink($page->ID) . '">' . esc_html($page->post_title) . '</a></li>';
        endif;
      endforeach;
      ?>
    </ul>
  </section>

  <section aria-labelledby="sitemap-posts">
    <h2 id="sitemap-posts">Articles</h2>
    <ul>
      <?php
      $posts = get_posts([
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
      ]);
      foreach ($posts as $post) :
        echo '<li><a href="' . get_permalink($post->ID) . '">' . esc_html(get_the_title($post->ID)) . '</a></li>';
      endforeach;
      ?>
    </ul>
  </section>

  <section aria-labelledby="sitemap-categories">
    <h2 id="sitemap-categories">Catégories</h2>
    <ul>
      <?php
      $categories = get_categories(['hide_empty' => true]);
      foreach ($categories as $cat) :
        echo '<li><a href="' . get_category_link($cat->term_id) . '">' . esc_html($cat->name) . '</a></li>';
      endforeach;
      ?>
    </ul>
  </section>
	
  <section aria-labelledby="sitemap-tags">
    <h2 id="sitemap-tags">Étiquettes</h2>
    <ul>
      <?php
      $tags = get_tags(['hide_empty' => true]);
      foreach ($tags as $tag) :
        echo '<li><a href="' . get_tag_link($tag->term_id) . '">' . esc_html($tag->name) . '</a></li>';
      endforeach;
      ?>
    </ul>
  </section>


</main>

<style>
.site-map {
  padding: 2rem;
  max-width: 800px;
  margin: auto;
  font-family: system-ui, sans-serif;
  line-height: 1.6;
}
.site-map h2 {
  color: #303579;
  border-bottom: 2px solid #ececfe;
  padding-bottom: .25rem;
  margin-top: 2rem;
}
.site-map ul {
  list-style: disc;
  padding-left: 1.5rem;
}
.site-map li {
  margin-bottom: .5rem;
}
</style>

<?php get_footer(); ?>
