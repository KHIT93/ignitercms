<?php print anchor(base_url().'admin/layout/menus/add', '<i class="ace-icon fa fa-plus"></i>'.t('Add menu'), 'class="btn btn-sm btn-info"'); ?>
<div class="hr hr-18 dotted"></div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th><?php print t('Name'); ?></th>
            <th class="hidden-xs"><?php print t('Description'); ?></th>
            <th><?php print t('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $menu) {
        ?>    
        <tr>
            <td><?php print anchor(base_url().'admin/layout/menus/'.$menu->mid.'/links', $menu->name); ?></td>
            <td class="hidden-xs"><?php print $menu->description; ?></td>
            <td style="text-align:right;">
            <?php print anchor(base_url().'admin/layout/menus/'.$menu->mid.'/edit', t('Edit'), 'class="btn btn-xs btn-default"').' '
            . anchor(base_url().'admin/layout/menus/'.$menu->mid.'/links', t('View links'), 'class="btn btn-xs btn-info"').' '
            . anchor(base_url().'admin/layout/menus/'.$menu->mid.'/delete', t('Delete'), 'class="btn btn-xs btn-danger"').' '; ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
</table>