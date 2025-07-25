document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("searchForm");
  const results = document.getElementById("results");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const sport = form.querySelector('input[name="sport"]').value;
    const ville = form.querySelector('input[name="ville"]').value;
    const date = form.querySelector('input[name="date"]').value;

    if (!sport || !ville || !date) {
      alert("Veuillez remplir tous les champs.");
      return;
    }

    try {
      const response = await fetch("http://localhost:8000/api/recherche", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ sport, ville, date })
      });

      const data = await response.json();

      if (data.length === 0) {
        results.innerHTML = "<p>Aucun centre trouvé.</p>";
      } else {
        results.innerHTML = data.map(c =>
          `<div><h3>${c.nom}</h3><p>${c.ville} - ${c.sport} - ${c.disponible_le}</p></div>`
        ).join("");
      }
    } catch (err) {
      results.innerHTML = "<p>Erreur lors de la recherche.</p>";
      console.error(err);
    }
  });

  
  document.querySelectorAll(".sports button").forEach(button => {
    button.addEventListener("click", () => {
      form.querySelector('input[name="sport"]').value = button.textContent;
    });
  });
});


//voir la carte
document.querySelectorAll('.centre button').forEach((btn, i) => {
  btn.addEventListener('click', () => {
    const noms = ["Centre Sportif A Paris", "Centre Sportif B Lyon"];
    const query = encodeURIComponent(noms[i]);
    window.open(`https://www.google.com/maps?q=${query}`, '_blank');
  });
});