<?php
/**
 * client/project-tracking.php - Project details for the client.
 * Tabs: ?tab=overview|proposals|contract|tracking
 * Popups use CSS :target, so links like #select-freelancer-1 open them without JavaScript.
 */
$user_role     = "client";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "projects";

require_once __DIR__ . '/../includes/data.php';

$projects = toptunity_client_projects();
$id       = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$p        = isset($projects[$id]) ? $projects[$id] : null;
$public   = $p ? toptunity_client_detail($id) : null;
$db_mode = $p && $id >= 1000;
$dbprops = $db_mode ? tt_db_proposals($id) : [];
$db_row  = $db_mode ? tt_db_project($id) : null;
$proposal_count = $db_mode ? count($dbprops) : count(toptunity_project_proposals($id));
$sample_state = null;
if (!$db_mode && $p) {
    $sample_state = tt_sample_state($id);
    $db_row = [
        'client_id' => 0, 'budget' => (int) ($p['budget'] ?? 0), 'billing_type' => $p['type'] ?? 'fixed',
        'hourly_rate' => (int) ($p['rate'] ?? 0), 'max_hours' => (int) ($p['max_hours'] ?? 0), 'deadline' => $p['deadline'],
        'freelancer_id' => $sample_state['freelancer_id'], 'contract_status' => $sample_state['contract_status'],
        'agreed_amount' => (int) $sample_state['agreed'], 'contract_sent_at' => $sample_state['sent_at'],
    ];
    if ($sample_state['freelancer_id']) {
        $sf = toptunity_freelancer((int) $sample_state['freelancer_id']);
        if ($sf) { $p['freelancer'] = $sf['name']; }
    }
}

if ($p && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $act = $_POST['action'] ?? '';
    if ($db_mode && in_array($act, ['approve_hours', 'reject_hours'], true)) {
        $err = tt_db_review_work_log($id, (int) ($_POST['work_log'] ?? 0),
                                    $act === 'approve_hours' ? 'approved' : 'rejected',
                                    $_POST['reason'] ?? '');
        tt_flash($err ? 'Could not review hours: ' . $err : ($act === 'approve_hours' ? 'Hours approved.' : 'Hours rejected.'));
        header('Location: ' . $base_url . 'client/project-tracking.php?id=' . $id . '&tab=tracking');
        exit;
    }
    if ($db_mode && in_array($act, ['approve_work', 'request_revision', 'extend_deadline', 'accept_late_work'], true)) {
        if ($act === 'approve_work') {
            $err = tt_db_review_submission($id, 'approved');
        } elseif ($act === 'request_revision') {
            $err = tt_db_review_submission($id, 'revision', (string) ($_POST['reason'] ?? ''));
        } elseif ($act === 'extend_deadline') {
            $err = tt_db_extend_deadline($id, (string) ($_POST['deadline'] ?? ''));
        } else {
            $err = tt_db_allow_late_work($id);
        }
        $success = ['approve_work' => ($p['type'] === 'hourly' ? 'Work approved.' : 'Work approved and payment released.'),
                    'request_revision' => 'Revision requested.',
                    'extend_deadline' => 'Project deadline extended.',
                    'accept_late_work' => 'Late work is now allowed.'][$act];
        tt_flash($err ? 'Could not update project: ' . $err : $success);
        header('Location: ' . $base_url . 'client/project-tracking.php?id=' . $id . '&tab=tracking');
        exit;
    }
    if ($act === 'send' && empty($_POST['agree'])) {
        header('Location: ' . $base_url . 'client/project-tracking.php?id=' . $id . '&tab=contract');
        exit;
    }
    $err = null; $ok = null;
    if (!$db_mode) {
        // Sample project: the choice is stored as sample state
        if ($act === 'select') {
            $fid = (int) ($_POST['proposal'] ?? 0); $offer = 0;
            foreach (toptunity_project_proposals($id) as $x) { if ((int) $x['freelancer_id'] === $fid) { $offer = (int) $x['offer']; } }
            if (!$fid || !$offer) { $err = 'That proposal was not found.'; }
            elseif ($sample_state['contract_status'] !== 'none') { $err = 'A contract is already in progress for this project.'; }
            else { tt_save_sample_state($id, ['freelancer_id' => $fid, 'contract_status' => 'none', 'agreed' => $offer, 'sent_at' => null]); $ok = 'Freelancer selected. Now send the contract.'; }
        } elseif ($act === 'send') {
            if (!$sample_state['freelancer_id'])               { $err = 'Select a freelancer before sending the contract.'; }
            elseif ($sample_state['contract_status'] !== 'none') { $err = 'The contract has already been sent.'; }
            elseif ((int) ($_POST['agreed'] ?? 0) < 1)        { $err = 'Enter the agreed amount.'; }
            else { tt_save_sample_state($id, ['freelancer_id' => $sample_state['freelancer_id'], 'contract_status' => 'pending',
                                              'agreed' => (int) $_POST['agreed'], 'sent_at' => date('Y-m-d')]); $ok = 'Contract sent. The freelancer must accept it before the project starts.'; }
        }
    } else {
        if ($act === 'select') {
            $err = tt_db_select_freelancer($id, (int) ($_POST['proposal'] ?? 0));
            $ok  = 'Freelancer selected. Now send the contract.';
        } elseif ($act === 'send') {
            $err = tt_db_send_contract($id, (int) ($_POST['agreed'] ?? 0));
            $ok = 'Contract sent. The freelancer must accept it before the project starts.';
        }
    }
    tt_flash($err ? 'Could not continue: ' . $err : $ok);
    header('Location: ' . $base_url . 'client/project-tracking.php?id=' . $id . '&tab=contract');
    exit;
}

$tabs = ['overview' => 'Overview', 'proposals' => 'Proposals and Recommended Freelancers', 'contract' => 'Contract', 'tracking' => 'Project Tracking'];
$tab  = isset($_GET['tab']) && isset($tabs[$_GET['tab']]) ? $_GET['tab'] : 'overview';

$freelancers = toptunity_freelancers();
$proposals   = toptunity_project_proposals($id);
$tracking    = toptunity_project_tracking($id);
if ($db_mode && $tracking) {
    $tracking['worklog'] = tt_project_work_logs($id);
    $tracking['hours_approved'] = array_sum(array_map(function ($entry) {
        return $entry['status'] === 'approved' ? (float) $entry['hours'] : 0;
    }, $tracking['worklog']));
    $tracking['hours_pending'] = array_sum(array_map(function ($entry) {
        return $entry['status'] === 'pending' ? (float) $entry['hours'] : 0;
    }, $tracking['worklog']));
}
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
      <h1><?= e($p['title']) ?></h1>
      <div style="display:flex; align-items:center; gap:0.5rem; flex-wrap:wrap; margin:0.5rem 0 0.2rem;">
        <span class="status status--<?= e($p['status']) ?>"><?= e(!empty($db_row['freelancer_id']) && ($db_row['contract_status'] ?? 'none') === 'none' && $p['status'] === 'open' ? 'Freelancer Selected' : toptunity_status_label($p['status'])) ?></span>
        <span class="status" style="background:var(--color-chip-bg); color:var(--color-slate-text);"><?= $p['type'] === 'hourly' ? 'Hourly' : 'Fixed Price' ?></span>
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
        <?php if ($key === 'proposals'): ?><span class="count"><?= (int) $proposal_count ?></span><?php endif; ?>
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
              <div class="file-row"><?= icon('file', 15) ?><?= tt_file_name_html($f, $base_url) ?><span class="file-row__size"><?= e($f['size']) ?></span></div>
            <?php endforeach; ?>
          </div>
        </section>
        <?php endif; ?>
      </div>
    </div>

  <?php /* ===================== PROPOSALS ===================== */ elseif ($tab === 'proposals'): ?>
    <?php
      // One list for both kinds of project
      $props = [];
      if ($db_mode) {
          foreach ($dbprops as $pr) {
              $fsk = db()->prepare('SELECT s.name FROM freelancer_skills fs JOIN skills s ON s.id = fs.skill_id WHERE fs.freelancer_id = ? ORDER BY s.name');
              $fsk->execute([(int) $pr['freelancer_id']]);
              $fprof = db()->prepare('SELECT title, location FROM freelancer_profiles WHERE user_id = ?');
              $fprof->execute([(int) $pr['freelancer_id']]);
              $fp = $fprof->fetch() ?: [];
              $props[] = ['key' => (int) $pr['id'], 'fid' => (int) $pr['freelancer_id'], 'name' => $pr['freelancer_name'], 'real' => true,
                          'title' => !empty($fp['title']) ? $fp['title'] : 'Freelancer', 'location' => $fp['location'] ?? '', 'rating' => null, 'reviews' => 0,
                          'skills' => array_column($fsk->fetchAll(), 'name'),
                          'offer' => (int) $pr['offer'], 'days' => (int) $pr['days'], 'letter' => $pr['cover_letter'],
                          'status' => $pr['status'], 'sample' => false, 'bg' => '#CCFBF1', 'hair' => '#1E293B', 'style' => 'short'];
          }
      } else {
          foreach (toptunity_project_proposals($id) as $sp) {
              $sf = toptunity_freelancer((int) $sp['freelancer_id']); if (!$sf) { continue; }
              $props[] = ['key' => (int) $sp['freelancer_id'], 'fid' => (int) $sp['freelancer_id'], 'name' => $sf['name'],
                          'title' => $sf['title'], 'location' => $sf['location'], 'rating' => $sf['rating'], 'reviews' => $sf['reviews'],
                          'skills' => $sf['skills'], 'offer' => (int) $sp['offer'], 'days' => (int) $sp['days'], 'letter' => $sp['letter'],
                          'status' => 'pending', 'sample' => true, 'bg' => $sf['bg'], 'hair' => $sf['hair'], 'style' => $sf['style']];
          }
      }
      $sort = $_GET['sort'] ?? 'newest';
      if ($sort === 'price_low')  { usort($props, function ($a, $b) { return $a['offer'] <=> $b['offer']; }); }
      if ($sort === 'price_high') { usort($props, function ($a, $b) { return $b['offer'] <=> $a['offer']; }); }
      if ($sort === 'rating')     { usort($props, function ($a, $b) { return ($b['rating'] ?? 0) <=> ($a['rating'] ?? 0); }); }

      // Recommended freelancers: match against the project's required skills
      $req = $required ?: ($p['skills'] ?? []);
      $recommended = [];
      foreach (toptunity_freelancers() as $rfid => $rf) {
          $recommended[] = ['id' => $rfid, 'name' => $rf['name'], 'skills' => $rf['skills'], 'match' => tt_skill_match($req, $rf['skills'])];
      }
      usort($recommended, function ($a, $b) { return $b['match'] <=> $a['match']; });
      $recommended = array_slice($recommended, 0, 4);
    ?>
    <div class="two-col" style="grid-template-columns: 1fr 300px;">
      <div>
        <div style="display:flex; align-items:center; justify-content:space-between; margin-top:1.25rem; margin-bottom:0.8rem; gap:1rem;">
          <h2 style="font-size:0.95rem; font-weight:700;">Proposals (<?= (int) count($props) ?>)</h2>
          <form method="get" action="project-tracking.php" class="sort-select" style="font-size:0.78rem;">
            <input type="hidden" name="id" value="<?= (int) $id ?>"><input type="hidden" name="tab" value="proposals">
            <span class="muted">Sort by:</span>
            <select name="sort" onchange="this.form.submit()" style="border:1px solid var(--color-border-gray); border-radius:8px; padding:0.35rem 0.6rem; font-family:inherit;">
              <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest</option>
              <option value="price_low" <?= $sort === 'price_low' ? 'selected' : '' ?>>Price: low to high</option>
              <option value="price_high" <?= $sort === 'price_high' ? 'selected' : '' ?>>Price: high to low</option>
              <option value="rating" <?= $sort === 'rating' ? 'selected' : '' ?>>Top rated</option>
            </select>
          </form>
        </div>

        <?php if (!$db_mode): ?>
        <?php endif; ?>

        <?php if (!$props): ?>
          <div class="empty-state empty-state--design">
            <div class="empty-art"><?= icon('clipboard', 40) ?></div>
            <h3>No proposals yet</h3>
            <p>Freelancers will send proposals here once they find your project.</p>
          </div>
        <?php endif; ?>

        <?php foreach ($props as $pr):
          $is_selected = $p['freelancer'] && $pr['name'] === $p['freelancer'] && $db_row['contract_status'] !== 'none';
          $can_select  = $db_row['status'] === 'open' && $db_row['contract_status'] === 'none'
              && empty($db_row['freelancer_id']) && in_array($pr['status'], ['pending', 'not_selected'], true);
        ?>
          <article class="proposal-card">
            <div class="proposal-top">
              <div class="proposal-who">
                <?= avatar($pr['bg'], $pr['hair'], $pr['style'], 44) ?>
                <div>
                  <strong><?= e($pr['name']) ?>
                    <?php if ($pr['rating'] !== null): ?>
                      <span style="margin-left:0.4rem; font-size:0.72rem;"><?= stars($pr['rating']) ?> <span class="muted"><?= e(number_format($pr['rating'], 1)) ?> (<?= (int) $pr['reviews'] ?>)</span></span>
                    <?php endif; ?>
                  </strong>
                  <small><?= e($pr['title']) ?><?= $pr['location'] ? ' · ' . e($pr['location']) : '' ?></small>
                </div>
              </div>
              <div class="proposal-price">
                <strong>₱<?= number_format($pr['offer']) ?><?= $db_row['billing_type'] === 'hourly' ? '/hr' : '' ?></strong>
                <small>Est. <?= (int) $pr['days'] ?> days</small>
              </div>
            </div>

            <p><?= e($pr['letter']) ?></p>

            <?php if ($pr['skills']): ?>
              <div class="chips" style="margin-bottom:0.8rem;">
                <?php foreach (array_slice($pr['skills'], 0, 4) as $sk): ?><span class="chip"><?= e($sk) ?></span><?php endforeach; ?>
              </div>
            <?php endif; ?>

            <div class="proposal-foot">
              <div class="proposal-actions">
                <a href="freelancer-profile.php?id=<?= (int) ($pr['sample'] ? $pr['fid'] : 5000 + $pr['fid']) ?>" class="btn btn--row-outline btn--small">View Freelancer Profile</a>
                <a href="<?= $pr['sample'] ? 'messages.php' : 'messages.php?with=' . (int) $pr['fid'] ?>" class="btn btn--row-outline btn--small"><?= icon('message', 13) ?> Message Freelancer</a>
              </div>
              <?php if ($is_selected): ?>
                <span class="status status--released">Selected</span>
              <?php elseif ($can_select): ?>
                <a href="#select-<?= (int) $pr['key'] ?>" class="btn btn--select"><?= icon('user', 13) ?> Select Freelancer</a>
              <?php endif; ?>
            </div>
          </article>
          <?php if ($can_select && !$is_selected): $sel_match = tt_skill_match($req, $pr['skills']); $others = max(0, count($props) - 1); ?>
          <div class="modal-overlay" id="select-<?= (int) $pr['key'] ?>" role="dialog" aria-modal="true" aria-labelledby="select-title-<?= (int) $pr['key'] ?>">
            <div class="modal" style="width:520px;">
              <div class="modal__head">
                <h2 id="select-title-<?= (int) $pr['key'] ?>">Select this freelancer?</h2>
                <a href="#" class="modal__close" aria-label="Close"><?= icon('x', 18) ?></a>
              </div>
              <div class="modal__who">
                <?= avatar($pr['bg'], $pr['hair'], $pr['style'], 40) ?>
                <div style="flex:1;">
                  <strong><?= e($pr['name']) ?></strong>
                  <small>Offer ₱<?= number_format($pr['offer']) ?> · <?= (int) $pr['days'] ?> days</small>
                </div>
                <span class="status status--open" style="white-space:nowrap;"><?= icon('zap', 12) ?> <?= (int) $sel_match ?>% match</span>
              </div>
              <div style="margin-top:0.9rem; padding:0.8rem 0.95rem; background:#FEF9C3; border:1px solid #FDE68A; border-radius:10px; font-size:0.78rem; color:#78350F;">
                <p style="font-weight:700; margin:0 0 0.4rem;"><?= icon('alert', 13) ?> Before you continue</p>
                <ul style="margin:0; padding-left:1.1rem; line-height:1.6;">
                  <li>Only one freelancer can be selected.</li>
                  <li>The project stops accepting proposals.</li>
                  <?php if ($others > 0): ?><li>The other <?= (int) $others ?> <?= $others === 1 ? 'proposal is' : 'proposals are' ?> marked as Not Selected.</li><?php endif; ?>
                  <li>Next, you send the Contract. The freelancer must accept it.</li>
                  <li>If the freelancer declines, the project reopens.</li>
                </ul>
              </div>
              <div class="modal__foot">
                <a href="#" class="btn btn--row-outline">Cancel</a>
                <form method="post" action="project-tracking.php?id=<?= (int) $id ?>&amp;tab=proposals" style="display:inline;">
                  <input type="hidden" name="action" value="select">
                  <input type="hidden" name="proposal" value="<?= (int) $pr['key'] ?>">
                  <button type="submit" class="btn btn--select">Select Freelancer → Contract</button>
                </form>
              </div>
            </div>
          </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>

      <aside class="recommend-band" style="margin-top:1.25rem; align-self:start;">
        <div class="recommend-band__head"><h2><?= icon('zap', 15) ?> Recommended Freelancers</h2></div>
        <p class="muted" style="font-size:0.72rem; margin-bottom:0.8rem;">Matched to this project's required skills: <?= e(implode(', ', $req)) ?>.</p>
        <?php foreach ($recommended as $rc): ?>
          <div style="margin-bottom:0.9rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:0.5rem;">
              <div><strong style="font-size:0.8rem;"><?= e($rc['name']) ?></strong><small style="display:block; color:var(--color-muted-gray); font-size:0.66rem;"><?= e(implode(' · ', array_slice($rc['skills'], 0, 3))) ?></small></div>
              <span class="match-pct" style="color:<?= $rc['match'] >= 80 ? 'var(--color-vibrant-teal)' : ($rc['match'] >= 60 ? 'var(--color-coral-orange)' : 'var(--color-muted-gray)') ?>;"><?= (int) $rc['match'] ?>%</span>
            </div>
            <div class="match-bar"><span style="width:<?= (int) $rc['match'] ?>%; background:<?= $rc['match'] >= 80 ? 'var(--color-vibrant-teal)' : ($rc['match'] >= 60 ? 'var(--color-coral-orange)' : 'var(--color-muted-gray)') ?>;"></span></div>
          </div>
        <?php endforeach; ?>
        <p class="note-line">Match % compares each freelancer's skills with the project's required skills.</p>
      </aside>
    </div>

  <?php /* ===================== CONTRACT ===================== */ elseif ($tab === 'contract'): ?>
    <?php if (empty($db_row['freelancer_id'])): ?>
      <div class="box" style="margin-top:1.25rem;">
        <h2>No freelancer selected yet</h2>
        <p>Choose a freelancer from the proposals first. Then you can send the contract.</p>
        <a href="project-tracking.php?id=<?= (int) $id ?>&amp;tab=proposals" class="btn btn--primary" style="margin-top:0.8rem;">View Proposals</a>
      </div>
    <?php else:
      $cs     = $db_row['contract_status'];
      $step   = $cs === 'active' ? 2 : ($cs === 'completed' ? 3 : 1);
      $label  = ['none' => 'Pending · not sent', 'pending' => 'Pending · awaiting freelancer', 'active' => 'Active', 'declined' => 'Declined', 'completed' => 'Completed'][$cs] ?? 'Pending';
      $agreed = $db_row['contract_status'] === 'none' ? (int) $db_row['budget'] : (int) $db_row['agreed_amount'];
      if ($db_row['billing_type'] === 'hourly') { $agreed = (int) $db_row['hourly_rate'] * (int) $db_row['max_hours']; }
      $fee = round($agreed * 0.10);
    ?>
      <div class="two-col">
        <section class="box" style="margin-top:0;">
          <div class="box-head"><h2>Contract Terms</h2><span class="muted">Filled in from the project and the proposal</span></div>
          <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.9rem;">
            <div><p class="muted" style="margin-bottom:0.3rem;">Client</p><div class="modal__who" style="margin:0;"><?= avatar('#FFEDD5', '#1E293B', 'long', 30) ?><strong style="font-size:0.8rem;">You</strong></div></div>
            <div><p class="muted" style="margin-bottom:0.3rem;">Freelancer</p><div class="modal__who" style="margin:0;"><?= avatar('#CCFBF1', '#1E293B', 'short', 30) ?><strong style="font-size:0.8rem;"><?= e($p['freelancer']) ?></strong></div></div>
          </div>

          <?php if ($cs === 'none'): ?>
          <form method="post" action="project-tracking.php?id=<?= (int) $id ?>&amp;tab=contract" data-requires-checkbox="agree" style="margin-top:1rem;">
            <input type="hidden" name="action" value="send">
            <div class="field" style="margin-top:0;">
              <label for="agreed">Agreed amount (₱)</label>
              <div class="input-prefix"><span>₱</span><input class="input" id="agreed" name="agreed" type="number" min="1" value="<?= (int) $agreed ?>" required></div>
            </div>
            <div class="field">
              <label>End Date (project deadline)</label>
              <div class="input" style="display:flex; align-items:center;"><?= e(date('M d, Y', strtotime($db_row['deadline']))) ?></div>
            </div>
            <div class="field">
              <label>Start Date</label>
              <div class="input" style="display:flex; align-items:center; color:var(--color-muted-gray);">Set when the freelancer accepts</div>
            </div>
            <div class="field">
              <label>Project Requirements</label>
              <div class="input" style="white-space:pre-line; min-height:4.5rem; height:auto; padding:0.7rem 0.8rem;"><?= e($db_row['description']) ?></div>
            </div>
            <div class="terms-box">
              <h3>Payment, revision and dispute rules</h3>
              <ul>
                <li>Fixed Price: the agreed amount is held after you deposit it and released when you approve the work.</li>
                <li>A 10% platform service fee is deducted from the freelancer's payment.</li>
                <li>Either side can file a dispute while the project is ongoing.</li>
                <li>All payments are simulated (no real money is used).</li>
              </ul>
            </div>
            <label class="agree"><input type="checkbox" name="agree" value="1"> I agree to the terms of this contract.</label>
            <div class="modal__foot" style="justify-content:flex-start; margin-top:1rem;">
              <button type="submit" class="btn btn--primary" disabled><?= icon('send', 14) ?> Send Contract</button>
              <a href="project-tracking.php?id=<?= (int) $id ?>&amp;tab=proposals" class="btn btn--row-outline">Cancel</a>
            </div>
          </form>
          <?php else: ?>
            <div class="kv" style="margin-top:1rem;"><span>Agreed amount</span><strong>₱<?= number_format($agreed) ?></strong></div>
            <div class="kv"><span>End Date</span><strong><?= e(date('M d, Y', strtotime($db_row['deadline']))) ?></strong></div>
            <p class="note-line" style="margin-top:0.8rem;">The contract was sent on <?= e(date('M d, Y', strtotime($db_row['contract_sent_at'] ?? 'now'))) ?>. Its terms are locked.</p>
          <?php endif; ?>
        </section>

        <aside class="stack">
          <section class="box">
            <h2>Contract Status</h2>
            <ol class="progress-steps" style="margin:0.6rem 0 1rem; list-style:none; padding:0;">
              <li class="<?= $step === 1 ? 'is-current' : 'is-done' ?>"><span class="step-dot"><?= $step > 1 ? icon('check', 12) : '1' ?></span><small>Pending</small></li>
              <li class="<?= $step === 2 ? 'is-current' : ($step > 2 ? 'is-done' : '') ?>"><span class="step-dot">2</span><small>Active</small></li>
              <li class="<?= $step === 3 ? 'is-current' : '' ?>"><span class="step-dot">3</span><small>Completed</small></li>
            </ol>
            <div class="kv"><span>Status</span><span class="status status--<?= $cs === 'active' ? 'released' : 'pending' ?>"><?= e($label) ?></span></div>
          </section>
          <section class="box">
            <h2>Summary</h2>
            <div class="kv"><span>Agreed amount</span><strong>₱<?= number_format($agreed) ?></strong></div>
            <div class="kv"><span>Platform service fee (10%)</span><strong style="color:var(--color-error-base);">– ₱<?= number_format($fee) ?></strong></div>
            <div class="kv"><span>Freelancer receives</span><strong style="color:var(--color-teal-dark);">₱<?= number_format($agreed - $fee) ?></strong></div>
          </section>
          <section class="box">
            <h2>Questions about the terms?</h2>
            <p class="muted" style="font-size:0.78rem; margin:0.4rem 0 0.8rem;">Talk to the freelancer before sending.</p>
            <a href="messages.php?with=<?= (int) $db_row['freelancer_id'] ?>" class="btn btn--row-outline" style="width:100%; justify-content:center;"><?= icon('message', 13) ?> Message Freelancer</a>
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
                        <?php if ($w['status'] === 'pending' && $db_mode && isset($w['id'])): ?>
                          <div class="approve-btns">
                            <form method="post" action="project-tracking.php?id=<?= (int) $id ?>&amp;tab=tracking" class="approve-btns">
                              <input type="hidden" name="action" value="approve_hours">
                              <input type="hidden" name="work_log" value="<?= (int) $w['id'] ?>">
                              <button type="submit" class="btn btn--approve">Approve Hours</button>
                            </form>
                            <form method="post" action="project-tracking.php?id=<?= (int) $id ?>&amp;tab=tracking" class="approve-btns">
                              <input type="hidden" name="action" value="reject_hours">
                              <input type="hidden" name="work_log" value="<?= (int) $w['id'] ?>">
                              <input class="input" type="text" name="reason" minlength="10" placeholder="Reason (10+ chars)" required>
                              <button type="submit" class="btn btn--reject">Reject Hours</button>
                            </form>
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
                <div class="file-row"><?= icon('file', 15) ?><?= tt_file_name_html($f, $base_url) ?><span class="file-row__size"><?= e($f['size']) ?></span></div>
              <?php endforeach; ?>
            </div>
            <?php if ($db_mode && $tracking['submission_status'] === 'pending'): ?>
              <div style="display:flex; gap:0.5rem; margin-top:0.9rem; flex-wrap:wrap; align-items:end;">
                <form method="post" action="project-tracking.php?id=<?= (int) $id ?>&amp;tab=tracking">
                  <input type="hidden" name="action" value="approve_work">
                  <button type="submit" class="btn btn--approve" style="padding:0.5rem 1rem;"><?= icon('check', 13) ?> Approve Work</button>
                </form>
                <form method="post" action="project-tracking.php?id=<?= (int) $id ?>&amp;tab=tracking" style="display:flex; gap:0.4rem; align-items:center;">
                  <input type="hidden" name="action" value="request_revision">
                  <input class="input" name="reason" minlength="10" placeholder="Revision details (10+ chars)" required>
                  <button type="submit" class="btn btn--row-outline"><?= icon('refresh', 13) ?> Request Revision</button>
                </form>
              </div>
              <?php if (!empty($tracking['submission_review_note'])): ?><p class="note-line"><?= e($tracking['submission_review_note']) ?></p><?php endif; ?>
            <?php elseif ($db_mode && $tracking['submission_status'] === 'revision'): ?>
              <p class="note-line" style="margin-top:0.9rem;">Revision requested: <?= e($tracking['submission_review_note']) ?></p>
            <?php elseif ($db_mode && $tracking['submission_status'] === 'approved'): ?>
              <p class="note-line" style="margin-top:0.9rem;">Work approved and payment released.</p>
            <?php elseif (!$db_mode): ?>
              <p class="note-line" style="margin-top:0.9rem;">Sample project preview; live projects support work review actions.</p>
            <?php endif; ?>
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
              <?php if ($db_mode && in_array($p['status'], ['ongoing', 'overdue'], true)): ?>
                <form method="post" action="project-tracking.php?id=<?= (int) $id ?>&amp;tab=tracking">
                  <input type="hidden" name="action" value="extend_deadline">
                  <label class="field" style="margin:0;"><span class="muted">New end date</span><input class="input" type="date" name="deadline" min="<?= e(date('Y-m-d', strtotime($p['deadline'] . ' +1 day'))) ?>" required></label>
                  <button type="submit" class="btn btn--row-outline" style="width:100%; margin-top:0.4rem;">Extend Deadline</button>
                </form>
                <?php if ($p['status'] === 'overdue' || $p['deadline'] < date('Y-m-d')): ?>
                  <form method="post" action="project-tracking.php?id=<?= (int) $id ?>&amp;tab=tracking">
                    <input type="hidden" name="action" value="accept_late_work">
                    <button type="submit" class="btn btn--row-outline" style="width:100%; color:var(--color-muted-gray);">Accept Late Work</button>
                  </form>
                <?php endif; ?>
              <?php else: ?>
                <p class="note-line">Deadline actions are available for active database projects.</p>
              <?php endif; ?>
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