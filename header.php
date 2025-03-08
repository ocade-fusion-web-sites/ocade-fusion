<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <header>
    <?php if (has_custom_logo()) the_custom_logo(); ?>
    <nav role="navigation" aria-label="Menu principal">
      <button title="Menu principale" aria-expanded="false" aria-controls="menu-principale">
        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
      </button>

      <ul id="menu-principale">
        <li><a href="#">Installation</a></li>
        <li><a href="#">Noeuds</a></li>
        <li><a href="#">Agents IA</a></li>
        <li><a href="#">Workflows</a>
        </li>
      </ul>
    </nav>
  </header>