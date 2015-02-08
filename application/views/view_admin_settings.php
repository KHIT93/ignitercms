<?php foreach ($categories as $category => $data) { ?>
<div class="col-sm-6">
    <div class="panel panel-default">
        <div class="panel-heading"><?php print heading($data['name'], 3, 'class="panel-title"'); ?></div>
        <div class="list-group">
            <?php $this->load->view('view_admin_settings_items',array('items' => $items[$category])); ?>
        </div>
    </div>
</div>
<?php } ?>