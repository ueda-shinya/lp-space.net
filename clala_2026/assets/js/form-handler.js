document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contact-form");
  const csrfInput = form.querySelector('input[name="csrf_token"]');

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(form);

    try {
      const res = await fetch(form.action, {
        method: "POST",
        body: formData
      });

      const result = await res.json();

      // 成功時の処理
      if (result.status === "success" && res.ok) {
        // トークン更新（次回送信用）
        if (result.token) csrfInput.value = result.token;

        // サンクスページへ遷移
        window.location.href = result.redirect;
        return;
      }

      // エラー時の処理
      alert("送信エラー：" + (result.error || "不明なエラーが発生しました。"));
      if (result.token) csrfInput.value = result.token;

    } catch (error) {
      alert("通信エラーが発生しました。");
      console.error(error);
    }
  });
});
