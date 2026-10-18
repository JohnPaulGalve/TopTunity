<?php
/**
 * admin/user-management.php - Client and freelancer lists with user details (matches the User Management design).
 * User status changes are saved for live accounts and isolated per demo-admin session.
 */
$user_role     = "admin";
$base_url      = (rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/') . '/');
$active_client = "users";

require_once __DIR__ . '/../includes/data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $act = (string) ($_POST['action'] ?? '');
    $id = (int) ($_POST['user_id'] ?? 0);
    $error = tt_admin_change_user_status($id, $act);
    tt_flash($error ? 'Could not update user: ' . $error : 'User status updated.');
    $query = http_build_query(array_filter([
        'tab' => $_GET['tab'] ?? '',
        'id' => $id ?: '',
        'q' => $_GET['q'] ?? '',
    ], static function ($value) { return $value !== ''; }));
    header('Location: ' . $base_url . 'admin/user-management.php' . ($query ? '?' . $query : ''));
    exit;
}

$all     = toptunity_admin_users();
$tab     = isset($_GET['tab']) && $_GET['tab'] === 'freelancers' ? 'freelancers' : 'clients';
$role    = $tab === 'clients' ? 'client' : 'freelancer';
$q       = isset($_GET['q']) ? trim($_GET['q']) : '';
$counts  = ['clients' => 0, 'freelancers' => 0];
foreach ($all as $u) { if ($u['role'] === 'client') { $counts['clients']++; } if ($u['role'] === 'freelancer') { $counts['freelancers']++; } }

$rows = array_values(array_filter($all, function ($u) use ($role, $q) {
    if ($u['role'] !== $role) { return false; }
    return $q === '' || stripos($u['name'] . ' ' . $u['email'], $q) !== false;
}));

$sel = null;
$want = isset($_GET['id']) ? (int) $_GET['id'] : 0;
foreach ($rows as $r) { if ($r['id'] === $want) { $sel = $r; } }
if (!$sel && $rows) { $sel = $rows[0]; }

$reports = toptunity_admin_reports();
$reports_received = $sel ? count(array_filter($reports, function ($r) use ($sel) { return $r['reported'] === $sel['name']; })) : 0;

$page_title = "User Management";
$flash = tt_flash();
include '../includes/header.php';
include '../includes/client-nav.php';

$status_class = ['Active' => 'released', 'Suspended' => 'past', 'Deactivated' => 'cancelled', 'Inactive' => 'cancelled'];
?>

<div class="welcome-row">
  <div>
    <h1>User Management</h1>
    <p class="subtle">View, search and manage clients and freelancers.</p>
  </div>
</div>

<?php if ($flash): ?><div class="note-soft" role="status" style="margin-top:1rem;"><?= e($flash) ?></div><?php endif; ?>

<div class="search-wide" style="margin-top:1.25rem;">
  <form method="get" action="user-management.php" role="search" style="display:flex; gap:0.6rem; width:100%;">
    <input type="hidden" name="tab" value="<?= e($tab) ?>">
    <div class="search-wide__input">
      <?= icon('search', 16) ?>
      <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search users by name or email…" aria-label="Search users">
    </div>
    <button type="submit" class="btn--dark-sm">Search</button>
  </form>
</div>

<div class="admin-layout">
  <section class="admin-list">
    <div class="tabs-line">
      <a href="user-management.php?tab=clients" class="<?= $tab === 'clients' ? 'is-active' : '' ?>">Client List <small><?= (int) $counts['clients'] ?></small></a>
      <a href="user-management.php?tab=freelancers" class="<?= $tab === 'freelancers' ? 'is-active' : '' ?>">Freelancer List <small><?= (int) $counts['freelancers'] ?></small></a>
    </div>
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead><tr><th>Name · Email address</th><th>Joined</th><th>Status</th><th></th></tr></thead>
        <tbody>
          <?php if (!$rows): ?><tr><td colspan="4" class="muted" style="text-align:center; padding:1.2rem;">No users match your search.</td></tr><?php endif; ?>
          <?php foreach ($rows as $u): ?>
            <tr class="<?= $sel && $sel['id'] === $u['id'] ? 'is-selected' : '' ?>">
              <td><strong><?= e($u['name']) ?></strong><small><?= e($u['email']) ?></small></td>
              <td><?= e($u['joined']) ?></td>
              <td><span class="status status--<?= e($status_class[$u['status']] ?? 'cancelled') ?>"><?= e($u['status']) ?></span></td>
              <td><a class="view" href="user-management.php?tab=<?= e($tab) ?>&amp;id=<?= (int) $u['id'] ?>">View</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <aside class="admin-side">
    <?php if (!$sel): ?>
      <h2>User Details</h2><p class="muted">No user selected.</p>
    <?php else: ?>
      <h2>User Details</h2>
      <div style="display:flex; align-items:center; gap:0.7rem;">
        <?= avatar('#CCFBF1', '#1E293B', 'short', 44) ?>
        <div>
          <strong style="font-size:0.9rem;"><?= e($sel['name']) ?></strong>
          <div style="margin-top:0.2rem; font-size:0.72rem; color:var(--color-muted-gray);"><?= e(ucfirst($sel['role'])) ?> · <span class="status status--<?= e($status_class[$sel['status']] ?? 'cancelled') ?>"><?= e($sel['status']) ?></span></div>
        </div>
      </div>
      <div style="margin-top:1rem;">
        <div class="kv"><span>Email</span><strong style="font-size:0.72rem;"><?= e($sel['email']) ?></strong></div>
        <div class="kv"><span>Projects</span><strong><?= $sel['role'] === 'client' ? 2 : 0 ?></strong></div>
        <div class="kv"><span>Reports received</span><strong style="color:var(--color-error-base);"><?= (int) $reports_received ?></strong></div>
        <?php if (!empty($sel['warnings'])): ?><div class="kv"><span>Warnings issued</span><strong><?= (int) $sel['warnings'] ?></strong></div><?php endif; ?>
        <?php if ($sel['status'] === 'Suspended'): ?><div class="kv"><span>Suspended on</span><strong>Oct 02, 2026</strong></div><?php endif; ?>
      </div>

      <form method="post" action="user-management.php?tab=<?= e($tab) ?>&amp;id=<?= (int) $sel['id'] ?>" style="margin-top:0.9rem;">
        <input type="hidden" name="user_id" value="<?= (int) $sel['id'] ?>">
        <?php if ($sel['status'] !== 'Active'): ?>
          <button type="submit" name="action" value="reactivate" class="btn btn--pale-green btn--block">Reactivate</button>
        <?php else: ?>
          <button type="submit" name="action" value="suspend" class="btn btn--pale-red btn--block">Suspend</button>
        <?php endif; ?>
        <button type="submit" name="action" value="deactivate" class="btn btn--row-outline btn--block">Deactivate</button>
      </form>
      <p class="note-line" style="margin-top:0.8rem;">Suspended users cannot log in or send messages; their profiles and projects are hidden.</p>
    <?php endif; ?>
  </aside>
</div>

</main>

<?php include '../includes/footer.php'; ?>