<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th><?php print t('String'); ?></th>
            <th><?php print t('Translation'); ?></th>
            <th><?php print t('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($translations as $translation) { ?>
        <tr>
            <td><?php print $translation->string; ?></td>
            <td><?php print $translation->translation; ?></td>
            <td><?php print anchor(base_url().'admin/settings/translate/'.$translation->tid, t('Translate'), 'class="btn btn-xs btn-default"'); ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>