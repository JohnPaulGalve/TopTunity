<?php
/**
 * freelancer/my-projects.php - Matches the My Projects design: project offers, ongoing, overdue, completed.
 * Accept and decline are shown as popups (CSS :target). Saving is not connected to a database yet.
 */
$user_role     = "freelancer";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "projects";

require_once __DIR__ . '/../includes/data.php';

$all  = toptunity_freelancer_projects();
$tabs = ['all' => 'All', 'offer' => 'Project Offers', 'ongoing' => 'Ongoing', 'overdue' => 'Overdue', 'completed' => 'Completed'];
$tab  = isset($_GET['tab']) && isset($tabs[$_GET['tab']]) ? $_GET['tab'] : 'all';
$counts = ['all' => count($all)];
foreach ($all as $p) { $counts[$p['status']] = ($counts[$p['status']] ?? 0) + 1; }

if (!empty($_POST['respond'])) {
    if ($_POST['respond'] === 'accept' && empty($_POST['agree_policy'])) {
        header('Location: ' . $base_url . 'freelancer/my-projects.php');
        exit;
    }
    $accept = $_POST['respond'] === 'accept';
    $err = tt_db_respond_contract((int) $_POST['project'], $accept);
    tt_flash($err ?: ($accept ? 'Contract accepted. The project is now ongoing.' : 'You declined the contract. The project is open again.'));
    header('Location: ' . $base_url . 'freelancer/my-projects.php');
    exit;
}
$rv = !empty($_GET['review']) ? tt_review_target((int) $_GET['review'] + 0 >= 1000 ? (int) $_GET['review'] : 1000 + (int) $_GET['review']) : null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_project'])) {
    tt_save_client_review((int) $_POST['review_project'], (int) ($_POST['rating'] ?? 0), $_POST['review'] ?? '');
    header('Location: ' . $base_url . 'freelancer/my-projects.php');
    exit;
}
$offers = array_map(function ($r) {
    return ['id' => 1000 + (int) $r['id'], 'title' => $r['title'], 'client' => $r['client_name'],
            'client_company' => $r['client_company'] ?: '', 'type' => $r['billing_type'],
            'rate' => (int) $r['hourly_rate'], 'max_hours' => (int) $r['max_hours'],
            'budget' => (int) ($r['agreed_amount'] ?: $r['budget']), 'deadline' => $r['deadline'], 'status' => 'offer'];
}, tt_db_freelancer_offers());
$counts['offer'] = count($offers);
$counts['all'] = (int) ($counts['all'] ?? 0) + count($offers);
$rows   = array_values(array_filter($all, function ($p) use ($tab) {
    return $p['status'] !== 'offer' && ($tab === 'all' || $tab === $p['status']);
}));
if ($tab === 'offer') { $rows = []; }

$pill = ['ongoing' => 'Ongoing', 'overdue' => 'Overdue', 'completed' => 'Completed'];

$page_title = "My Projects";
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<div class="welcome-row">
  <div>
    <h1>My Projects</h1>
    <p class="subtle">Accept project offers and manage your ongoing work.</p>
  </div>
</div>

<div class="filter-row" style="margin-top:1.25rem;">
  <p class="section-tag" style="margin:0;">Filter by status</p>
  <nav class="filter-tabs" aria-label="Filter by status">
    <?php foreach ($tabs as $key => $t): ?>
      <a href="my-projects.php?tab=<?= e($key) ?>" class="filter-tab <?= $tab === $key ? 'is-active' : '' ?>"><?= e($t) ?> <small><?= (int) ($counts[$key] ?? 0) ?></small></a>
    <?php endforeach; ?>
  </nav>
</div>

<?php foreach ($offers as $o): ?>
  <?php if ($tab === 'all' || $tab === 'offer'): ?>
  <section class="offer-box" id="offer" style="margin-top:1.25rem;">
    <div class="offer-box__head">
      <h2><?= icon('briefcase', 16) ?> Project Offer</h2>
      <small>A client selected you. Review the contract.</small>
    </div>
    <div class="offer-row">
      <div>
        <div class="project-row__title"><h3><?= e($o['title']) ?></h3>        <span class="status status--pending">Project Offer</span><span class="pill pill--blue"><?= $o['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></span></div>
        <div class="project-row__meta">
          <span>Client <strong><?= e($o['client']) ?></strong></span>
          <span>Amount <strong>₱<?= number_format($o['budget']) ?></strong></span>
          <span>End Date <strong><?= e(date('M d, Y', strtotime($o['deadline']))) ?></strong></span>
        </div>
      </div>
      <div class="offer-row__actions" style="display:flex; flex-direction:column; gap:0.6rem; align-items:stretch;">
        <a href="#accept-<?= (int) $o['id'] ?>" class="btn btn--primary" style="text-align:center;">Accept Project</a>
        <div style="display:flex; gap:0.6rem;">
          <a href="#contract-<?= (int) $o['id'] ?>" class="btn btn--row-outline" style="flex:1; text-align:center;">View Contract</a>
          <form method="post" action="my-projects.php" style="flex:1; display:flex;"><input type="hidden" name="project" value="<?= (int) $o['id'] ?>"><button name="respond" value="decline" class="btn btn--danger-outline" style="flex:1;">Decline</button></form>
        </div>
      </div>
    </div>
  </section>

  <div class="modal-overlay" id="contract-<?= (int) $o['id'] ?>" role="dialog" aria-modal="true" aria-labelledby="contract-title-<?= (int) $o['id'] ?>">
    <div class="modal" style="width:540px;">
      <div class="modal__head">
        <h2 id="contract-title-<?= (int) $o['id'] ?>">Project Contract</h2>
        <a href="#" class="modal__close" aria-label="Close"><?= icon('x', 18) ?></a>
      </div>
      <table class="contract-table">
        <tr><th>Project</th><td><?= e($o['title']) ?></td></tr>
        <tr><th>Client</th><td><?= e($o['client']) ?><?= $o['client_company'] !== '' ? ' · ' . e($o['client_company']) : '' ?></td></tr>
        <tr><th>Billing type</th><td><?= $o['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></td></tr>
        <?php if ($o['type'] === 'hourly'): ?>
          <tr><th>Hourly rate</th><td>₱<?= number_format($o['rate']) ?>/hr</td></tr>
          <tr><th>Maximum hours</th><td><?= (int) $o['max_hours'] ?> hours</td></tr>
        <?php endif; ?>
        <tr><th>Agreed amount</th><td>₱<?= number_format($o['budget']) ?></td></tr>
        <tr><th>Start date</th><td>Today, <?= e(date('M d, Y')) ?> (the day you accept)</td></tr>
        <tr><th>End date</th><td><?= e(date('M d, Y', strtotime($o['deadline']))) ?></td></tr>
        <tr><th>Platform service fee</th><td>10% (– ₱<?= number_format($o['budget'] * 0.1) ?>) · you receive ₱<?= number_format($o['budget'] * 0.9) ?></td></tr>
      </table>
      <div class="note-box">
        <ul>
          <li>The client will be asked to deposit the project amount (held).</li>
          <li>Hourly projects: log your hours. You are billed on the End Date.</li>
          <li>All payments are simulated (no real money).</li>
        </ul>
      </div>
      <div class="modal__foot"><a href="#accept-<?= (int) $o['id'] ?>" class="btn btn--primary">Review and Accept</a></div>
    </div>
  </div>

  <!-- Accept Project popup -->
  <div class="modal-overlay" id="accept-<?= (int) $o['id'] ?>" role="dialog" aria-modal="true" aria-labelledby="accept-title-<?= (int) $o['id'] ?>">
    <div class="modal" style="width:540px;">
      <div class="modal__head">
        <h2 id="accept-title-<?= (int) $o['id'] ?>">Accept this project?</h2>
        <a href="#" class="modal__close" aria-label="Close"><?= icon('x', 18) ?></a>
      </div>
      <p class="muted">Review the contract sent by the client.</p>
      <p class="section-tag" style="margin-top:0.8rem;">Contract</p>
      <table class="contract-table">
        <tr><th>Project</th><td><?= e($o['title']) ?></td></tr>
        <tr><th>Client</th><td><?= e($o['client']) ?> · <?= e($o['client_company']) ?></td></tr>
        <tr><th>Billing type</th><td><?= $o['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></td></tr>
        <?php if ($o['type'] === 'hourly'): ?>
          <tr><th>Hourly rate</th><td>₱<?= number_format($o['rate']) ?>/hr</td></tr>
          <tr><th>Maximum hours</th><td><?= (int) $o['max_hours'] ?> hours</td></tr>
        <?php endif; ?>
        <tr><th>Agreed amount</th><td>₱<?= number_format($o['budget']) ?></td></tr>
        <tr><th>Start date</th><td>Today, <?= e(date('M d, Y')) ?> (the day you accept)</td></tr>
        <tr><th>End date</th><td><?= e(date('M d, Y', strtotime($o['deadline']))) ?></td></tr>
        <tr><th>Platform service fee</th><td>10% (– ₱<?= number_format($o['budget'] * 0.1) ?>) · you receive ₱<?= number_format($o['budget'] * 0.9) ?></td></tr>
      </table>
      <div class="note-box">
        <ul>
          <li>The client will be asked to deposit the project amount (held).</li>
          <li>Hourly projects: log your hours. You are billed on the End Date.</li>
          <li>If you decline, the project reopens for the client.</li>
          <li>All payments are simulated (no real money).</li>
        </ul>
      </div>
      <div class="modal__foot contract-actions">
        <form method="post" action="my-projects.php" style="display:inline;"><input type="hidden" name="project" value="<?= (int) $o['id'] ?>"><button name="respond" value="decline" class="btn btn--danger-outline">Decline Project</button></form>
        <form method="post" action="my-projects.php" data-requires-checkbox="agree_policy" class="contract-accept">
          <input type="hidden" name="project" value="<?= (int) $o['id'] ?>">
          <label class="agree"><input type="checkbox" name="agree_policy" value="1"> I agree to the contract terms</label>
          <button type="submit" name="respond" value="accept" class="btn btn--primary" disabled>Accept Project</button>
        </form>
      </div>
    </div>
  </div>
  <?php endif; ?>
<?php endforeach; ?>

<?php if ($tab === 'offer' && !$offers): ?>
  <div class="empty-state empty-state--design" style="margin-top:1.5rem;">
    <div class="empty-art"><?= icon('briefcase', 40) ?></div>
    <h3>No project offers right now</h3>
    <p>When a client selects you, the offer appears here.</p>
  </div>
<?php endif; ?>

<?php if ($tab !== 'offer'): ?>
<div class="project-list" style="margin-top:1.25rem;">
  <?php if (!$rows && $tab !== 'all'): ?>
    <div class="empty-state empty-state--design">
      <div class="empty-art"><?= icon('briefcase', 40) ?></div>
      <h3>No <?= e($tabs[$tab]) ?> projects</h3>
      <p>Projects in this status will appear here.</p>
    </div>
  <?php endif; ?>
  <?php foreach ($rows as $p): ?>
    <article class="project-row" style="grid-template-columns: 40px 1fr auto;">
      <span class="icon-box icon-box--<?= $p['status'] === 'overdue' ? 'orange' : ($p['status'] === 'completed' ? 'teal' : 'blue') ?> project-row__icon"><?= icon($p['status'] === 'overdue' ? 'alert' : ($p['status'] === 'completed' ? 'check-circle' : 'refresh'), 18) ?></span>
      <div>
        <div class="project-row__title">
          <h3><?= e($p['title']) ?></h3>
          <span class="status status--<?= e($p['status']) ?>"><?= e($pill[$p['status']]) ?></span>
          <span class="pill pill--blue"><?= $p['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></span>
        </div>
        <div class="project-row__meta">
          <span>Client <strong><?= e($p['client']) ?></strong></span>
          <?php if ($p['type'] === 'hourly'): ?>
            <span>Rate <strong>₱<?= number_format($p['rate']) ?>/hr</strong></span>
          <?php else: ?>
            <span>Amount <strong>₱<?= number_format($p['budget']) ?></strong></span>
          <?php endif; ?>
          <span>Start <strong><?= e(date('M d, Y', strtotime($p['start']))) ?></strong></span>
          <span>End <strong><?= e(date('M d, Y', strtotime($p['deadline']))) ?></strong></span>
        </div>
      </div>
      <div class="project-row__actions">
        <?php if ($p['status'] === 'completed'): ?>
          <a href="my-projects.php?review=<?= (int) $p['id'] ?>#review-client" class="btn btn--review"><?= icon('star', 13) ?> Review Client</a>
        <?php endif; ?>
        <a href="project-details.php?id=<?= (int) $p['id'] ?>" class="btn--row-dark">View Details</a>
      </div>
    </article>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Review Client popup -->
<div class="modal-overlay" id="review-client" role="dialog" aria-modal="true" aria-labelledby="rc-title">
  <div class="modal">
    <div class="modal__head"><h2 id="rc-title">Review Client</h2><a href="#" class="modal__close" aria-label="Close"><?= icon('x', 18) ?></a></div>
    <div class="modal__who"><?= avatar('#FFEDD5', '#1E293B', 'bun', 36) ?><div><?php if (tt_is_demo_freelancer()): ?><strong>Joy Bautista</strong><small>Bautista Bakeshop · Sari-Sari Store POS System</small><?php elseif ($rv): ?><strong><?= e($rv['client_name']) ?></strong><small><?= e($rv['project']['title']) ?></small><?php else: ?><strong>Your client</strong><small>Open this from a completed project</small><?php endif; ?></div></div>
    <form method="post" action="my-projects.php?review=<?= (int) ($rv ? $rv['project']['id'] : 0) ?>#review-client">
      <input type="hidden" name="review_project" value="<?= (int) ($rv ? $rv['project']['id'] + 1000 : 0) ?>">
      <p class="field-label" style="margin-top:1rem; font-size:0.78rem; font-weight:600;">Rating</p>
      <div class="star-pick">
        <?php for ($s = 5; $s >= 1; $s--): ?>
          <input type="radio" id="rc-<?= $s ?>" name="rating" value="<?= $s ?>" <?= $s === 5 ? 'checked' : '' ?>>
          <label for="rc-<?= $s ?>" aria-label="<?= $s ?> stars">★</label>
        <?php endfor; ?>
      </div>
      <div class="field">
        <label for="rc-text" style="font-size:0.78rem; font-weight:600;">Review</label>
        <textarea id="rc-text" name="review" class="input" rows="4" minlength="10" style="height:auto; padding:0.7rem; font-size:0.8rem;" placeholder="How did the client work with you?"></textarea>
      </div>
      <p class="hint"><?= icon('info', 13) ?> Available once the client approves the work · once per project.</p>
      <div class="modal__foot"><a href="#" class="btn btn--outline">Cancel</a><button type="submit" class="btn btn--primary">Submit Review</button></div>
    </form>
  </div>
</div>

</main>

<?php include '../includes/footer.php'; ?>