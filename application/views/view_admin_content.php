<?php print anchor(base_url().'content/add', '<i class="ace-icon fa fa-plus"></i>'.t('Add content'), 'class="btn btn-sm btn-info"'); ?>
<div class="hr hr-18 dotted"></div>
<div class="row">
    <div class="col-xs-12">
        <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                <th><?php print t('Title'); ?></th>
                <th class="hidden-xs"><?php print t('Author'); ?></th>
                <th class="hidden-xs"><?php print t('Status'); ?></th>
                <th><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i><?php print t('Last modified'); ?></th>
                <th><?php print t('Actions'); ?></th>
                </tr>
                </thead>
        <tbody>
        <?php
        foreach ($data as $node) {
        ?>
            <tr>
                    <td>
                    <?php print anchor(base_url().'content/'.$node->pid, $node->title); ?>
                    </td>
                    <td class="hidden-xs">
                    <?php print $node->author; ?>
                    </td>
                    <td class="hidden-xs">
                    <?php print $node->status; ?>
                    </td>
                    <td>
                    <?php print $node->last_updated; ?>
                    </td>
                    <td>
                    <div class="hidden-sm hidden-xs">
                    <?php print anchor(base_url().'content/'.$node->pid.'/edit', '<i class="ace-icon fa fa-pencil"></i>'.t('Edit'), 'class="btn btn-xs btn-primary"'); ?>
                    <?php print nbs(1); ?>
                    <?php print anchor(base_url().'content/'.$node->pid.'/delete', '<i class="ace-icon fa fa-trash-o"></i>'.t('Delete'), 'class="btn btn-xs btn-danger"'); ?>
                    </div>
                    </td>
                    </tr>
        <?php
        }
        ?>
        </tbody>
        </table>
    </div>
</div>