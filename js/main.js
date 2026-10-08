/* TopTunity - global scripts.
   Add modals, tab switching, calculators and form validation below. */

document.addEventListener('DOMContentLoaded', function () {
  // Mobile navigation toggle
  var toggle = document.querySelector('.nav-toggle');
  var menu = document.getElementById('site-menu');

  if (toggle && menu) {
    toggle.addEventListener('click', function () {
      var isOpen = menu.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  }
});

// Auto-submit any form control marked with data-autosubmit (e.g. the sort dropdown)
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('[data-autosubmit]').forEach(function (el) {
    el.addEventListener('change', function () {
      if (el.form) { el.form.submit(); }
    });
  });
});