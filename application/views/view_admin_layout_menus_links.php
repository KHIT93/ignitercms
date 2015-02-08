<?php print anchor(base_url().'admin/layout/menus/'.$this->uri->segment(4).'/links/add', '<i class="ace-icon fa fa-plus"></i>'.t('Add menu link'), 'class="btn btn-sm btn-info"'); ?>
<div class="hr hr-18 dotted"></div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th><?php print t('Title'); ?></th>
            <th><?php print t('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($data as $menu) {
?>
        <tr>
            <td><?php print anchor(base_url().$menu->link, $menu->title); ?></td>
            <td style="text-align:right;">
            <?php print anchor(base_url().'admin/layout/menus/'.$menu->mid.'/links/'.$menu->mlid.'/edit', t('Edit'), 'class="btn btn-xs btn-default"').' '
            . anchor(base_url().'admin/layout/menus/'.$menu->mid.'/links/'.$menu->mlid.'/delete', t('Delete'), 'class="btn btn-xs btn-danger"').' '; ?>
            </td>
        </tr>
<?php } ?>
    </tbody>
</table>