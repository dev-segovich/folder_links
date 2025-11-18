// === CARGA DE PROYECTOS DESDE projects.json ===
fetch("projects.json")
  .then((res) => res.json())
  .then((projects) => {
    renderProjects(projects);
    initAccordions();
    initEnvSwitch();
  })
  .catch((err) => console.error("Error cargando projects.json:", err));

// === FUNCIÓN PARA RENDERIZAR LOS PROYECTOS ===
function renderProjects(projects) {
  const container = document.querySelector(".container");

  projects.forEach((p) => {
    const linksHTML = p.links
      .map(
        (l) => `
        <div class="sub-link">
          <span>${l.label}</span>
          <a 
            data-prod="${l.prod}" 
            data-local="${l.local}" 
            target="_blank"
          >Abrir</a>
        </div>`
      )
      .join("");

    container.insertAdjacentHTML(
      "beforeend",
      `
      <div class="accordion">
        <div class="accordion-header">
          <img src="${p.image}" alt="${p.name}" />
          <div class="info">
            <h3>${p.name}</h3>
            <span class="status ${p.status}">${capitalize(p.status)}</span>
          </div>
          <button 
            class="main-button"
            data-prod="${p.prod}"
            data-local="${p.local}"
          >
            Ir al sitio
          </button>
          <span class="arrow">▼</span>
        </div>
        <div class="accordion-content">
          ${linksHTML}
        </div>
      </div>
      `
    );
  });
}

// === ACORDEONES ===
function initAccordions() {
  const headers = document.querySelectorAll(".accordion-header");

  headers.forEach((header) => {
    header.addEventListener("click", () => {
      const current = header.parentElement;
      document.querySelectorAll(".accordion").forEach((acc) => {
        if (acc !== current) acc.classList.remove("active");
      });
      current.classList.toggle("active");
    });
  });
}

// === SWITCH DE ENTORNO ===
function initEnvSwitch() {
  const toggle = document.getElementById("envToggle");
  const label = document.getElementById("envLabel");

  // Cargar estado guardado
  const savedEnv = localStorage.getItem("envMode");
  const isLocal = savedEnv === "local";
  toggle.checked = isLocal;
  updateLinks(isLocal);
  label.textContent = isLocal ? "Localhost" : "Producción";

  // Escuchar cambios
  toggle.addEventListener("change", (e) => {
    const localMode = e.target.checked;
    updateLinks(localMode);
    localStorage.setItem("envMode", localMode ? "local" : "prod");
    label.textContent = localMode ? "Localhost" : "Producción";
  });
}

// === ACTUALIZAR LINKS ===
function updateLinks(isLocal) {
  const buttons = document.querySelectorAll(".main-button");
  const anchors = document.querySelectorAll(".sub-link a");

  buttons.forEach((btn) => {
    const url = isLocal ? btn.dataset.local : btn.dataset.prod;
    btn.onclick = () => window.open(url, "_blank");
  });

  anchors.forEach((a) => {
    const url = isLocal ? a.dataset.local : a.dataset.prod;
    a.setAttribute("href", url);
  });
}

// === UTILIDAD: CAPITALIZAR ===
function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}
