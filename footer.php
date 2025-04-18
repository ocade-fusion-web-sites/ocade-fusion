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
<script defer src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/newsletter.js"></script>
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
    <p style="font-size: 0.9em; color: #555; margin-bottom: 0.5rem;">
      💡 Utilisez le champ de recherche ci-dessus pour poser une question ou entrer un mot-clé.
      Exemple : <em>comment créer un formulaire dans n8n</em>
    </p>

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

<!-- Newsletter n8n Modal -->
<dialog id="newsletter-dialog" class="newsletter-modal" aria-labelledby="newsletter-title">
  <div class="newsletter-wrapper">
    <div class="newsletter-image">
      <img src="/wp-content/themes/ocade-fusion/assets/svgs/newsletter-modal.svg" alt="Inscription à la newsletter n8n">
    </div>
    <div class="newsletter-content">
      <h3 id="newsletter-title">🧠 Automatisez comme un pro !</h3>

      <ul>
        <li>🎯 Recevez les <strong>tutos N8N</strong> avant les autres !</li>
        <li>📩 Des <strong>astuces</strong> et <strong>conseils</strong> pour automatiser votre quotidien.</li>
        <li>🔒 Vos <strong>données sont en sécurité</strong> avec nous.</li>
        <li>📅 <strong>Un email par semaine</strong>, pas plus !</li>
        <li>🆓 <strong>Se désinscrire à tout moment</strong>.</li>
      </ul>

      <form id="newsletter-form" method="POST" action="/chemin-vers-handler" novalidate>
        <label for="newsletter-email">Mon Email</label>
        <span id="email-hint" class="hint">ex : nom@exemple.com</span>
        <input
          type="email"
          id="newsletter-email"
          name="email"
          placeholder="Email pour la newsletter"
          aria-label="Email pour la newsletter"
          required
          aria-describedby="email-hint"
          pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" 
          autocomplete="email"
          />
        <button type="submit" id="newsletter-submit">Inscription à la newsletter</button>
      </form>
    </div>
  </div>
  <button class="newsletter-close" aria-label="Fermer la modale" onclick="document.getElementById('newsletter-dialog').close(); document.body.classList.remove('no-scroll', 'modal-open');">✕</button>
</dialog>
<div id="newsletter-feedback">✅ Demande d'inscription en cours...</div>
<!-- Fin Newsletter Modal -->

</body>

</html>