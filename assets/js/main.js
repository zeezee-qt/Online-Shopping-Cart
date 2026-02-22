document.querySelectorAll('form').forEach((form) => {
  form.addEventListener('submit', () => {
    const btn = form.querySelector('button[type="submit"]');
    if (btn) {
      btn.disabled = true;
      btn.dataset.original = btn.textContent;
      btn.textContent = 'Processing...';
      setTimeout(() => {
        btn.disabled = false;
        btn.textContent = btn.dataset.original || 'Submit';
      }, 1200);
    }
  });
});

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add('show');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.18 });

document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));

const easeOut = (t) => 1 - Math.pow(1 - t, 3);

function animateCounter(el, endValue) {
  const duration = 1200;
  const start = performance.now();

  const tick = (now) => {
    const progress = Math.min((now - start) / duration, 1);
    const current = Math.floor(endValue * easeOut(progress));
    el.textContent = current.toLocaleString();

    if (progress < 1) requestAnimationFrame(tick);
  };

  requestAnimationFrame(tick);
}

document.querySelectorAll('[data-counter]').forEach((counter) => {
  const target = Number(counter.dataset.counter || '0');
  if (target > 0) animateCounter(counter, target);
});
