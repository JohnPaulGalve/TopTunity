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