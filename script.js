const navToggle = document.querySelector(".nav-toggle");
const siteNav = document.querySelector(".site-nav");
const yearTarget = document.querySelector("#current-year");
const revealItems = document.querySelectorAll(".reveal");
const quoteForm = document.querySelector("#orcamento-form");

if (yearTarget) {
  yearTarget.textContent = new Date().getFullYear();
}

if (navToggle && siteNav) {
  navToggle.addEventListener("click", () => {
    const isOpen = siteNav.classList.toggle("is-open");
    navToggle.setAttribute("aria-expanded", String(isOpen));
  });

  siteNav.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => {
      siteNav.classList.remove("is-open");
      navToggle.setAttribute("aria-expanded", "false");
    });
  });
}

if ("IntersectionObserver" in window) {
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.18,
    }
  );

  revealItems.forEach((item) => observer.observe(item));
} else {
  revealItems.forEach((item) => item.classList.add("is-visible"));
}

if (quoteForm) {
  quoteForm.addEventListener("submit", (event) => {
    event.preventDefault();

    const formData = new FormData(quoteForm);
    const number = quoteForm.dataset.whatsappNumber;
    const nome = (formData.get("nome") || "").toString().trim();
    const telefone = (formData.get("telefone") || "").toString().trim();
    const servico = (formData.get("servico") || "").toString().trim();
    const ambiente = (formData.get("ambiente") || "").toString().trim();
    const localizacao = (formData.get("localizacao") || "").toString().trim();
    const prazo = (formData.get("prazo") || "").toString().trim();
    const detalhes = (formData.get("detalhes") || "").toString().trim();

    const parts = [
      "Ola, Maicon. Vim pelo site da Shopping Yokohama e quero pedir um orcamento.",
      "",
      `Nome: ${nome}`,
      telefone ? `Telefone: ${telefone}` : "",
      `Servico: ${servico}`,
      `Ambiente: ${ambiente}`,
      localizacao ? `Bairro ou cidade: ${localizacao}` : "",
      prazo ? `Prazo: ${prazo}` : "",
      `Detalhes: ${detalhes}`,
      "",
      "Posso enviar fotos e medidas pelo WhatsApp.",
    ].filter(Boolean);

    const message = encodeURIComponent(parts.join("\n"));
    const whatsappUrl = `https://wa.me/${number}?text=${message}`;

    window.open(whatsappUrl, "_blank", "noopener,noreferrer");
  });
}
