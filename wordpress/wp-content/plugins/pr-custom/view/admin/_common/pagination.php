<?php

$this->private();

$total = $total == 1 ? $total.' item' : ($total ?? 0).' items';
$p_first = 1;
$p_first_enable = $first ? '' : 'disabled';

$p_prev = $page <= 1 ? 1 : ($page - 1);
$p_prev_enable = $prev ? '' : 'disabled';

$p_next = $page < $pages ? ($page + 1) : $pages;
$p_next_enable = $next ? '' : 'disabled';

$p_last = $pages;
$p_last_enable = $last ? '' : 'disabled';
?>
<span class="displaying-num"><?= $total ?></span>
<button class="tablenav-pages-navspan button first-page" title="first page" data-target="<?= $p_first ?>" <?= $p_first_enable ?>>&laquo;</button>
<button class="tablenav-pages-navspan button prev-page" title="previous page" data-target="<?= $p_prev ?>" <?= $p_prev_enable ?>>&lsaquo;</button>
<span class="pagination-links">
    <span class="paging-input">
        <input class="current-page" type="text" name="paged" value="<?= $page ?? 0 ?>" size="3" aria-describedby="table-paging" disabled/>
        <span class="tablenav-paging-text"> of <span class="total-pages"><?= $pages ?? 0 ?></span>
    </span>
</span>
<button class="tablenav-pages-navspan button next-page" title="next page" data-target="<?= $p_next ?>" <?= $p_next_enable ?>>&rsaquo;</button>
<button class="tablenav-pages-navspan button last-page" title="last page" data-target="<?= $p_last ?>" <?= $p_last_enable ?>>&raquo;</button>
