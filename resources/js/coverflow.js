document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("[data-coverflow]").forEach(initCoverflow);
});

function initCoverflow(root) {
  const slides = Array.from(root.querySelectorAll("[data-slide]"));
  if (!slides.length) return;

  const prevBtn = root.querySelector("[data-prev]");
  const nextBtn = root.querySelector("[data-next]");

  let active = 0;

  const getStep = () => {
    const w = window.innerWidth;
    if (w < 640) return 190;      // mobile
    if (w < 1024) return 300;     // tablet
    return 380;                  // desktop
  };

  // delta dengan wrap (biar loop)
  const deltaWrap = (i) => {
    const n = slides.length;
    let d = i - active;
    if (d > n / 2) d -= n;
    if (d < -n / 2) d += n;
    return d;
  };

  const apply = () => {
    const step = getStep();

    slides.forEach((el, i) => {
      const d = deltaWrap(i);
      const abs = Math.abs(d);

      const bio = el.querySelector("[data-bio]");

      // tampilkan maksimal 5 (center, +/-1, +/-2)
      if (abs > 2) {
        el.style.opacity = "0";
        el.style.pointerEvents = "none";
        el.style.transform = `translateX(-50%) translateX(0px) scale(0.7)`;
        el.style.zIndex = "0";
        if (bio) bio.classList.add("hidden");
        return;
      }

      const x = d * step;
      const scale = d === 0 ? 1 : abs === 1 ? 0.86 : 0.74;
      const opacity = d === 0 ? 1 : abs === 1 ? 0.35 : 0.15;

      el.style.opacity = String(opacity);
      el.style.pointerEvents = d === 0 ? "auto" : "none";
      el.style.transform = `translateX(-50%) translateX(${x}px) scale(${scale})`;
      el.style.zIndex = d === 0 ? "30" : abs === 1 ? "20" : "10";

      // rapihin teks: bio hanya untuk aktif
      if (bio) {
        if (d === 0) bio.classList.remove("hidden");
        else bio.classList.add("hidden");
      }
    });

    // kalau slide cuma 1, hide arrows
    if (slides.length <= 1) {
      prevBtn?.classList.add("hidden");
      nextBtn?.classList.add("hidden");
    }
  };

  const next = () => {
    active = (active + 1) % slides.length;
    apply();
  };

  const prev = () => {
    active = (active - 1 + slides.length) % slides.length;
    apply();
  };

  nextBtn?.addEventListener("click", next);
  prevBtn?.addEventListener("click", prev);

  // swipe mobile
  let startX = null;
  root.addEventListener("touchstart", (e) => {
    startX = e.touches[0].clientX;
  }, { passive: true });

  root.addEventListener("touchend", (e) => {
    if (startX === null) return;
    const endX = e.changedTouches[0].clientX;
    const dx = endX - startX;
    startX = null;

    if (Math.abs(dx) > 40) {
      if (dx < 0) next();
      else prev();
    }
  });

  window.addEventListener("resize", apply);
  apply();
}
