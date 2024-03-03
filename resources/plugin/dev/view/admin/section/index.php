<?= $this->private(); ?>

<div class="row">
    <div class="tablenav tablenav-pages mt-2 mb-3">
        <div class="alignleft actions">
            <input type="search" id="filter-name" value="<?= $filter->name ?? '' ?>" placeholder="name/s">
        </div>
        <div class="alignleft actions">
            <input type="search" id="filter-surname" value="<?= $filter->surname ?? '' ?>" placeholder="surname/s">
        </div>
        <div class="alignleft actions">
            <input type="search" id="filter-email" value="<?= $filter->email ?? '' ?>" placeholder="email">
        </div>
        <div class="alignleft actions">
            <button type="button" id="filter-button" class="button action"><i class="fa fa-search"></i> Filter</button>
        </div>
        <div class="alignleft actions">
            <button type="button" id="filter-clear-button" class="button action"><i class="fa fa-times"></i> Clear</button>
        </div>
        <div class="alignleft actions">
            <button class="button action" onclick="createUsersJsonFile()"><i class="fa fa-users"></i> Create Json</button>
        </div>
        <div class="alignleft actions">
            <button class="button action" onclick="emptyUsersJsonFile()"><i class="fa fa-users"></i> Empty Json</button>
        </div>
        <div class="float-end table-pagination"><?= $this->view('admin.common.pagination', $pagination) ?></div>
        <br class="clear">
    </div>
</div>

<table class="wp-list-table widefat fixed striped table-view-list users">
    <thead><?= $this->view('admin.section.index-table-head') ?></thead>
    <tbody id="the-list" data-wp-lists="list:user"><?= $this->view('admin.section.index-table-body', ['users' => $users]) ?></tbody>
    <tfoot><?= $this->view('admin.section.index-table-head', ['table' => ['pre' => 'cb']]) ?></tfoot>
</table>

<div class="row">
    <div class="tablenav-pages mt-3 mb-2">
        <div class="float-end table-pagination"><?= $this->view('admin.common.pagination', $pagination) ?></div>
    </div>
</div>

<div class="modal fade" id="modal-dialog" tabindex="-1" style="z-index:100000" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Empty Users Json File</h5>
                <button type="button" class="close"  onclick="cancelEmptyUsersJsonFile()" aria-label="Cancel">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to reset to empty the User's Json file?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="cancelEmptyUsersJsonFile()">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="resetUsersJsonFile()">Yes, empty json</button>
            </div>
        </div>
    </div>
</div>
