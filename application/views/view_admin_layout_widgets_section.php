<tr>
    <td style="padding-left: 2em;"><?php print $widget->title; ?></td>
    <td style="text-align:center;">
        <?php print form_hidden(array('wid['.$widget->wid.']' => $widget->wid)); ?>
        <?php print form_dropdown('section['.$widget->wid.']', parse_info_file($this->theme->path_to_specifc_theme($this->configuration->get('site_theme')).'/'.$this->configuration->get('site_theme').'.info')['sections'], $widget->section); ?>
    </td>
    <td style="text-align:right;">
        <?php print anchor(base_url().'admin/layout/widgets/'.$widget->wid.'/edit', t('Edit'), 'class="btn btn-xs btn-default"').' '
        . (($widget->type == 'simple') ? anchor(base_url().'admin/layout/widgets/'.$widget->wid.'/delete', t('Delete'), 'class="btn btn-xs btn-danger"').' ' : ''); ?>
    </td>
</tr>