document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("searchForm");
  const results = document.getElementById("results");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const sport = form.querySelector('input[name="sport"]').value.trim();
    const ville = form.querySelector('input[name="ville"]').value.trim();
    const date = form.querySelector('input[name="date"]').value.trim();

    if (!sport || !ville || !date) {
      alert("Veuillez remplir tous les champs.");
      return;
    }

    try {
      const response = await fetch("/api/recherche", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ sport, ville, date }),
      });

      const contentType = response.headers.get("content-type");

      if (!contentType || !contentType.includes("application/json")) {
        const text = await response.text();
        console.error("Réponse non JSON reçue : ", text);
        throw new Error("Le serveur n'a pas renvoyé de JSON.");
      }

      const data = await response.json();
      console.log("Réponse reçue :", data);

      if (Array.isArray(data)) {
        if (data.length === 0) {
          results.innerHTML = "<p>Aucun centre trouvé.</p>";
        } else {
          results.innerHTML = data.map(c =>
            `<div class="centre">
              <h3>${c.nom}</h3>
              <p>${c.ville} - ${c.sport} - ${c.disponible_le}</p>
              <button class="map-button" data-adresse="${c.adresse}">Voir sur la carte</button>
            </div>`
          ).join("");
          attachMapButtons();
        }
      } else if (data.error) {
        results.innerHTML = `<p>Erreur : ${data.error}</p>`;
      } else {
        results.innerHTML = "<p>Erreur inattendue. Voir la console.</p>";
        console.error("Réponse inattendue :", data);
      }
    } catch (err) {
      console.error("Erreur lors du traitement :", err);
      results.innerHTML = "<p>Erreur lors de la recherche. Voir la console.</p>";
    }
  });

  // Remplit automatiquement le champ sport quand on clique sur un bouton sport
  document.querySelectorAll(".sports button").forEach(button => {
    button.addEventListener("click", () => {
      form.querySelector('input[name="sport"]').value = button.textContent.trim();
    });
  });

 function attachMapButtons() {
  document.querySelectorAll('.map-button').forEach((btn) => {
    btn.addEventListener('click', (event) => {
      const adresse = btn.getAttribute("data-adresse");
      const parent = btn.closest(".centre");

      if (!adresse) {
        alert("Adresse non trouvée.");
        return;
      }

      // Évite d'afficher plusieurs fois l'adresse
      if (!parent.querySelector(".adresse")) {
        const p = document.createElement("p");
        p.classList.add("adresse");
        p.textContent = "Adresse : " + adresse;
        btn.insertAdjacentElement("afterend", p);
      }

      // Ouvre l'adresse sur Google Maps
      const query = encodeURIComponent(adresse);
      window.open(`https://www.google.com/maps?q=${query}`, '_blank');
    }, { once: true }); // <- cette option empêche l'event de se déclencher plusieurs fois
  });
}
});