<?php


// delete_transient('cached_footer_html');

$footer_html = get_transient('cached_footer_html');
if (!$footer_html) {
  ob_start();
  $footer_query = new WP_Query([
    'post_type' => 'footer',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'orderby' => 'date',
    'order' => 'DESC'
  ]);
  if ($footer_query && $footer_query->have_posts()) {
    while ($footer_query->have_posts()) {
      $footer_query->the_post();
      the_content();
    }
    wp_reset_postdata();
  }
  $footer_html = ob_get_clean();
  set_transient('cached_footer_html', $footer_html, 12 * HOUR_IN_SECONDS);
}
?>
<footer role="contentinfo" id="footer" class="alignfull" tabindex="0">
  <?php echo $footer_html; ?>
</footer>

<script defer src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/menu-et-sommaire.js"></script>
<script defer src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/header-footer.js"></script>
<?php wp_footer(); ?>
</body>
</html>
