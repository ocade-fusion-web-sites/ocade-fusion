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
    <h2 id="chatbot-title"><?php esc_html_e('Posez-moi votre question 😊', 'ocade'); ?></h2>
    <button aria-label="<?php esc_attr_e('Fermer le chatbot', 'ocade'); ?>" class="chatbot-close" onclick="document.getElementById('chatbot-dialog').close()">
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
      <button id="chatbot-send" aria-label="Envoyer la question">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path d="M10 2a8 8 0 105.293 14.293l5.707 5.707 1.414-1.414-5.707-5.707A8 8 0 0010 2zm0 2a6 6 0 110 12A6 6 0 0110 4z" />
        </svg>
      </button>

    </div>
    <div id="chatbot-html-response" class="chatbot-response-area"></div>
  </div>
</dialog>
<!-- Fin du Chatbot Modal -->

</body>

</html>