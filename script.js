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
  const container = document.querySelector(".projects-grid");

  projects.forEach((p) => {
    const validLinks = (p.links || []).filter((l) => l && l.label);
    const hasLinks = validLinks.length > 0;

    const linksHTML = validLinks
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

    const env = p.env || "";
    const envLabel = env === "prod" ? "PROD" : env === "qa" ? "QA" : "";
    const envBadge = env
      ? `<span class="env-badge env-${env}"><span class="env-dot"></span>${envLabel}</span>`
      : "";

    const logo = p.image
      ? `<img src="${p.image}" alt="${p.name}" />`
      : `<div class="logo-placeholder">${initials(p.name)}</div>`;

    container.insertAdjacentHTML(
      "beforeend",
      `
      <div class="accordion env-${env || "neutral"}${hasLinks ? "" : " no-links"}">
        <div class="accordion-header">
          <div class="logo">${logo}</div>
          <div class="info">
            <h3>${displayName(p.name)}</h3>
            ${envBadge}
          </div>
          ${hasLinks ? '<span class="arrow">▼</span>' : ""}
        </div>
        <div class="card-actions">
          <button
            class="main-button"
            data-prod="${p.prod}"
            data-local="${p.local}"
          >
            Visitar sitio <span class="btn-arrow">↗</span>
          </button>
        </div>
        <div class="accordion-content">
          ${linksHTML}
        </div>
      </div>
      `
    );
  });
}

// === NOMBRE LIMPIO (sin sufijo de entorno, ya lo muestra el badge) ===
function displayName(name) {
  return name.replace(/\s*[—–-]\s*(QA|PROD[A-ZÁÉÍÓÚÑa-záéíóúñ]*)\s*$/i, "").trim();
}

// === INICIALES PARA LOGO PLACEHOLDER ===
function initials(name) {
  return name
    .replace(/[—-].*$/, "") // quitar sufijo de entorno
    .trim()
    .split(/\s+/)
    .slice(0, 2)
    .map((w) => w.charAt(0))
    .join("")
    .toUpperCase();
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
