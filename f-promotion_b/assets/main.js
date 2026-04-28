// 固定ヘッダー/CTAの実際の高さを測ってCSS変数に入れる（ズレ事故防止）
function setHeights() {
  const header = document.querySelector(".l-header");
  const ctaImg = document.querySelector(".floating-cta__img");
  const root = document.documentElement;

  if (header) {
    const h = Math.round(header.getBoundingClientRect().height);
    root.style.setProperty("--header-h", `${h}px`);
  }

  const cta = document.querySelector(".floating-cta__inner");
  if (cta) {
    const h = Math.round(cta.getBoundingClientRect().height);
    root.style.setProperty("--cta-h", `${h}px`);
  }

  if (ctaImg && !ctaImg.complete) {
    ctaImg.addEventListener("load", () => setHeights(), { once: true });
  }
}

// ページ内リンクをスムーズスクロール
function enableSmoothScroll() {
  document.addEventListener("click", (e) => {
    const a = e.target.closest('a[href^="#"]');
    if (!a) return;

    const id = a.getAttribute("href");
    if (!id || id === "#") return;

    const target = document.querySelector(id);
    if (!target) return;

    e.preventDefault();
    target.scrollIntoView({ behavior: "smooth", block: "start" });
  });
}

// CTAクリック計測（Meta Pixel直書き運用）
function enableCtaHook() {
  // 二重バインド防止
  if (document.documentElement.dataset.ctaBound === "1") return;
  document.documentElement.dataset.ctaBound = "1";

  document.addEventListener("click", (e) => {
    const a = e.target.closest("[data-cta]");
    if (!a) return;

    const type = a.getAttribute("data-cta") || "unknown";

    // Meta Pixel：カスタムイベント
    if (window.fbq) {
      fbq("trackCustom", "ClickCTA", { type });
    }
  });
}

// ハンバーガーメニュー（active切替）
function enableHamburger() {
  const ham = document.querySelector("#js-hamburger");
  const nav = document.querySelector("#js-nav");
  if (!ham || !nav) return;

  // 二重バインド防止（これが超重要）
  if (ham.dataset.bound === "1") return;
  ham.dataset.bound = "1";

  const open = () => {
    ham.classList.add("active");
    nav.classList.add("active");
    ham.setAttribute("aria-expanded", "true");
    ham.setAttribute("aria-label", "メニューを閉じる");
  };

  const close = () => {
    ham.classList.remove("active");
    nav.classList.remove("active");
    ham.setAttribute("aria-expanded", "false");
    ham.setAttribute("aria-label", "メニューを開く");
  };

  ham.addEventListener("click", () => {
    const isOpen = nav.classList.contains("active");
    isOpen ? close() : open();
  });

  // メニュー内リンクを押したら閉じる
  nav.addEventListener("click", (e) => {
    const a = e.target.closest("a");
    if (!a) return;
    close();
  });

  // PC幅に戻ったら閉じる
  const mql = window.matchMedia("(min-width: 960px)");
  const onChange = () => {
    if (mql.matches) close();
  };
  if (mql.addEventListener) mql.addEventListener("change", onChange);
  else mql.addListener(onChange);
}

document.addEventListener("DOMContentLoaded", () => {
  setHeights();
  enableSmoothScroll();
  enableCtaHook();
  enableHamburger();

  window.addEventListener("resize", () => {
    setHeights();
  });
});

window.addEventListener("load", () => {
  setHeights();
});
