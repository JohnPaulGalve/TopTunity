<?php
/**
 * client/project-tracking.php - Project details for the client.
 * Tabs: ?tab=overview|proposals|contract|tracking
 * Popups use CSS :target, so links like #select-freelancer-1 open them without JavaScript.
 */
$user_role     = "client";
$base_url      = "/Webdev/";
$active_client = "projects";

require_once __DIR__ . '/../includes/data.php';

$projects = toptunity_client_projects();
$id       = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$p        = isset($projects[$id]) ? $projects[$id] : null;
$public   = $p ? toptunity_client_detail($id) : null;

$tabs = ['overview' => 'Overview', 'proposals' => 'Proposals and Recommended Freelancers', 'contract' => 'Contract', 'tracking' => 'Project Tracking'];
$tab  = isset($_GET['tab']) && isset($tabs[$_GET['tab']]) ? $_GET['tab'] : 'overview';

$freelancers = toptunity_freelancers();
$proposals   = toptunity_project_proposals($id);
$tracking    = toptunity_project_tracking($id);
$required    = $public ? $public['skills'] : [];

/* Freelancer on the contract: the assigned one, or the one picked from a proposal */
$assigned = ($p && $p['freelancer']) ? toptunity_freelancer_by_name($p['freelancer']) : null;
$picked   = isset($_GET['freelancer']) ? toptunity_freelancer((int) $_GET['freelancer']) : null;
$picked_id = isset($_GET['freelancer']) ? (int) $_GET['freelancer'] : 0;
$contract_fl = $assigned ?: ($picked ? ['id' => $picked_id] + $picked : null);

function match_pct($required, $skills)
{
    if (!$required) { return 0; }
    $have = array_map('strtolower', $skills);
    $hit  = 0;
    foreach ($required as $r) {
        if (in_array(strtolower($r), $have, true)) { $hit++; }
    }
    return (int) round($hit / count($required) * 100);
}

/* Recommended freelancers: best skill match */
$recommended = [];
foreach ($freelancers as $fid => $f) {
    $recommended[] = ['id' => $fid, 'f' => $f, 'pct' => match_pct($required, $f['skills'])];
}
usort($recommended, function ($a, $b) { return $b['pct'] <=> $a['pct']; });
$recommended = array_slice($recommended, 0, 4);

$steps = ['Project Posted', 'Proposals Submitted', 'Freelancer Selected', 'Contract Accepted', 'Project Started', 'Work Submitted', 'Client Review', 'Completed'];

/* Days left until the deadline (relative to today) */
$days_left = $p ? (int) ceil((strtotime($p['deadline']) - strtotime(date('Y-m-d'))) / 86400) : 0;

$page_title = $p ? $p['title'] : 'Project not found';
include '../includes/header.php';
include '../includes/client-nav.php';
?>

<?php if (!$p): ?>
  <div class="not-found">
    <div class="empty-art"><?= icon('alert', 40) ?></div>
    <h1>Project not found</h1>
    <p>This project is not available.</p>
    <a href="my-projects.php" class="btn btn--dark">Back to My Projects</a>
  </div>

<?php else: ?>

  <!-- ===================== HEADER ===================== -->
  <nav class="crumbs" aria-label="Breadcrumb">
    <a href="my-projects.php">My Projects</a><span>/</span><span aria-current="page">Project Details</span>
  </nav>

  <div class="head-row">
    <div>
      <div style="display:flex; align-items:center; gap:0.6rem; flex-wrap:wrap;">
        <h1><?= e($p['title']) ?></h1>
        <span class="status status--<?= e($p['status']) ?>"><?= e(toptunity_status_label($p['status'])) ?></span>
      </div>
      <div class="head-meta">
        <span><strong><?= e($p['category']) ?></strong></span>
        <span>Billing <strong><?= $p['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></strong></span>
        <?php if ($p['type'] === 'hourly'): ?>
          <span>Hourly rate <strong>₱<?= number_format($p['rate']) ?>/hr</strong></span>
          <span>Max hours <strong><?= (int) $p['max_hours'] ?> hrs</strong></span>
        <?php endif; ?>
        <span>Budget <strong>₱<?= number_format($p['budget']) ?></strong></span>
        <span>Deadline <strong><?= e(date('M d, Y', strtotime($p['deadline']))) ?></strong></span>
      </div>
      <?php if ($required): ?>
        <div class="head-meta">
          <span>Required skills</span>
          <div class="skill-chips">
            <?php foreach ($required as $s): ?><span class="chip"><?= e($s) ?></span><?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div class="head-actions">
      <?php if ($p['status'] === 'open'): ?>
        <a href="post-project.php?id=<?= (int) $id ?>" class="btn btn--row-outline"><?= icon('edit', 13) ?> Edit Project</a>
        <a href="project-tracking.php?id=<?= (int) $id ?>&amp;action=cancel" class="btn btn--danger-outline"><?= icon('x-circle', 13) ?> Cancel Project</a>
      <?php endif; ?>
      <?php if ($assigned && in_array($p['status'], ['ongoing', 'overdue', 'completed'], true)): ?>
        <a href="messages.php" class="btn btn--row-outline"><?= icon('message', 13) ?> Message Freelancer</a>
      <?php endif; ?>
      <?php if (in_array($p['status'], ['ongoing', 'overdue'], true)): ?>
        <a href="report-dispute.php?id=<?= (int) $id ?>" class="btn btn--danger-outline"><?= icon('flag', 13) ?> File a Dispute</a>
      <?php endif; ?>
      <?php if ($p['status'] === 'completed' && $assigned): ?>
        <a href="#review" class="btn btn--review"><?= icon('star', 13) ?> Review Freelancer</a>
      <?php endif; ?>
    </div>
  </div>

  <!-- ===================== TABS ===================== -->
  <nav class="tab-nav" aria-label="Project sections">
    <?php foreach ($tabs as $key => $label): ?>
      <a href="project-tracking.php?id=<?= (int) $id ?>&amp;tab=<?= e($key) ?>" class="<?= $tab === $key ? 'is-active' : '' ?>">
        <?= e($label) ?>
        <?php if ($key === 'proposals'): ?><span class="count"><?= (int) $p['proposals'] ?></span><?php endif; ?>
      </a>
    <?php endforeach; ?>
  </nav>

  <?php /* ===================== OVERVIEW ===================== */ if ($tab === 'overview'): ?>
    <div class="two-col">
      <div class="stack">
        <section class="box">
          <h2>Description</h2>
          <p><?= e($public['intro'] ?? $public['desc']) ?></p>
          <?php if (!empty($public['features'])): ?>
            <ul class="dots">
              <?php foreach ($public['features'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
            </ul>
          <?php endif; ?>
          <?php if (!empty($public['closing'])): ?><p><?= e($public['closing']) ?></p><?php endif; ?>
        </section>
      </div>

      <div class="stack">
        <section class="box">
          <h2>Project Facts</h2>
          <div class="kv"><span>Posted</span><strong><?= e(date('M d, Y', strtotime($p['posted']))) ?></strong></div>
          <div class="kv"><span>Deadline</span><strong><?= e(date('M d, Y', strtotime($p['deadline']))) ?></strong></div>
          <div class="kv"><span>Proposals</span><strong><?= (int) $p['proposals'] ?></strong></div>
          <div class="kv"><span>Freelancer</span><strong><?= $p['freelancer'] ? e($p['freelancer']) : 'Not selected yet' ?></strong></div>
        </section>

        <?php if (!empty($public['files'])): ?>
        <section class="box">
          <h2>Attachments</h2>
          <div class="file-list" style="margin-top:0;">
            <?php foreach ($public['files'] as $f): ?>
              <div class="file-row"><?= icon('file', 15) ?><span><?= e($f['name']) ?></span><span class="file-row__size"><?= e($f['size']) ?></span></div>
            <?php endforeach; ?>
          </div>
        </section>
        <?php endif; ?>
      </div>
    </div>

  <?php /* ===================== PROPOSALS ===================== */ elseif ($tab === 'proposals'): ?>
    <div class="two-col">
      <div>
        <div class="box-head" style="display:flex; align-items:center; justify-content:space-between; margin-top:1.25rem; margin-bottom:0.8rem;">
          <h2 style="font-size:0.95rem; font-weight:700;">Proposals (<?= (int) $p['proposals'] ?>)</h2>
          <span class="muted">Showing <?= count($proposals) ?> of <?= (int) $p['proposals'] ?></span>
        </div>

        <?php if (!$proposals): ?>
          <div class="empty-state empty-state--design">
            <div class="empty-art"><?= icon('clipboard', 40) ?></div>
            <h3>No proposals yet</h3>
            <p>Freelancers will send proposals here once your project is open.</p>
          </div>
        <?php endif; ?>

        <?php foreach ($proposals as $pr):
          $f = toptunity_freelancer($pr['freelancer_id']);
          if (!$f) { continue; }
          $fid = (int) $pr['freelancer_id'];
        ?>
          <article class="proposal-card">
            <div class="proposal-top">
              <div class="proposal-who">
                <?= avatar($f['bg'], $f['hair'], $f['style'], 42) ?>
                <div>
                  <strong><?= e($f['name']) ?></strong>
                  <small><?= e($f['title']) ?> · <?= e($f['location']) ?></small>
                  <div class="stars-line"><?= stars($f['rating']) ?> <small><?= e($f['rating']) ?> (<?= (int) $f['reviews'] ?>)</small></div>
                </div>
              </div>
              <div class="proposal-price">
                <strong>₱<?= number_format($pr['offer']) ?></strong>
                <small>Est. <?= (int) $pr['days'] ?> days</small>
              </div>
            </div>

            <p><?= e($pr['letter']) ?></p>

            <div class="proposal-foot">
              <div class="chips">
                <?php foreach ($f['skills'] as $s): ?><span class="chip"><?= e($s) ?></span><?php endforeach; ?>
              </div>
              <div class="proposal-actions">
                <a href="freelancer-profile.php?id=<?= $fid ?>" class="btn btn--row-outline"><?= icon('user', 13) ?> View Freelancer Profile</a>
                <a href="messages.php" class="btn btn--row-outline"><?= icon('message', 13) ?> Message Freelancer</a>
                <a href="#select-<?= $fid ?>" class="btn btn--select"><?= icon('user', 13) ?> Select Freelancer</a>
              </div>
            </div>
          </article>

          <!-- Select Freelancer popup -->
          <div class="modal-overlay" id="select-<?= $fid ?>" role="dialog" aria-modal="true" aria-labelledby="select-title-<?= $fid ?>">
            <div class="modal">
              <div class="modal__head">
                <h2 id="select-title-<?= $fid ?>">Select this freelancer?</h2>
                <a href="#" class="modal__close" aria-label="Close"><?= icon('x', 18) ?></a>
              </div>
              <div class="modal__who">
                <?= avatar($f['bg'], $f['hair'], $f['style'], 36) ?>
                <div style="flex:1;">
                  <strong><?= e($f['name']) ?></strong>
                  <small>Offer ₱<?= number_format($pr['offer']) ?> · <?= (int) $pr['days'] ?> days</small>
                </div>
                <span class="status status--open"><?= (int) match_pct($required, $f['skills']) ?>% match</span>
              </div>
              <div class="warn-list">
                <h3><?= icon('alert', 14) ?> Before you continue</h3>
                <ul>
                  <li>Only one freelancer can be selected.</li>
                  <li>The project stops accepting proposals.</li>
                  <li>The other <?= max(0, (int) $p['proposals'] - 1) ?> proposals are marked as Not Selected.</li>
                  <li>Next, you send the Contract. The freelancer must accept it.</li>
                  <li>If the freelancer declines, the project reopens.</li>
                </ul>
              </div>
              <div class="modal__foot">
                <a href="#" class="btn btn--outline">Cancel</a>
                <a href="project-tracking.php?id=<?= (int) $id ?>&amp;tab=contract&amp;freelancer=<?= $fid ?>" class="btn btn--primary"><?= icon('arrow-right', 14) ?> Select Freelancer → Contract</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <aside class="box" style="margin-top:1.25rem;">
        <h2>Recommended Freelancers</h2>
        <p class="muted" style="margin-bottom:0.6rem;">Matched to this project's required skills.</p>
        <?php foreach ($recommended as $r): ?>
          <div class="match-row">
            <?= avatar($r['f']['bg'], $r['f']['hair'], $r['f']['style'], 34) ?>
            <div class="match-row__info">
              <strong><?= e($r['f']['name']) ?></strong>
              <small><?= e(implode(' · ', $r['f']['skills'])) ?></small>
              <div class="match-bar"><span style="width: <?= (int) $r['pct'] ?>%"></span></div>
            </div>
            <span class="match-pct"><?= (int) $r['pct'] ?>%</span>
          </div>
        <?php endforeach; ?>
        <p class="note-line"><?= icon('info', 12) ?> Match % compares each freelancer's skills with the project's required skills.</p>
      </aside>
    </div>

    <?php /* Review popup (shown when the freelancer is assigned) */ ?>
  <?php if ($assigned): ?>
    <div class="modal-overlay" id="review" role="dialog" aria-modal="true" aria-labelledby="review-title">
      <div class="modal">
        <div class="modal__head">
          <h2 id="review-title">Review Freelancer</h2>
          <a href="#" class="modal__close" aria-label="Close"><?= icon('x', 18) ?></a>
        </div>
        <div class="modal__who">
          <?= avatar($assigned['bg'], $assigned['hair'], $assigned['style'], 36) ?>
          <div><strong><?= e($assigned['name']) ?></strong><small><?= e($p['title']) ?></small></div>
        </div>
        <form method="post" action="">
          <p class="field-label" style="margin-top:1rem; font-size:0.78rem; font-weight:600;">Rating</p>
          <div class="star-pick">
            <?php for ($s = 5; $s >= 1; $s--): ?>
              <input type="radio" id="star-<?= $s ?>" name="rating" value="<?= $s ?>" <?= $s === 4 ? 'checked' : '' ?>>
              <label for="star-<?= $s ?>" aria-label="<?= $s ?> stars">★</label>
            <?php endfor; ?>
          </div>
          <div class="field">
            <label for="review-text" style="font-size:0.78rem; font-weight:600;">Review</label>
            <textarea id="review-text" name="review" class="input" rows="4" style="height:auto; padding:0.7rem; font-size:0.8rem;" placeholder="How did the work go?"></textarea>
          </div>
          <p class="hint"><?= icon('info', 13) ?> Available once the work is approved · one review per project.</p>
          <div class="modal__foot">
            <a href="#" class="btn btn--outline">Cancel</a>
            <button type="submit" class="btn btn--primary">Submit Review</button>
          </div>
        </form>
      </div>
    </div>
  <?php endif; ?>

  <?php /* ===================== CONTRACT ===================== */ elseif ($tab === 'contract'): ?>
    <?php if (!$contract_fl): ?>
      <div class="box" style="margin-top:1.25rem;">
        <h2>No freelancer selected yet</h2>
        <p>Choose a freelancer from the proposals first. Then you can send the contract.</p>
        <a href="project-tracking.php?id=<?= (int) $id ?>&amp;tab=proposals" class="btn btn--primary" style="margin-top:0.8rem;">View Proposals</a>
      </div>
    <?php else:
      $cf   = toptunity_freelancer($contract_fl['id']);
      $agreed = $p['budget'];
      $fee    = round($agreed * 0.10);
    ?>
      <div class="two-col">
        <section class="box" style="margin-top:0;">
          <div class="box-head">
            <h2>Contract Terms</h2>
            <span class="muted">Filled in from the project and the proposal</span>
          </div>

          <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.9rem;">
            <div>
              <p class="muted" style="margin-bottom:0.3rem;">Client</p>
              <div class="modal__who" style="margin:0;"><?= avatar('#FFEDD5', '#1E293B', 'long', 30) ?><strong style="font-size:0.8rem;">Andrea Santos</strong></div>
            </div>
            <div>
              <p class="muted" style="margin-bottom:0.3rem;">Freelancer</p>
              <div class="modal__who" style="margin:0;"><?= avatar($cf['bg'], $cf['hair'], $cf['style'], 30) ?><strong style="font-size:0.8rem;"><?= e($cf['name']) ?></strong></div>
            </div>
          </div>

          <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.9rem; margin-top:1rem;">
            <div>
              <p class="muted" style="margin-bottom:0.3rem;">Agreed amount (₱)</p>
              <div class="input" style="display:flex; align-items:center; height:42px;">₱<?= number_format($agreed) ?></div>
            </div>
            <div>
              <p class="muted" style="margin-bottom:0.3rem;">End Date (project deadline)</p>
              <div class="input" style="display:flex; align-items:center; height:42px;"><?= e(date('M d, Y', strtotime($p['deadline']))) ?></div>
            </div>
          </div>

          <div style="margin-top:1rem;">
            <p class="muted" style="margin-bottom:0.3rem;">Project requirements</p>
            <div class="input" style="height:auto; padding:0.8rem; line-height:1.6; font-size:0.8rem;"><?= e($public['intro'] ?? $public['desc']) ?></div>
          </div>

          <div class="terms-box">
            <h3>Payment, revision and dispute rules</h3>
            <ul>
              <li>Fixed Price: the agreed amount is held after you deposit it and released when you approve the work.</li>
              <li>Up to 2 rounds of revisions are included within the project requirements.</li>
              <li>A 10% platform service fee is deducted from the freelancer's payment.</li>
              <li>Either side can file a dispute while the project is ongoing.</li>
              <li>All payments are simulated (no real money is used).</li>
            </ul>
          </div>

          <label class="agree"><input type="checkbox" name="agree" required> I agree to the terms of this contract.</label>

          <div class="modal__foot" style="justify-content:flex-start; margin-top:1rem;">
            <button type="button" class="btn btn--primary"><?= icon('send', 14) ?> Send Contract</button>
            <a href="project-tracking.php?id=<?= (int) $id ?>&amp;tab=proposals" class="btn btn--outline">Cancel</a>
          </div>
        </section>

        <aside class="stack">
          <section class="box">
            <h2>Contract Status</h2>
            <div class="kv"><span>Status</span><span class="status status--pending">Pending · not sent</span></div>
            <p class="note-line">Once active, the contract terms are locked. Later changes are added to the contract history.</p>
          </section>
          <section class="box">
            <h2>Summary</h2>
            <div class="kv"><span>Agreed amount</span><strong>₱<?= number_format($agreed) ?></strong></div>
            <div class="kv"><span>Platform service fee (10%)</span><strong style="color:var(--color-error-base);">– ₱<?= number_format($fee) ?></strong></div>
            <div class="kv"><span>Freelancer receives</span><strong style="color:var(--color-teal-dark);">₱<?= number_format($agreed - $fee) ?></strong></div>
          </section>
          <section class="box">
            <h2>Questions about the terms?</h2>
            <p class="muted">Talk to the freelancer before sending.</p>
            <a href="messages.php" class="btn btn--row-outline" style="margin-top:0.7rem; width:100%;"><?= icon('message', 13) ?> Message Freelancer</a>
          </section>
        </aside>
      </div>
    <?php endif; ?>

  <?php /* ===================== TRACKING ===================== */ elseif ($tab === 'tracking'): ?>
    <?php if (!$tracking): ?>
      <div class="box" style="margin-top:1.25rem;">
        <h2>Tracking has not started</h2>
        <p>Project tracking begins once a freelancer accepts the contract and the work starts.</p>
      </div>
    <?php else:
      $tf = $assigned ?: $contract_fl;
      $tfd = $tf ? toptunity_freelancer($tf['id'] ?? 0) : null;
      $hours_approved = 0; $hours_pending = 0; $hours_total = 0;
      foreach ($tracking['worklog'] as $w) {
        if ($w['status'] === 'approved') { $hours_approved += $w['hours']; }
        if ($w['status'] === 'pending')  { $hours_pending += $w['hours']; }
      }
      $hours_total = $hours_approved + $hours_pending;
      $elapsed = (strtotime('2026-10-08') - strtotime($tracking['start'])) / 86400;
      $total_span = max(1, (strtotime($p['deadline']) - strtotime($tracking['start'])) / 86400);
      $progress = min(100, (int) round($elapsed / $total_span * 100));
    ?>
      <!-- Current status -->
      <section class="box" style="margin-top:1.25rem;">
        <div class="status-banner">Current Status: <strong>Project Started</strong>
          <span style="margin-left:auto; font-size:0.74rem;">Freelancer · <?= $tfd ? e($tfd['name']) : '—' ?></span>
        </div>
        <ol class="tracking-steps">
          <?php foreach ($steps as $i => $label):
            $n = $i + 1;
            $cls = $n < $tracking['current_step'] ? 'is-done' : ($n === $tracking['current_step'] ? 'is-current' : '');
          ?>
            <li class="<?= $cls ?>">
              <span class="dot"><?= $n < $tracking['current_step'] ? icon('check', 12) : $n ?></span>
              <small><?= e($label) ?></small>
            </li>
          <?php endforeach; ?>
        </ol>
      </section>

      <div class="two-col">
        <div class="stack">
          <!-- Work log -->
          <section class="box">
            <div class="box-head">
              <h2>Work Log</h2>
              <span class="status status--pending">Hourly project</span>
            </div>
            <div style="overflow-x:auto;">
              <table class="data-table">
                <thead><tr><th>Date</th><th class="num">Hours</th><th>Task</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                  <?php foreach ($tracking['worklog'] as $w): ?>
                    <tr>
                      <td><?= e(date('M d, Y', strtotime($w['date']))) ?></td>
                      <td class="num"><?= number_format($w['hours'], 1) ?></td>
                      <td><?= e($w['task']) ?></td>
                      <td><span class="status status--<?= $w['status'] === 'approved' ? 'released' : ($w['status'] === 'pending' ? 'pending' : 'past') ?>"><?= e(ucfirst($w['status'])) ?></span></td>
                      <td>
                        <?php if ($w['status'] === 'pending'): ?>
                          <div class="approve-btns">
                            <a href="#" class="btn btn--approve">Approve Hours</a>
                            <a href="#" class="btn btn--reject">Reject Hours</a>
                          </div>
                        <?php else: ?>—<?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <div class="hours-foot">
              <span>Approved <strong><?= number_format($hours_approved, 1) ?> h</strong></span>
              <span>Pending <strong><?= number_format($hours_pending, 1) ?> h</strong></span>
              <span>Maximum Hours <strong><?= (int) $tracking['max_hours'] ?> h</strong></span>
              <span>To be billed <strong>₱<?= number_format($hours_approved * ($p['rate'] ?? 0)) ?></strong></span>
            </div>
            <p class="note-line">Billed on the End Date: approved hours × hourly rate (minus 10% service fee) goes to the freelancer. The unused deposit is refunded. Hours not reviewed by the End Date count as approved.</p>
          </section>

          <!-- Submitted work -->
          <section class="box">
            <h2>Submitted Work</h2>
            <p><?= e($tracking['message']) ?></p>
            <div class="file-list">
              <?php foreach ($tracking['files'] as $f): ?>
                <div class="file-row"><?= icon('file', 15) ?><span><?= e($f['name']) ?></span><span class="file-row__size"><?= e($f['size']) ?></span></div>
              <?php endforeach; ?>
            </div>
            <div style="display:flex; gap:0.5rem; margin-top:0.9rem; flex-wrap:wrap;">
              <a href="#" class="btn btn--approve" style="padding:0.5rem 1rem;"><?= icon('check', 13) ?> Approve</a>
              <a href="#" class="btn btn--row-outline"><?= icon('refresh', 13) ?> Request Revision</a>
            </div>
          </section>

          <!-- Status history -->
          <section class="box">
            <h2>Status History</h2>
            <div style="overflow-x:auto;">
              <table class="data-table">
                <thead><tr><th>Date</th><th>Status</th><th>By</th></tr></thead>
                <tbody>
                  <?php foreach ($tracking['history'] as $h): ?>
                    <tr>
                      <td><?= e(date('M d, Y g:i A', strtotime($h['date']))) ?></td>
                      <td><?= e($h['status']) ?></td>
                      <td><span class="pill pill--cat" style="background:var(--color-chip-bg); color:var(--color-slate-text);"><?= e($h['by']) ?></span></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </section>
        </div>

        <aside class="stack">
          <section class="box">
            <h2>Project Dates</h2>
            <div class="kv"><span>Start Date</span><strong><?= e(date('M d, Y', strtotime($tracking['start']))) ?></strong></div>
            <div class="kv"><span>End Date</span><strong><?= e(date('M d, Y', strtotime($p['deadline']))) ?></strong></div>
            <div class="kv"><span>Days left</span><strong style="color:var(--color-vibrant-teal);"><?= $days_left ?> days</strong></div>
            <div style="height:6px; margin-top:0.7rem; background:var(--color-chip-bg); border-radius:3px; overflow:hidden;">
              <span style="display:block; height:100%; width:<?= $progress ?>%; background:var(--color-vibrant-teal);"></span>
            </div>
            <p class="note-line">Start Date = day the freelancer accepted the contract. End Date = project deadline.</p>
          </section>

          <section class="box">
            <h2>Deposit Project Amount</h2>
            <div class="kv"><span>Status</span><span class="status status--held">Held</span></div>
            <div class="kv"><span>Amount</span><strong>₱<?= number_format($tracking['deposit']) ?></strong></div>
            <a href="billing.php" class="btn btn--row-outline" style="margin-top:0.7rem; width:100%;">View in Billing and Payments</a>
          </section>

          <section class="box">
            <h2>Contract</h2>
            <div class="kv"><span>Status</span><span class="status status--open">Active</span></div>
            <div class="kv"><span>Agreed</span><strong><?= e(date('M d, Y', strtotime($tracking['start']))) ?></strong></div>
            <a href="project-tracking.php?id=<?= (int) $id ?>&amp;tab=contract<?= $tf ? '&amp;freelancer=' . (int) $tf['id'] : '' ?>" class="btn btn--row-outline" style="margin-top:0.7rem; width:100%;">View Contract →</a>
          </section>

          <section class="box">
            <h2>Need more time?</h2>
            <p class="muted">Hourly: extend the deadline before the End Date to continue the work. Fixed Price overdue projects can also accept late work.</p>
            <div style="display:flex; flex-direction:column; gap:0.5rem; margin-top:0.7rem;">
              <a href="#" class="btn btn--row-outline" style="width:100%;">Extend Deadline</a>
              <a href="#" class="btn btn--row-outline" style="width:100%; color:var(--color-muted-gray);">Accept Late Work</a>
            </div>
          </section>

          <section class="warn-box">
            <h3>Having a problem?</h3>
            <p>You can file a dispute on any ongoing project, including an overdue one.</p>
            <a href="report-dispute.php?id=<?= (int) $id ?>" class="btn btn--danger-outline" style="width:100%; margin-top:0.6rem;"><?= icon('flag', 13) ?> File a Dispute</a>
          </section>
        </aside>
      </div>
    <?php endif; ?>
  <?php endif; ?>

<?php endif; ?>

</main>

<?php include '../includes/footer.php'; ?>