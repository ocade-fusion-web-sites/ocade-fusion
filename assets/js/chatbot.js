document.addEventListener("DOMContentLoaded", () => {
  const sendButton = document.getElementById("chatbot-send");
  const input = document.getElementById("chatbot-question");
  const responseDiv = document.getElementById("chatbot-html-response");

  if (!sendButton || !input || !responseDiv) return;

  const showLoader = () => {
    responseDiv.innerHTML = `
      <div class="chatbot-loader">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
      </div>
    `;
  };

  const askChatbot = async () => {
    const question = input.value.trim();
    if (!question) return;

    showLoader();

    try {
      const res = await fetch("https://n8n.ocadefusion.fr/webhook/recherche-n8n", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ question }),
      });

      if (!res.ok) throw new Error("Réponse non valide");

      const data = await res.json();

      // Mise à jour du contenu HTML
      responseDiv.innerHTML =
        data[0]?.reponse_a_la_question || "<p>Aucune réponse trouvée.</p>";
    } catch (error) {
      responseDiv.innerHTML = `<p style="color:red;">❌ Une erreur est survenue : ${error.message}</p>`;
    }
  };

  sendButton.addEventListener("click", askChatbot);

  input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      askChatbot();
    }
  });
});
