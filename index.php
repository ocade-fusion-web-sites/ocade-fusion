<?php

get_header(); ?>

<main role="main" aria-label="Contenu principal du site">
  <?php if (have_posts()) {
    while (have_posts()) {
      the_post();
      the_content();
    }
  }
  ?>
</main>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "<?php echo esc_html(get_the_title()); ?>",
  "description": "<?php echo esc_html(get_the_excerpt()); ?>",
  "url": "<?php echo esc_url(get_permalink()); ?>"
}
</script>

<?php get_footer();
