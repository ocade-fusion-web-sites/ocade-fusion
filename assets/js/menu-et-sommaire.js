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
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      console.log("Escape key pressed");
      document
        .querySelectorAll('[aria-expanded="true"]')
        .forEach((element) => element.setAttribute("aria-expanded", "false"));
    }
    // Alt + M pour le menu
    if (e.altKey && e.key.toLowerCase() === "m") {
      const menuButton = document.getElementById("menu-principal");
      menuButton.setAttribute(
        "aria-expanded",
        menuButton.getAttribute("aria-expanded") === "true" ? "false" : "true"
      );
      e.preventDefault();
    }

    // Alt + S pour le sommaire
    if (e.altKey && e.key.toLowerCase() === "s") {
      const sommaire = document.getElementById("sommaire");
      if (sommaire) {
        sommaire.setAttribute(
          "aria-expanded",
          sommaire.getAttribute("aria-expanded") === "true" ? "false" : "true"
        );
        e.preventDefault();
      }
    }
  });
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
