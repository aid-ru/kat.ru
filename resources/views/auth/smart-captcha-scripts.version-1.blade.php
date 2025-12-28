<script
  src="https://smartcaptcha.cloud.yandex.ru/captcha.js?lang=ru&render=onload&onload=onloadFunction"
  defer
></script>


<script>
const form = document.getElementById('form');

function onloadFunction() {
  if (!window.smartCaptcha) {
    console.error('SmartCaptcha не загрузилась');
    return;
  }

  window.smartCaptcha.render('captcha-container', {
    sitekey: '{{ env('YANDEX_SMART_CAPTCHA_CLIENT_KEY') }}',
    hideShield: true,
    invisible: true,
    lang: 'ru',
    callback: function(token) {
      document.getElementById('smart-captcha-form').submit();
    },
  });
}

function handleSubmit(event) {
  event.preventDefault();

  if (!window.smartCaptcha) {
    return;
  }

  window.smartCaptcha.execute();
}
</script>