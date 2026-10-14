<?php
/**
 * pages/faqs.php - Searchable help center.
 * Filter with ?cat=clients|freelancers|payments, search with ?q=.
 * Uses native <details> so answers open without JavaScript.
 */
$user_role = "public";
$base_url  = "/TopTunity/";

require_once __DIR__ . '/../includes/data.php';

$page_title = "FAQs";
include '../includes/header.php';
include '../includes/nav.php';

$all = toptunity_faqs();
$cat = isset($_GET['cat']) ? $_GET['cat'] : 'all';
if (!in_array($cat, ['all', 'clients', 'freelancers', 'payments'], true)) { $cat = 'all'; }
$q   = isset($_GET['q']) ? trim($_GET['q']) : '';

$items = array_values(array_filter($all, function ($f) use ($cat, $q) {
    if ($cat !== 'all' && $f['cat'] !== $cat) { return false; }
    if ($q !== '') {
        $hay = $f['q'] . ' ' . $f['a'];
        if (stripos($hay, $q) === false) { return false; }
    }
    return true;
}));

function faq_url($cat, $q)
{
    $params = [];
    if ($cat !== 'all') { $params['cat'] = $cat; }
    if ($q !== '')      { $params['q'] = $q; }
    $qs = http_build_query($params);
    return 'faqs.php' . ($qs ? '?' . $qs : '');
}
?>

<main class="page-browse">
  <div class="container">

    <header class="center-block">
      <h1 style="font-size:2rem; font-weight:700;">FAQs</h1>
      <p style="margin-top:0.35rem; font-size:0.85rem; color:var(--color-muted-gray);">Answers to common questions from visitors, clients and freelancers.</p>
    </header>

    <form class="faq-search" method="get" action="faqs.php" role="search">
      <div class="search-field">
        <?= icon('search', 16) ?>
        <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search FAQs…" aria-label="Search FAQs">
      </div>
      <?php if ($cat !== 'all'): ?><input type="hidden" name="cat" value="<?= e($cat) ?>"><?php endif; ?>
    </form>

    <nav class="seg" style="display:flex; justify-content:center; margin: 1rem auto 0;" aria-label="Filter FAQs">
      <a href="<?= e(faq_url('all', $q)) ?>"         class="<?= $cat === 'all' ? 'is-active' : '' ?>">All</a>
      <a href="<?= e(faq_url('clients', $q)) ?>"     class="<?= $cat === 'clients' ? 'is-active' : '' ?>">Clients</a>
      <a href="<?= e(faq_url('freelancers', $q)) ?>" class="<?= $cat === 'freelancers' ? 'is-active' : '' ?>">Freelancers</a>
      <a href="<?= e(faq_url('payments', $q)) ?>"    class="<?= $cat === 'payments' ? 'is-active' : '' ?>">Payments</a>
    </nav>

    <?php if (!$items): ?>
      <div class="empty-state empty-state--design" style="max-width:720px; margin:1.25rem auto 0;">
        <h3>No questions match your search</h3>
        <p>Try another keyword or category.</p>
        <a href="faqs.php" class="btn btn--dark">Clear filter</a>
      </div>
    <?php else: ?>
      <div class="faq-list">
        <?php foreach ($items as $i => $f): ?>
          <details class="faq-item" <?= $i === 0 ? 'open' : '' ?>>
            <summary><?= e($f['q']) ?></summary>
            <p><?= e($f['a']) ?></p>
          </details>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="faq-help">
      <div>
        <strong>Still need help?</strong>
        <small>Our support team will get back to you within 1–2 business days.</small>
      </div>
      <a href="contact.php" class="btn btn--teal-outline" style="width:auto;">Contact Us</a>
    </div>

  </div>
</main>

<?php include '../includes/footer.php'; ?>