<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $folder => $info_file) {
            $info_data = parse_info_file($info_file);
            ?>
        <tr>
            <td>
                <img src="<?php print$info_data['screenshot']; ?>">
            </td>
            <td>
                <?php print heading($info_data['name'], 4); ?>
                <p><?php print $info_data['description']; ?></p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
            <?php print anchor(base_url().'admin/themes/'.$folder.'/apply', t('Apply theme'), 'class="btn btn-xs btn-default"'); ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>