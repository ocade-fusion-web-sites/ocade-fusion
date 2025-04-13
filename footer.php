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
<script defer src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/chatbot.js"></script>
<?php wp_footer(); ?>

<!-- Chabtot Modal -->
<dialog id="chatbot-dialog" class="chatbot-modal" aria-labelledby="chatbot-title">
  <div class="chatbot-header">
    <h2 id="chatbot-title"><?php esc_html_e('Que voulez-vous savoir ?', 'ocade'); ?></h2>
    <button aria-label="<?php esc_attr_e('Fermer le chatbot', 'ocade'); ?>" class="chatbot-close" onclick="document.getElementById('chatbot-dialog').close(); document.body.classList.remove('no-scroll', 'modal-open');">
      ✕
    </button>
  </div>
  <div class="chatbot-content">
    <div class="chatbot-input-wrapper">
      <input
        type="text"
        id="chatbot-question"
        placeholder="Posez votre question..."
        aria-label="Champ de question" />
      <button id="chatbot-send" aria-label="Envoyer la question"></button>
    </div>
    <div id="chatbot-html-response" class="chatbot-response-area"></div>
  </div>
</dialog>
<!-- Fin du Chatbot Modal -->

</body>

</html>