<?php
session_start();
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="ja">

  <head>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
        w[l] = w[l] || []; w[l].push({
          'gtm.start':
            new Date().getTime(), event: 'gtm.js'
        }); var f = d.getElementsByTagName(s)[0],
          j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
      })(window, document, 'script', 'dataLayer', 'GTM-NWSZ5QSX');</script>
    <!-- End Google Tag Manager -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>CLALA求人|沖縄県島尻郡南風原町津嘉山</title>
    <meta property="og:title" content="">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta property="og:site_name" content="">
    <meta property="og:description" content="">
    <meta property="og:locale" content="ja_JP">
    <meta http-equiv="Cache-Control" content="no-store">
    <link rel="apple-touch-icon" href="./assets/images/favicon.ico" sizes="180x180">
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="icon" href="./assets/images/favicon.ico" sizes="any">
    <link rel="stylesheet" type="text/css" href="./assets/css/destyle.css">
    <link rel="stylesheet" href="./assets/css/style.css?20251228">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;700&display=swap" rel="stylesheet">
  </head>

  <body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NWSZ5QSX" height="0" width="0"
        style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <header>
    </header>
    <main>
      <div class="cta-area cta-page1">
        <img src="./assets/images/clala-lp_01.webp" width="750" height="1800" decoding="async" loading="lazy">
        <a href="https://lin.ee/I5nvBgd" class="btn-cta_a">
          <img class="btn-cta_img  cta-page1 cta_a" src="./assets/images/btn.webp" alt="履歴書不要・見学OK LINEで話を聞いてみる"
            width="755" height="181" decoding="async" loading="lazy">
        </a>
      </div>
      <img src="./assets/images/clala-lp_02.webp" width="750" height="5250" decoding="async" loading="lazy">
      <img src="./assets/images/clala-lp_03.webp" width="750" height="2650" decoding="async" loading="lazy">
      <img src="./assets/images/clala-lp_04.webp" width="750" height="3950" decoding="async" loading="lazy">
      <img src="./assets/images/clala-lp_05.webp" width="750" height="500" decoding="async" loading="lazy">
      <!-- お申込みフォーム -->
      <div id="cta-hide-area">
        <form id="contact-form" name="contact" action="sendmail.php" method="POST">
          <h2>お申込みフォーム</h2>
          <div>
            <label>お名前 <span style="color:red;font-size:0.75em;">(必須)</span>
              <input type="text" name="name" required>
            </label>
          </div>
          <div>
            <label>電話番号 <span style="color:red;font-size:0.75em;">(必須)</span>
              <input type="tel" name="tel" required>
            </label>
          </div>
          <div>
            <label>メールアドレス <span style="color:red;font-size:0.75em;">(必須)</span>
              <input type="email" name="email" required>
            </label>
          </div>
          <div>
            <label>美容歴 <span style="color:red;font-size:0.75em;">(必須)</span>
            </label>
            <select name="career" required aria-required="true">
              <option value="" selected disabled>選択してください</option>
              <option value="3～5年">3～5年</option>
              <option value="6～10年">6～10年</option>
              <option value="11年以上">11年以上</option>
            </select>
          </div>
          <div>
            <label>ご質問・ご要望<textarea name="message" rows="5" placeholder="ご自由にご記入ください"></textarea>
            </label>
          </div>
          <!-- CSRFトークン -->
          <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
          <!-- ハニーポット -->
          <div style="position:absolute; left:-9999px;" aria-hidden="true">
            <label>ニックネーム（空欄にしてください）： <input type="text" name="nickname" tabindex="-1" autocomplete="off">
            </label>
          </div>
          <button type="submit">まずは見学・相談する（無料）</button>
        </form>
        <img src="./assets/images/clala-lp_06.webp?20260407" width="750" height="449" decoding="async" loading="lazy">
      </div>
    </main>
    <!-- 固定スクロールCTA（フォームへ） -->
    <div class="c-scroll-cta-wrap" aria-label="フォームへスクロール">
      <a href="#contact-form" class="c-scroll-cta">
        <img src="./assets/images/scroll_btn.png" alt="フォームへ" width="750" height="180" decoding="async">
      </a>
    </div>

    <footer style="display:none;"></footer>
    <!-- スクリプト -->
    <script src="./assets/js/hide-footer-on-cta.js" defer></script>
    <script src="./assets/js/lazyload-prioritize.js" defer></script>
    <script src="./assets/js/form-handler.js" defer></script>
    <script src="./assets/js/zip.js" defer></script>
    <script src="./assets/js/scroll-cta.js" defer></script>
  </body>
</html>