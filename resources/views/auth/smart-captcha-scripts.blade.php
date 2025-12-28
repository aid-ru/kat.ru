<script
  src="https://smartcaptcha.cloud.yandex.ru/captcha.js"
  defer
></script>


<script>
const form = document.getElementById('form');

function initSmartCaptcha() {
  if (window.smartCaptcha) {
    window.smartCaptcha.render('captcha-container', {
      sitekey: '{{ env('YANDEX_SMART_CAPTCHA_CLIENT_KEY') }}',
      hideShield: true,
      invisible: true,
      hl: 'ru',
      callback: function(token) {
        document.getElementById('smart-captcha-form').submit();
      },
    });
  } else {
    console.error('SmartCaptcha не загрузилась');
  }
}
document.addEventListener('DOMContentLoaded', initSmartCaptcha);

function handleSubmit(event) {
  event.preventDefault();

  if (!window.smartCaptcha) {
    return;
  }

  window.smartCaptcha.execute();
}
</script>
