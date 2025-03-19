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
    link.onclick = () => sommaireClose({keepOpen: true});

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
