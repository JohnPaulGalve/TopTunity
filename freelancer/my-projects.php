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
    $accept = $_POST['respond'] === 'accept';
    $err = tt_db_respond_contract((int) $_POST['project'], $accept);
    tt_flash($err ?: ($accept ? 'Contract accepted. The project is now ongoing.' : 'You declined the contract. The project is open again.'));
    header('Location: ' . $base_url . 'freelancer/my-projects.php');
    exit;
}
$offers = array_map(function ($r) {
    return ['id' => 1000 + (int) $r['id'], 'title' => $r['title'], 'client' => $r['client_name'], 'client_company' => '',
            'budget' => (int) ($r['agreed_amount'] ?: $r['budget']), 'deadline' => $r['deadline'], 'status' => 'offer'];
}, tt_db_freelancer_offers());
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
        <div class="project-row__title"><h3><?= e($o['title']) ?></h3><span class="status status--pending">Project Offer</span><span class="pill pill--blue">Fixed Price</span></div>
        <div class="project-row__meta">
          <span>Client <strong><?= e($o['client']) ?></strong></span>
          <span>Amount <strong>₱<?= number_format($o['budget']) ?></strong></span>
          <span>End Date <strong><?= e(date('M d, Y', strtotime($o['deadline']))) ?></strong></span>
        </div>
      </div>
      <div class="offer-row__actions">
        <a href="#accept" class="btn btn--primary">Accept Project</a>
        <a href="#contract" class="btn btn--row-outline">View Contract</a>
        <form method="post" action="my-projects.php" style="display:inline;"><input type="hidden" name="project" value="<?= (int) $o['id'] ?>"><button name="respond" value="decline" class="btn btn--danger-outline">Decline</button></form>
      </div>
    </div>
  </section>

  <!-- Accept Project popup -->
  <div class="modal-overlay" id="accept" role="dialog" aria-modal="true" aria-labelledby="accept-title">
    <div class="modal" style="width:540px;">
      <div class="modal__head">
        <h2 id="accept-title">Accept this project?</h2>
        <a href="#" class="modal__close" aria-label="Close"><?= icon('x', 18) ?></a>
      </div>
      <p class="muted">Review the contract sent by the client.</p>
      <p class="section-tag" style="margin-top:0.8rem;">Contract</p>
      <table class="contract-table">
        <tr><th>Project</th><td><?= e($o['title']) ?></td></tr>
        <tr><th>Client</th><td><?= e($o['client']) ?> · <?= e($o['client_company']) ?></td></tr>
        <tr><th>Billing type</th><td>Fixed Price</td></tr>
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
      <label class="agree"><input type="checkbox" required> I agree to the contract terms</label>
      <div class="modal__foot">
        <form method="post" action="my-projects.php" style="display:inline;"><input type="hidden" name="project" value="<?= (int) $o['id'] ?>"><button name="respond" value="decline" class="btn btn--danger-outline">Decline Project</button></form>
        <form method="post" action="my-projects.php" style="display:inline;"><input type="hidden" name="project" value="<?= (int) $o['id'] ?>"><button name="respond" value="accept" class="btn btn--primary">Accept Project</button></form>
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
          <a href="#review-client" class="btn btn--review"><?= icon('star', 13) ?> Review Client</a>
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
    <div class="modal__who"><?= avatar('#FFEDD5', '#1E293B', 'bun', 36) ?><div><strong>Joy Bautista</strong><small>Bautista Bakeshop · Sari-Sari Store POS System</small></div></div>
    <form method="post" action="my-projects.php">
      <p class="field-label" style="margin-top:1rem; font-size:0.78rem; font-weight:600;">Rating</p>
      <div class="star-pick">
        <?php for ($s = 5; $s >= 1; $s--): ?>
          <input type="radio" id="rc-<?= $s ?>" name="rating" value="<?= $s ?>" <?= $s === 5 ? 'checked' : '' ?>>
          <label for="rc-<?= $s ?>" aria-label="<?= $s ?> stars">★</label>
        <?php endfor; ?>
      </div>
      <div class="field">
        <label for="rc-text" style="font-size:0.78rem; font-weight:600;">Review</label>
        <textarea id="rc-text" name="review" class="input" rows="4" style="height:auto; padding:0.7rem; font-size:0.8rem;" placeholder="How did the client work with you?"></textarea>
      </div>
      <p class="hint"><?= icon('info', 13) ?> Available once the client approves the work · once per project.</p>
      <div class="modal__foot"><a href="#" class="btn btn--outline">Cancel</a><button type="submit" class="btn btn--primary">Submit Review</button></div>
    </form>
  </div>
</div>

</main>

<?php include '../includes/footer.php'; ?>