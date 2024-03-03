<?php

$this->private();

$pre = ! isset($table['pre']) ? 'ct' : $table['pre'];
?>
<tr>
    <td id="<?= $pre ?>" class="manage-column column-<?= $pre ?> check-column">
        <input id="<?= $pre ?>-select-all-1" type="checkbox">
        <label for="<?= $pre ?>-select-all-1">
            <span class="screen-reader-text">Select all</span>
        </label>
    </td>
    <th scope="col" class="manage-column column-user column-primary sorted asc" aria-sort="ascending" abbr="User">
        <a href="javascript:;">
            <span>Product</span>
            <span class="sorting-indicators">
                <span class="sorting-indicator asc" aria-hidden="true"></span>
                <span class="sorting-indicator desc" aria-hidden="true"></span>
            </span>
        </a>
    </th>
    <th scope="col" class="manage-column column-name">Name</th>
    <th scope="col" class="manage-column column-surname">Surname</th>
    <th scope="col" class="manage-column column-surname">Surname</th>
    <th scope="col" class="manage-column column-email sortable desc">
        <a href="javascript:;">
            <span>Email</span>
            <span class="sorting-indicators">
                <span class="sorting-indicator asc" aria-hidden="true"></span>
                <span class="sorting-indicator desc" aria-hidden="true"></span>
            </span>
            <span class="screen-reader-text">Sort ascending.</span>
        </a>
    </th>
</tr>