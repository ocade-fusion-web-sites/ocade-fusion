document
  .getElementById("newsletter-form")
  .addEventListener("submit", async function (e) {
    e.preventDefault();

    const emailInput = document.getElementById("newsletter-email");

    // Ne rien faire si l'email est invalide
    if (!emailInput.checkValidity()) {
      return;
    }

    const email = emailInput.value;

    // Fermer immédiatement la modale
    document.getElementById("newsletter-dialog").close();
    document.body.classList.remove("no-scroll", "modal-open");

    // Afficher le message "en cours"
    const feedback = document.getElementById("newsletter-feedback");
    feedback.style.display = "block";
    feedback.style.color = "black";
    feedback.style.border = "1px solid black";
    feedback.textContent = "⏳ Demande d'inscription en cours...";

    // Timer pour masquer le message après 5 secondes
    const hideFeedback = () => {
      setTimeout(() => {
        feedback.style.display = "none";
        feedback.textContent = "";
      }, 5000);
    };

    try {
      const response = await fetch(
        "https://n8n.ocadefusion.fr/webhook/newsletter-add",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ email }),
          redirect: "follow", // permet au fetch de suivre une redirection
        }
      );
      
      // Si le serveur redirige avec un code 3xx
      if (response.redirected) {
        window.location.href = response.url;
        return;
      }
      

      if (response.status === 200) {
        feedback.textContent = "✅ Inscription réussie ! Merci 🎉";
        feedback.style.color = "green";
        feedback.style.border = "1px solid green";
      } else {
        feedback.textContent = "❌ L'inscription a échoué. Veuillez réessayer.";
        feedback.style.color = "red";
        feedback.style.border = "1px solid red";
      }

      hideFeedback();

    } catch (err) {
      feedback.textContent = "❌ Erreur de connexion. Veuillez réessayer.";
      feedback.style.color = "red";
      hideFeedback();
    }
  });