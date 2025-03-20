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
/***************************** Sticky Logo ***********************************/
/************************************************************************************** */
let lastScrollY = window.scrollY,
  ticking = false;
const handleScroll = () => {
  let currentScrollY = window.scrollY;
  let isAtBottom =
    window.innerHeight + currentScrollY >=
    document.documentElement.scrollHeight - 10;
  let isAtTop = currentScrollY <= 10;
  if (!isAtBottom && !isAtTop)
    document.documentElement.classList.toggle(
      "hide-logo",
      currentScrollY > lastScrollY
    );
  lastScrollY = window.scrollY;
  ticking = false;
};

document.addEventListener("scroll", () => {
  if (!ticking) {
    requestAnimationFrame(handleScroll);
    ticking = true;
  }
});
/********************** Fin de la cachage du logo sur mobile *************************/
/************************************************************************************** */

/************************************************************************************** */
/*************************** Gestion du menu *********************************/
/************************************************************************************** */
document.addEventListener("DOMContentLoaded", function () {
  const menuButtons = document.querySelectorAll("button[aria-controls]");

  menuButtons.forEach((button) => {
    // Gestion du clic pour ouvrir/fermer le menu
    button.addEventListener("click", function () {
      this.setAttribute(
        "aria-expanded",
        this.getAttribute("aria-expanded") === "true" ? "false" : "true"
      );
    });
  });

  // Gestion de la touche Échap pour fermer le menu correspondant
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      document.querySelectorAll('[aria-expanded="true"]').forEach((element) => element.setAttribute("aria-expanded", "false"));
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
    link.onclick = () => sommaireClose({ keepOpen: true });

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
