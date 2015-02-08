<?php print validation_errors();
print form_open('', array('name' => 'users_roles_add')); ?>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th><?php print t('Name'); ?></th>
                <th><?php print t('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $role) { ?>
            <tr>
                <td><?php print $role->name; ?></td>
                <td style="text-align:right;">
                <?php print anchor(base_url().'user/roles/'.$role->rid.'/edit', t('Edit'), 'class="btn btn-xs btn-default"').' '
                . anchor(base_url().'user/roles/'.$role->rid.'/delete', t('Delete'), 'class="btn btn-xs btn-danger"').' '; ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
                <td><?php print form_input(array('name' => 'name', 'placeholder' => t('Role name'), 'class' => 'form-control')); ?></td>
                <td style="text-align:right;"><?php print form_button(array('type' => 'submit', 'name' => 'users_roles_add_submit', 'content' => t('Add role'), 'class' => 'btn btn-sm btn-primary')); ?></td>
                </tr>
        </tbody>
    </table>
<?php print form_close(); ?>
