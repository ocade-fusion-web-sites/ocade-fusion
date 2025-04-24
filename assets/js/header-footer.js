const safeIdleCallback =
  window.requestIdleCallback ||
  function (cb) {
    return setTimeout(cb, 1);
  };

window.addEventListener("DOMContentLoaded", () => {
  const click = (selector, callback) => {
    document.querySelector(selector)?.addEventListener("click", callback);
  };

  // Événements DOM disponibles immédiatement
  click('[data-action="open-search"]', () => {
    const dialog = document.getElementById("ocade-search-dialog");
    dialog?.showModal();
    document.getElementById("ocade-search-input")?.focus();
    document.body.classList.add("no-scroll", "modal-open");
  });

  click('[data-action="open-menu"]', (e) => {
    e.stopPropagation();
    document
      .getElementById("menu-principal")
      ?.setAttribute("aria-expanded", "true");
    document.getElementById("entete-accueil-link")?.focus();
  });

  click('[data-action="open-sommaire"]', () => {
    const sommaire = document.getElementById("sommaire");
    if (!sommaire) return;
    sommaire.setAttribute("aria-expanded", "true");
    document
      .getElementById("menu-principal")
      ?.setAttribute("aria-expanded", "false");
    document.getElementById("sommaire-title-link")?.focus();
  });

  click('[data-action="scroll-footer"]', () => {
    const footer = document.getElementById("footer");
    footer?.scrollIntoView({ behavior: "smooth" });
    footer?.focus();
  });
});

window.addEventListener("load", () => {
  // Insertion différée du footer mobile et des événements associés
  safeIdleCallback(() => {
    setTimeout(() => {
      const sommaireExists = !!document.getElementById("sommaire");

      const mobileFooterHTML = `
        <nav id="mobile-footer-menu" aria-expanded="false" class="alignfull" role="navigation" aria-label="Mobile Footer Menu">
          <ul role="menu">
            <li role="menuitem" class="ocade-search-button" aria-label="Effectuer une recherche d'article">
              <button id="open-search-modal" title="Effectuer une recherche d'article"></button>
            </li>
            <li role="menuitem" id="ocade-access" aria-label="Panneau d'accessibilité">
              <div style="display:flex;"
                title="Panneau d'accessibilité"
                id="accessconfig"
                data-accessconfig-button="true"
                data-accessconfig-buttonname=""
                data-accessconfig-params='{
                  "Prefix" : "a42-ac",
                  "ContainerClass" : "",
                  "ModalCloseButton" : "",
                  "ModalTitle" : "",
                  "FormFieldset" : "",
                  "FormFieldsetLegend" : "",
                  "FormRadio" : "",
                  "ButtonTitle": "Ouvrir les paramètres d’accessibilité"
                }'
              >
              </div>
            </li>
            <li role="menuitem" class="open-chatbot" aria-label="Ouvrir le chatbot">
              <button id="open-chatbot-modal" title="Ouvrir le chatbot"></button>
            </li>
            ${
              sommaireExists
                ? `
              <li role="menuitem" class="sommaire-item" aria-label="Sommaire de la page">
                <button id="sommaire-button" title="Sommaire de la page" aria-label="Sommaire de la page"></button>
              </li>`
                : ""
            }
            <li role="menuitem" class="formulaire-contact" aria-label="Remplir une demande de contact">
              <button title="Remplir une demande de contact" onclick="window.location.href='/contact/'"></button>
            </li>
            <li role="menuitem" class="formulaire-tel" aria-label="Téléphone à OCade Fusion">
              <button title="Téléphone à OCade Fusion" onclick="window.location.href='tel:0634892265';"></button>
            </li>
            <li role="menuitem" class="open-newsletter" aria-label="S'inscrire à la newsletter">
              <button id="open-newsletter-modal" title="S'inscrire à la newsletter"></button>
            </li>
            <li role="menuitem" class="go-to-top" aria-label="Retour en haut de page">
              <button title="Retour en haut de page"></button>
            </li>
          </ul>
        </nav>
      `;

      const placeholder = document.getElementById("mobile-footer-placeholder");
      placeholder.innerHTML = mobileFooterHTML;
      const insertedMenu = document.getElementById("mobile-footer-menu");

      requestAnimationFrame(() => {
        insertedMenu?.classList.add("visible");
      });

      // Fonctions d'ouverture de modales et actions dynamiques
      const attachFooterEvents = () => {
        const openDialog = (dialogId, focusId) => {
          const dialog = document.getElementById(dialogId);
          dialog?.showModal();
          if (focusId) document.getElementById(focusId)?.focus();
          document.body.classList.add("no-scroll", "modal-open");
        };

        document
          .getElementById("open-search-modal")
          ?.addEventListener("click", () => {
            openDialog("ocade-search-dialog", "ocade-search-input");
          });

        document
          .getElementById("open-chatbot-modal")
          ?.addEventListener("click", () => {
            openDialog("chatbot-dialog");
          });

        document
          .getElementById("sommaire-button")
          ?.addEventListener("click", () => {
            const sommaire = document.getElementById("sommaire");
            if (!sommaire) return;
            const expanded = sommaire.getAttribute("aria-expanded") === "true";
            sommaire.setAttribute("aria-expanded", expanded ? "false" : "true");
            if (!expanded)
              document.getElementById("sommaire-title-link")?.focus();
          });

        document
          .getElementById("open-newsletter-modal")
          ?.addEventListener("click", () => {
            openDialog("newsletter-dialog");
          });

        document
          .querySelector(".go-to-top button")
          ?.addEventListener("click", () => {
            window.scrollTo({ top: 0, behavior: "smooth" });
          });
      };
      attachFooterEvents();

      if (window.location.hash === "#inscription-newsletter") {
        const openNewsletterDialog = () => {
          const dialog = document.getElementById("newsletter-dialog");
          if (dialog) {
            dialog.showModal();
            document.body.classList.add("no-scroll", "modal-open");
          } else {
            // Si le footer et le bouton ne sont pas encore chargés, retenter plus tard
            setTimeout(openNewsletterDialog, 500);
          }
        };

        openNewsletterDialog();
      }

      // Charger AccessConfig dynamiquement après l'insertion du bouton
      const loadAccessConfig = () => {
        const s = document.createElement("script");
        s.src = "/wp-content/accessconfig/js/accessconfig.min.js";
        s.onload = () => {
          if (typeof window.onload === "function") window.onload();
        };
        document.head.appendChild(s); // PAS de defer
      };
      loadAccessConfig();

      // Logique de scroll mobile : ajout de classes scroll-up / scroll-down sur <html>
      if (document.documentElement.classList.contains("is-mobile")) {
        let lastScrollTop = 0;
        let ticking = false;
        const html = document.documentElement;
        window.addEventListener("scroll", () => {
          if (!ticking) {
            window.requestAnimationFrame(() => {
              const currentScroll =
                window.pageYOffset || document.documentElement.scrollTop;
              if (currentScroll > lastScrollTop + 10) {
                html.classList.add("scroll-down");
                html.classList.remove("scroll-up");
              } else if (currentScroll < lastScrollTop - 10) {
                html.classList.add("scroll-up");
                html.classList.remove("scroll-down");
              }
              lastScrollTop = Math.max(currentScroll, 0);
              ticking = false;
            });
            ticking = true;
          }
        });
      }
    }, 2000);
  });

  // Lazy-load du composant n8n-demo si présent
  safeIdleCallback(() => {
    const el = document.querySelector("n8n-demo");
    if (!el) return;

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          loadN8nDemoLibrary();
          obs.disconnect();
        }
      });
    });

    observer.observe(el);
  });

  function loadScriptWithFallback(primary, fallback, isModule = false) {
    const s = document.createElement("script");
    s.src = primary;
    s.defer = true;
    s.async = true;
    if (isModule) s.type = "module";
    s.onerror = () => {
      const fallbackScript = document.createElement("script");
      fallbackScript.src = fallback;
      fallbackScript.defer = true;
      fallbackScript.async = true;
      if (isModule) fallbackScript.type = "module";
      document.head.appendChild(fallbackScript);
    };
    document.head.appendChild(s);
  }

  function loadN8nDemoLibrary() {
    const base = document.body.dataset.themeUri;
    loadScriptWithFallback(
      `${base}/assets/js/n8n-demo-librairie/webcomponents-loader.js`,
      "https://cdn.jsdelivr.net/npm/@webcomponents/webcomponentsjs@2.0.0/webcomponents-loader.js"
    );
    loadScriptWithFallback(
      `${base}/assets/js/n8n-demo-librairie/polyfill-support.js`,
      "https://unpkg.com/lit@2.0.0-rc.2/polyfill-support.js"
    );
    loadScriptWithFallback(
      `${base}/assets/js/n8n-demo-librairie/n8n-demo.bundled.js`,
      `https://cdn.jsdelivr.net/npm/@n8n_io/n8n-demo-component@latest/n8n-demo.bundled.js`,
      true
    );
  }
});
