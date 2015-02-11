<?php print anchor(base_url().'admin/settings/redirect/add', '<i class="ace-icon fa fa-plus"></i>'.t('Add redirect'), 'class="btn btn-sm btn-info"'); ?>
<div class="hr hr-18 dotted"></div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th><?php print t('Source'); ?></th>
            <th><?php print t('Destination'); ?></th>
            <th class="hidden-xs"><?php print t('Date added'); ?></th>
            <th class="hidden-xs"><?php print t('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($redirects as $redirect) { ?>
        <tr>
            <td><?php print $redirect->source; ?></td>
            <td><?php print $redirect->alias; ?></td>
            <td class="hidden-xs"><?php print $redirect->date; ?></td>
            <td class="hidden-xs">
                <?php print anchor(base_url().'admin/settings/redirect/'.$redirect->aid.'/edit', t('Edit'), 'class="btn btn-xs btn-primary"').' '
                        . anchor(base_url().'admin/settings/redirect/'.$redirect->aid.'/delete', t('Delete'), 'class="btn btn-xs btn-danger"');
                ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>