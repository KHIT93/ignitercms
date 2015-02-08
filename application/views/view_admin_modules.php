<?php print anchor(base_url().'admin/layout/modules/add', '<i class="ace-icon fa fa-plus"></i>'.t('Add module').' (Disabled)', 'class="btn btn-sm btn-info disabled"'); ?>
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
        <?php foreach ($mods as $mod) {
            $data = (is_dir(APPPATH.'modules/'.$mod)) ? parse_info_file(APPPATH.'modules/'.$mod.'/'.$mod.'.info'): parse_info_file('site/modules/'.$mod.'/'.$mod.'.info');
        ?>
        <tr>
            <td><?php print $data['name']; ?></td>
            <td class="hidden-xs"><?php print $data['description']; ?></td>
            <td style="text-align:right;">
            <?php $active = ($this->db->where('module', $mod)->count_all_results('modules') > 0) ? $this->db->select('active')->from('modules')->where('module', $mod)->get()->result()[0]->active : 0;
            if($active == 1) {
                if(method_exists($this->{$mod}, 'config')) {
                    if(isset($data['config'])) {
                        print anchor(base_url().$data['config'], t('Configure'), 'class="btn btn-xs btn-primary"').' ';
                    }
                    else {
                        print anchor(base_url().'admin/modules/'.$mod, t('Configure'), 'class="btn btn-xs btn-primary"').' ';
                    }
                }
                print anchor(base_url().'admin/modules/uninstall/'.$mod, t('Uninstall'), 'class="btn btn-xs btn-danger"');
            }
            else {
                print anchor(base_url().'admin/modules/install/'.$mod, t('Install'), 'class="btn btn-xs btn-success"');
            } ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>