<?php

function ocadefusion_afficher_notice_front() {
  if (isset($_GET['status']) && $_GET['status'] === 'success' && isset($_GET['message'])) {
    $message = wp_kses_post(wp_unslash($_GET['message']));
?>
    <div class="notice notice-success" role="alert" aria-live="polite">
      <button type="button" class="notice-dismiss" aria-label="Fermer cette notification" onclick="this.parentElement.style.display='none'">&times;</button>
      <p><?php echo esc_html($message); ?></p>
    </div>
<?php
  }
}
add_action('wp_body_open', __NAMESPACE__ . '\ocadefusion_afficher_notice_front');
