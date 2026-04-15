<?php
require_once __DIR__ . '/models/Business.php';

$model      = new Business();
$businesses = $model->getAll();
?>
<?php require_once __DIR__ . '/views/common/header.php'; ?>

<!-- ── Top nav bar ── -->
<nav class="top-nav">
    <div class="container-xl d-flex align-items-center justify-content-between">
        <div class="brand">
            <i class="bi bi-buildings-fill me-2"></i>BizList
        </div>
        <button class="btn btn-primary btn-add-new" id="addBusinessBtn">
            <i class="bi bi-plus-lg me-1"></i> Add Business
        </button>
    </div>
</nav>

<!-- ── Page header ── -->
<div class="page-header">
    <div class="container-xl">
        <h1 class="page-title">Business Directory</h1>
        <p class="page-subtitle">Manage listings and community ratings in one place.</p>
    </div>
</div>

<!-- ── Main content ── -->
<main class="container-xl py-4">

    <!-- Stats bar -->
    <div class="stats-bar mb-4">
        <div class="stat-chip">
            <i class="bi bi-building me-1"></i>
            <span id="totalCount"><?= count($businesses) ?></span> Businesses
        </div>
    </div>

    <!-- Table card -->
    <div class="table-card">
        <?php require_once __DIR__ . '/views/business_table.php'; ?>
    </div>

</main>

<!-- ── Toast container ── -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:9999">
    <div id="appToast" class="toast align-items-center border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body fw-semibold" id="toastMessage">Done!</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<!-- ── Modals ── -->
<?php require_once __DIR__ . '/views/modals/business_modal.php'; ?>
<?php require_once __DIR__ . '/views/modals/rating_modal.php'; ?>
<?php require_once __DIR__ . '/views/modals/delete_modal.php'; ?>

<?php require_once __DIR__ . '/views/common/footer.php'; ?>