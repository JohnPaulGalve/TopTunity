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

// Post a Project form: skill tags, description counter, computed hourly total, attachment list
document.addEventListener('DOMContentLoaded', function () {
  // Skill tags
  var skillBox = document.getElementById('skill-box');
  var skillInput = document.getElementById('skill-input');
  if (skillBox && skillInput) {
    function addSkill(name) {
      name = name.trim();
      if (!name) return;
      var exists = Array.prototype.some.call(skillBox.querySelectorAll('input[name="skills[]"]'), function (i) {
        return i.value.toLowerCase() === name.toLowerCase();
      });
      if (exists) return;
      var chip = document.createElement('span');
      chip.className = 'chip--removable';
      chip.textContent = name;
      var hidden = document.createElement('input');
      hidden.type = 'hidden'; hidden.name = 'skills[]'; hidden.value = name;
      var x = document.createElement('button');
      x.type = 'button'; x.className = 'chip-x'; x.setAttribute('aria-label', 'Remove ' + name);
      x.innerHTML = '&times;';
      x.addEventListener('click', function () { chip.remove(); });
      chip.appendChild(hidden);
      chip.appendChild(x);
      skillBox.insertBefore(chip, skillInput);
    }
    skillInput.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ',') {
        e.preventDefault();
        addSkill(skillInput.value);
        skillInput.value = '';
      }
    });
    skillBox.querySelectorAll('.chip-x').forEach(function (btn) {
      btn.addEventListener('click', function () { btn.parentElement.remove(); });
    });
  }

  // Description character counter
  var desc = document.getElementById('description');
  var count = document.getElementById('desc-count');
  if (desc && count) {
    var update = function () { count.textContent = desc.value.length.toLocaleString() + ' / ' + desc.maxLength.toLocaleString() + ' characters'; };
    desc.addEventListener('input', update);
    update();
  }

  // Hourly: budget = rate x maximum hours
  var rate = document.getElementById('hourly-rate');
  var maxh = document.getElementById('max-hours');
  var total = document.getElementById('hourly-total');
  if (rate && maxh && total) {
    var recalc = function () {
      var r = parseFloat(rate.value) || 0, h = parseFloat(maxh.value) || 0;
      total.innerHTML = 'Budget (computed automatically): <strong>₱' + (r * h).toLocaleString() + '</strong>';
    };
    rate.addEventListener('input', recalc);
    maxh.addEventListener('input', recalc);
    recalc();
  }

  // Attachments: show chosen files
  var fileInput = document.getElementById('attachments');
  var fileList = document.getElementById('new-files');
  if (fileInput && fileList) {
    fileInput.addEventListener('change', function () {
      fileList.innerHTML = '';
      Array.prototype.forEach.call(fileInput.files, function (f) {
        var row = document.createElement('div');
        row.className = 'file-row';
        var name = document.createElement('span');
        name.textContent = f.name;
        var size = document.createElement('span');
        size.className = 'file-row__size';
        size.textContent = (f.size / 1024 / 1024).toFixed(1) + ' MB';
        row.appendChild(name);
        row.appendChild(size);
        fileList.appendChild(row);
      });
    });
  }
});


// Client area: the menu button collapses and restores the sidebar
document.addEventListener('DOMContentLoaded', function () {
  var menuBtn = document.querySelector('.app-menu-btn');
  var shell = document.querySelector('.app-shell');
  if (menuBtn && shell) {
    menuBtn.addEventListener('click', function () {
      var collapsed = shell.classList.toggle('app-shell--collapsed');
      menuBtn.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
    });
  }
});

/* ==========================================================================
   FORM VALIDATION (all forms)
   Shows a message under each invalid field instead of the browser's pop-up.
   Checks: required, email, minimum length, a number in passwords, password
   confirmation, minimum numbers, dates from today onward, and required checkboxes.
   Add data-no-validate to a <form> to skip it.
   ========================================================================== */
(function () {
  var EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  function fieldWrap(el) {
    return el.closest('.field') || el.parentNode;
  }

  function clearError(el) {
    el.classList.remove('is-invalid');
    var wrap = fieldWrap(el);
    var old = wrap.querySelector(':scope > .field-error');
    if (old) { old.remove(); }
  }

  function showError(el, message) {
    clearError(el);
    el.classList.add('is-invalid');
    var note = document.createElement('div');
    note.className = 'field-error';
    note.setAttribute('role', 'alert');
    note.textContent = message;
    fieldWrap(el).appendChild(note);
  }

  function isEmpty(el) {
    if (el.tagName === 'SELECT') {
      return el.value === '' || (el.options[el.selectedIndex] && el.options[el.selectedIndex].disabled);
    }
    return el.value.trim() === '';
  }

  function validate(el, form) {
    if (el.type === 'hidden' || el.type === 'file' || el.type === 'radio' || el.disabled) { return ''; }

    if (el.type === 'checkbox') {
      return el.hasAttribute('required') && !el.checked ? 'Please tick this box to continue.' : '';
    }
    if (el.hasAttribute('required') && isEmpty(el)) {
      return el.tagName === 'SELECT' ? 'Please choose an option.' : 'This field is required.';
    }
    if (isEmpty(el)) { return ''; }

    if (el.type === 'email' && !EMAIL.test(el.value.trim())) {
      return 'Please enter a valid email address.';
    }
    if (el.type === 'number' && el.min !== '' && Number(el.value) < Number(el.min)) {
      return 'Please enter a number of at least ' + el.min + '.';
    }
    if (el.type === 'date' && el.min !== '' && el.value < el.min) {
      return 'Please choose a date from ' + el.min + ' onward.';
    }
    if (el.minLength > 0 && el.value.length < el.minLength) {
      return 'Please use at least ' + el.minLength + ' characters.';
    }
    if (el.type === 'password' && el.minLength > 0 && !/\d/.test(el.value)) {
      return 'Please include at least one number.';
    }
    if (el.name === 'confirm') {
      var first = form.querySelector('input[type="password"][name="new"], input[type="password"][name="password"]');
      if (first && first.value !== el.value) { return 'The passwords do not match.'; }
    }
    return '';
  }

  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form').forEach(function (form) {
      if (form.hasAttribute('data-no-validate')) { return; }
      var fields = form.querySelectorAll('input, select, textarea');
      var hasRules = Array.prototype.some.call(fields, function (el) {
        return el.hasAttribute('required') || el.minLength > 0 || el.min !== '' || el.type === 'email' || el.name === 'confirm';
      });
      if (!hasRules) { return; }

      form.setAttribute('novalidate', '');

      fields.forEach(function (el) {
        el.addEventListener('input', function () { clearError(el); });
        el.addEventListener('change', function () { clearError(el); });
      });

      form.addEventListener('submit', function (e) {
        var firstBad = null;
        fields.forEach(function (el) {
          var message = validate(el, form);
          if (message) {
            showError(el, message);
            if (!firstBad) { firstBad = el; }
          } else {
            clearError(el);
          }
        });
        if (firstBad) {
          e.preventDefault();
          firstBad.focus();
        }
      });
    });
  });
})();

/* Placeholder links (href="#") show a short notice instead of doing nothing.
   Popup close/cancel links are skipped, because they use # to close the popup. */
document.addEventListener('click', function (e) {
  var a = e.target.closest && e.target.closest('a[href="#"]');
  if (!a || a.closest('.modal-overlay')) { return; }
  e.preventDefault();
  var box = document.getElementById('tt-toast');
  if (!box) {
    box = document.createElement('div');
    box.id = 'tt-toast';
    box.className = 'tt-toast';
    box.setAttribute('role', 'status');
    document.body.appendChild(box);
  }
  box.textContent = 'This action will work once the database is connected.';
  box.classList.add('is-visible');
  clearTimeout(box._t);
  box._t = setTimeout(function () { box.classList.remove('is-visible'); }, 2800);
});