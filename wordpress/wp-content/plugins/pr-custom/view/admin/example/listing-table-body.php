<?php

$this->private();

$userpic = "http://0.gravatar.com/avatar/954bf8fdb81484be1e11eb18df0b86c7?s=32&amp;d=mm&amp;r=g";

if (empty($users)) :
    ?>
    <tr>
        <td colspan="6" style="text-align: center;" class="role column-role" data-colname="Role">no registries</td>
    </tr>
    <?php
else :
    foreach ($users as $row) :
        ?>
        <tr id="user-<?= $row->id ?>">
            <th scope="row" class="check-column">
                <input type="checkbox" name="users[]" id="user_<?= $row->id ?>" class="administrator" value="<?= $row->id ?>">
                <label for="user_<?= $row->id ?>">
                    <span class="screen-reader-text">Select admin</span>
                </label>
            </th>
            <td class="username column-username has-row-actions column-primary" data-colname="Username">
                <img
                    alt="" src="<?= $userpic ?>" srcset="<?= $userpic ?> 2x"
                    class="avatar avatar-32 photo" height="32" width="32" loading="lazy" decoding="async">
                <strong><a href="javascript:;"><?= $row->user ?></a></strong>
                <br>
                <div class="row-actions">
                    <span class="edit">
                        <a href="javascript:;">Edit</a> |
                    </span>
                    <span class="view">
                        <a href="javascript:;" aria-label="View posts by admin">View</a>
                    </span>
                </div>
                <button type="button" class="toggle-row">
                    <span class="screen-reader-text">Show more details</span>
                </button>
            </td>
            <td class="role column-role" data-colname="Role"><?= $row->name ?></td>
            <td class="role column-role" data-colname="Role"><?= $row->surname_1 ?></td>
            <td class="role column-role" data-colname="Role"><?= $row->surname_2 ?></td>
            <td class="email column-email" data-colname="Email">
                <a href="javascript:;"><?= $row->email ?></a>
            </td>
        </tr>
        <?php
    endforeach;
endif;