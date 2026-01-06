// resources/js/welcome.js

document.addEventListener('DOMContentLoaded', () => {
  // =============================
  // Carousel
  // =============================
  const slides = Array.from(document.querySelectorAll('.js-slide'));
  const dots = Array.from(document.querySelectorAll('.js-dot'));
  const btnPrev = document.querySelector('[data-carousel-prev]');
  const btnNext = document.querySelector('[data-carousel-next]');

  if (slides.length) {
    let index = 0;
    let timer = null;

    const show = (i) => {
      index = (i + slides.length) % slides.length;

      slides.forEach((s, idx) => {
        s.classList.toggle('hidden', idx !== index);
        s.classList.toggle('block', idx === index);
      });

      dots.forEach((d, idx) => {
        d.classList.toggle('bg-white/80', idx === index);
        d.classList.toggle('bg-white/40', idx !== index);
      });
    };

    const next = () => show(index + 1);
    const prev = () => show(index - 1);

    btnNext?.addEventListener('click', () => {
      next();
      resetAuto();
    });
    btnPrev?.addEventListener('click', () => {
      prev();
      resetAuto();
    });

    dots.forEach((d) => {
      d.addEventListener('click', () => {
        const i = Number(d.getAttribute('data-carousel-dot') || 0);
        show(i);
        resetAuto();
      });
    });

    const startAuto = () => {
      timer = setInterval(next, 5000);
    };

    const resetAuto = () => {
      if (timer) clearInterval(timer);
      startAuto();
    };

    show(0);
    startAuto();
  }

  // =============================
  // Counter animation (on visible)
  // =============================
  const counters = Array.from(document.querySelectorAll('.js-counter'));

  if (counters.length) {
    const animate = (el) => {
      const target = Number(el.getAttribute('data-target') || '0');
      const duration = 1200;
      const start = performance.now();

      const step = (now) => {
        const progress = Math.min((now - start) / duration, 1);
        const value = Math.floor(progress * target);
        el.textContent = value.toLocaleString('id-ID');
        if (progress < 1) requestAnimationFrame(step);
      };

      requestAnimationFrame(step);
    };

    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const el = entry.target;
            if (el.dataset.animated === '1') return;
            el.dataset.animated = '1';
            animate(el);
          }
        });
      },
      { threshold: 0.35 }
    );

    counters.forEach((c) => io.observe(c));
  }
});
