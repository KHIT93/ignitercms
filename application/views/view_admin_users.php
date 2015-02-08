<?php print anchor(base_url().'user/add', '<i class="ace-icon fa fa-plus"></i>'.t('Add user'), 'class="btn btn-sm btn-info"'); ?>
<div class="hr hr-18 dotted"></div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="hidden-xs"><?php print t('Name'); ?></th>
            <th><?php print t('Username'); ?></th>
            <th class="hidden-xs"><?php print t('Role'); ?></th>
            <th><?php print t('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $user) { ?>
        <tr>
            <td class="hidden-xs"><?php print $user->name; ?></td>
            <td><?php print anchor(base_url().'user/'.$user->uid.'/edit', $user->username); ?></td>
            <td class="hidden-xs"><?php print $user->role; ?></td>
            <td style="text-align:right;">
            <?php print anchor(base_url().'user/'.$user->uid.'/edit', t('Edit'), 'class="btn btn-xs btn-default"').' '
            . (($user->active == 1) ? anchor(base_url().'user/'.$user->uid.'/disable', t('Disable'), 'class="btn btn-xs btn-info"') : anchor(base_url().'user/'.$user->uid.'/enable', t('Enable'), 'class="btn btn-xs btn-info"')).' '
            . anchor(base_url().'user/'.$user->uid.'/delete', t('Delete'), 'class="btn btn-xs btn-danger"').' '; ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>