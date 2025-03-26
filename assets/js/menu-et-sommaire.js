// Ferme le panneau de sommaire
const sommaireClose = () =>
  document.getElementById("sommaire").setAttribute("aria-expanded", "false");

/************************************************************************************** */
/*************** Ajouter la classe panel-expanded au <html> ******************/
/************************************************************************************** */
const sommaire = document.getElementById("sommaire");
const html = document.documentElement; // Sélectionne la balise <html>

// Création de l'observateur
const observer = new MutationObserver((mutations) => {
  mutations.forEach((mutation) => {
    if (mutation.attributeName === "aria-expanded") {
      const isExpanded = sommaire.getAttribute("aria-expanded") === "true";
      html.classList.toggle("panel-expanded", isExpanded);
    }
  });
});
// Configuration de l'observateur pour surveiller les changements d'attributs
if (sommaire) observer.observe(sommaire, { attributes: true });
/********** Fin de l'ajout de la classe panel-expanded au <html> *************/
/************************************************************************************** */

/************************************************************************************** */
/*************************** Gestion du menu *********************************/
/************************************************************************************** */
document.addEventListener("DOMContentLoaded", function () {
  const menuButtons = document.querySelectorAll("button[aria-controls]");

  // Gestion du clic sur chaque bouton (ouvrir/fermer)
  menuButtons.forEach((button) => {
    button.addEventListener("click", function (event) {
      const isExpanded = this.getAttribute("aria-expanded") === "true";
      this.setAttribute("aria-expanded", isExpanded ? "false" : "true");
      event.stopPropagation(); // Empêche le document click de le fermer tout de suite
    });
  });

  // Gestion du clic global pour fermer les menus ouverts si clic en dehors
  document.addEventListener("click", function (event) {
    menuButtons.forEach((button) => {
      const menuId = button.getAttribute("aria-controls");
      const menu = document.getElementById(menuId);
      const isExpanded = button.getAttribute("aria-expanded") === "true";

      if (
        isExpanded &&
        !button.contains(event.target) &&
        menu &&
        !menu.contains(event.target)
      ) {
        button.setAttribute("aria-expanded", "false");
      }
    });
  });

  // Fermeture des menus via la touche Échap
  (function () {
    let lastKey = null;
    let keyCount = 0;
    let lastTime = 0;
    const threshold = 600;

    let suppressUntil = 0; // délai jusqu'à lequel on bloque les frappes

    const dialog = document.getElementById("ocade-search-dialog");
    const searchInput = document.getElementById("ocade-search-input");
    const menuButton = document.getElementById("menu-principal");
    const sommaire = document.getElementById("sommaire");

    const actions = {
      m: () => {
        if (menuButton) {
          const expanded = menuButton.getAttribute("aria-expanded") === "true";
          menuButton.setAttribute("aria-expanded", expanded ? "false" : "true");
        }
      },
      s: () => {
        if (sommaire) {
          const expanded = sommaire.getAttribute("aria-expanded") === "true";
          sommaire.setAttribute("aria-expanded", expanded ? "false" : "true");
        }
      },
      r: () => {
        // Bloque les frappes pendant 300ms
        suppressUntil = Date.now() + 300;

        setTimeout(() => {
          if (dialog && typeof dialog.showModal === "function") {
            dialog.showModal();
            document.body.classList.add("modal-open");
            searchInput?.focus();
          }
        }, 100);
      },
    };

    document.addEventListener("keydown", (e) => {
      const key = e.key.toLowerCase();
      const now = Date.now();

      // ⛔️ Si on est encore dans la fenêtre de blocage
      if (now < suppressUntil) {
        e.preventDefault();
        return;
      }

      // 🔁 Échappe : fermeture de tout
      if (key === "escape") {
        document
          .querySelectorAll('[aria-expanded="true"]')
          .forEach((el) => el.setAttribute("aria-expanded", "false"));
        if (dialog?.open) {
          dialog.close();
          document.body.classList.remove("modal-open");
        }
        return;
      }

      // ⌨️ Détection des 3 frappes rapides
      if (key === lastKey && now - lastTime < threshold) {
        keyCount++;
      } else {
        keyCount = 1;
        lastKey = key;
      }

      lastTime = now;

      if (keyCount === 3 && actions[key]) {
        e.preventDefault();
        actions[key]();
        keyCount = 0;
      }
    });
  })();
});
/************************* Fin de la gestion du menu *************************/
/************************************************************************************** */

/************************************************************************************** */
/*************************** Gestion du sommaire *********************************/
/************************************************************************************** */
document.addEventListener("DOMContentLoaded", function () {
  const sommaireList = document.querySelector(".sommaire-list");

  if (!sommaireList) return;

  const headers = document.querySelectorAll("h2");
  const linksMap = new Map();

  headers.forEach((header, index) => {
    if (!header.id) header.id = "section-" + index;

    const listItem = document.createElement("li");
    const link = document.createElement("a");
    link.href = "#" + header.id;
    link.textContent = header.textContent;
    link.onclick = () => {
      // Si écran plus petit que 1024px, fermer le sommaire
      if (window.innerWidth < 1024) sommaireClose();
    };

    listItem.appendChild(link);
    sommaireList.appendChild(listItem);

    linksMap.set(header.id, link);
  });

  // Observer les sections
  const observerOptions = {
    root: null,
    rootMargin: "0px",
    threshold: 0.3, // 30% visible avant activation
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        document
          .querySelectorAll(".sommaire-list a")
          .forEach((link) => link.classList.remove("active"));
        const activeLink = linksMap.get(entry.target.id);
        if (activeLink) activeLink.classList.add("active");
      }
    });
  }, observerOptions);

  headers.forEach((header) => observer.observe(header));
});
/************************* Fin de la gestion du sommaire *************************/
/************************************************************************************** */
