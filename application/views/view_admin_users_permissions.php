<?php print validation_errors(); ?>
<?php print form_open('', array('name' => 'users_permissions')); ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th><?php print t('Permission'); ?></th>
                <?php foreach ($roles as $role) { ?>
                <th><?php print ucfirst(t($role->name)); ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $permission) { ?>
            <tr>
                <td><?php print $permission->name; ?><br/>
                    <small><?php print $permission->description; ?></small>
                </td>
            <?php foreach ($roles as $role) { ?>
                <td style="text-align:center;"><?php print form_checkbox(array('name' => $permission->permission.'[]', 'value' => $role->rid, 'checked' => ((in_array($role->rid, explode(';', $permission->rid))) ? true : false))); ?></td>
            <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php print form_button(array('type' => 'submit', 'name' => 'users_permissions_edit_submit', 'content' => t('Save changes'), 'class' => 'btn btn-sm btn-primary')); ?>
<?php print form_close(); ?>