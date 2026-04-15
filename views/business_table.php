<?php
?>
<div class="table-responsive">
    <table class="table align-middle" id="businessTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Business Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Avg Rating</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody id="businessTbody">
        <?php if (empty($businesses)): ?>
            <tr id="noDataRow">
                <td colspan="7" class="text-center py-5 text-muted">
                    <i class="bi bi-building fs-1 d-block mb-2 opacity-25"></i>
                    No businesses yet. Add your first one!
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($businesses as $i => $b): ?>
            <tr id="row-<?= $b['id'] ?>">
                <td class="fw-semibold text-muted serial-number"></td>
                <td class="fw-semibold"><?= htmlspecialchars($b['name']) ?></td>
                <td class="text-muted small"><?= htmlspecialchars($b['address']) ?></td>
                <td><?= htmlspecialchars($b['phone']) ?></td>
                <td><?= htmlspecialchars($b['email']) ?></td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="raty-display"
                             data-rating="<?= $b['avg_rating'] ?>">
                        </div>
                        <span class="rating-badge"><?= number_format($b['avg_rating'], 1) ?></span>
                    </div>
                </td>
                <td class="text-end">
                    <div class="action-btns">
                        <!-- Rate -->
                        <button class="btn-action btn-rate"
                                data-id="<?= $b['id'] ?>"
                                data-name="<?= htmlspecialchars($b['name']) ?>"
                                title="Rate">
                            <i class="bi bi-star-fill"></i>
                        </button>
                        <!-- Edit -->
                        <button class="btn-action btn-edit"
                                data-id="<?= $b['id'] ?>"
                                data-name="<?= htmlspecialchars($b['name'], ENT_QUOTES) ?>"
                                data-address="<?= htmlspecialchars($b['address'], ENT_QUOTES) ?>"
                                data-phone="<?= htmlspecialchars($b['phone'], ENT_QUOTES) ?>"
                                data-email="<?= htmlspecialchars($b['email'], ENT_QUOTES) ?>"
                                title="Edit">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <!-- Delete -->
                        <button class="btn-action btn-del"
                                data-id="<?= $b['id'] ?>"
                                data-name="<?= htmlspecialchars($b['name'], ENT_QUOTES) ?>"
                                title="Delete">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>