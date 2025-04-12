window.addEventListener('DOMContentLoaded', () => {
  // 🔧 Utilitaire pour ajouter des événements
  const click = (selector, callback) => {
    document.querySelector(selector)?.addEventListener('click', callback);
  };

  // 🎯 Actions immédiates accessibles dès le DOM chargé
  click('[data-action="open-search"]', () => {
    const dialog = document.getElementById('ocade-search-dialog');
    dialog?.showModal();
    document.getElementById('ocade-search-input')?.focus();
    document.body.classList.add('modal-open');
  });

  click('[data-action="open-menu"]', (e) => {
    e.stopPropagation();
    document.getElementById('menu-principal')?.setAttribute('aria-expanded', 'true');
    document.getElementById('entete-accueil-link')?.focus();
  });

  click('[data-action="open-sommaire"]', () => {
    const sommaire = document.getElementById('sommaire');
    if (!sommaire) return;
    sommaire.setAttribute('aria-expanded', 'true');
    document.getElementById('menu-principal')?.setAttribute('aria-expanded', 'false');
    document.getElementById('sommaire-title-link')?.focus();
  });

  click('[data-action="scroll-footer"]', () => {
    const footer = document.getElementById('footer');
    footer?.scrollIntoView({ behavior: 'smooth' });
    footer?.focus();
  });
});

window.addEventListener('load', () => {
  // ⏳ Insertion différée du menu mobile avec animation
  requestIdleCallback(() => {
    setTimeout(() => {
      const mobileFooter = `
        <nav id="mobile-footer-menu" aria-expanded="false" class="alignfull" role="navigation" aria-label="Mobile Footer Menu">
          <ul role="menu">
            <li role="menuitem" class="ocade-search-button">
              <button id="open-search-modal" title="Effectuer une recherche d'article"></button>
            </li>
            ${document.getElementById('sommaire') ? `
            <li role="menuitem" class="sommaire-item">
              <button id="sommaire-button" title="Sommaire de la page" aria-label="Sommaire de la page"></button>
            </li>` : ''}
            <li role="menuitem" class="formulaire-contact">
              <button title="Remplir une demande de contact" onclick="window.location.href='/contact/'"></button>
            </li>
            <li role="menuitem" class="formulaire-tel">
              <button title="Téléphone à OCade Fusion" onclick="window.location.href='tel:0634892265';"></button>
            </li>
            <li role="menuitem" class="go-to-top">
              <button title="Retour en haut de page"></button>
            </li>
          </ul>
        </nav>
      `;

      const placeholder = document.getElementById('mobile-footer-placeholder');
      if (!placeholder) return;

      placeholder.innerHTML = mobileFooter;
      const insertedMenu = document.getElementById('mobile-footer-menu');

      // ✨ Ajoute la classe visible pour fade-in
      requestAnimationFrame(() => {
        insertedMenu?.classList.add('visible');
      });

      // 🔁 Attache les événements après insertion
      document.getElementById('open-search-modal')?.addEventListener('click', () => {
        const dialog = document.getElementById('ocade-search-dialog');
        dialog?.showModal();
        document.getElementById('ocade-search-input')?.focus();
        document.body.classList.add('modal-open');
      });

      document.getElementById('sommaire-button')?.addEventListener('click', () => {
        const sommaire = document.getElementById('sommaire');
        if (!sommaire) return;
        const expanded = sommaire.getAttribute('aria-expanded') === 'true';
        sommaire.setAttribute('aria-expanded', expanded ? 'false' : 'true');
        if (!expanded) document.getElementById('sommaire-title-link')?.focus();
      });

      document.querySelector('.go-to-top button')?.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    }, 3000); // Injection après 3s
  });

  // 📊 Script Plausible chargé après délai
  setTimeout(() => {
    const s = document.createElement("script");
    s.defer = true;
    s.setAttribute("data-domain", "ocadefusion.fr");
    s.src = "https://plausible.ocadefusion.fr/js/script.js";
    document.head.appendChild(s);
  }, 2000);

  // 📦 Lazy-load n8n-demo component si visible
  requestIdleCallback(() => {
    const el = document.querySelector('n8n-demo');
    if (!el) return;

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          loadN8nDemoLibrary();
          obs.disconnect();
        }
      });
    });

    observer.observe(el);
  });

  function loadScriptWithFallback(primary, fallback, isModule = false) {
    const s = document.createElement('script');
    s.src = primary;
    s.defer = true;
    s.async = true;
    if (isModule) s.type = 'module';
    s.onerror = () => {
      const fallbackScript = document.createElement('script');
      fallbackScript.src = fallback;
      fallbackScript.defer = true;
      fallbackScript.async = true;
      if (isModule) fallbackScript.type = 'module';
      document.head.appendChild(fallbackScript);
    };
    document.head.appendChild(s);
  }

  function loadN8nDemoLibrary() {
    const base = document.body.dataset.themeUri;
    loadScriptWithFallback(`${base}/assets/js/n8n-demo-librairie/webcomponents-loader.js`,
                           'https://cdn.jsdelivr.net/npm/@webcomponents/webcomponentsjs@2.0.0/webcomponents-loader.js');
    loadScriptWithFallback(`${base}/assets/js/n8n-demo-librairie/polyfill-support.js`,
                           'https://unpkg.com/lit@2.0.0-rc.2/polyfill-support.js');
    loadScriptWithFallback(`${base}/assets/js/n8n-demo-librairie/n8n-demo.bundled.js`,
                           'https://cdn.jsdelivr.net/npm/@n8n_io/n8n-demo-component@latest/n8n-demo.bundled.js',
                           true);
  }
});
