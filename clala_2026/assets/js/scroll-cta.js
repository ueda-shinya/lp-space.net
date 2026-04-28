(() => {
  const wrap = document.querySelector('.c-scroll-cta-wrap');
  const link = document.querySelector('.c-scroll-cta');
  const hideArea = document.querySelector('#cta-hide-area'); // 修正：エリア全体を取得
  const form = document.querySelector('#contact-form');

  if (!wrap || !link) return;

  const SHOW_AFTER_Y = 120;

  const updateVisibility = (isInsideHideArea = false) => {
    const isScrolledEnough = window.scrollY > SHOW_AFTER_Y;
    
    // 「一定量スクロールした」かつ「非表示エリアの中にいない」ときだけ表示
    if (isScrolledEnough && !isInsideHideArea) {
      wrap.classList.add('is-visible');
    } else {
      wrap.classList.remove('is-visible');
    }
  };

  window.addEventListener('scroll', () => {
    // datasetを使って現在の交差状態を保持
    updateVisibility(wrap.dataset.isIntersecting === 'true');
  }, { passive: true });

  if (hideArea) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        // エリアに入ったらtrue、出たらfalse
        wrap.dataset.isIntersecting = entry.isIntersecting;
        updateVisibility(entry.isIntersecting);
      });
    }, {
      root: null,
      threshold: 0,
      rootMargin: "0px" // 画面に入った瞬間に反応
    });

    io.observe(hideArea);
  }

  // スムーススクロール
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const target = form || document.querySelector(link.getAttribute('href'));
    if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
  });
})();