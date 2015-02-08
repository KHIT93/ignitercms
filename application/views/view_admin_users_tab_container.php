<div class="tabbable">
    <ul class="nav nav-tabs tab-color-blue">
    <li<?php (($this->uri->uri_string == 'admin/users') ? print ' class="active"' : ''); ?>><?php print anchor(base_url().'admin/users', t('Users')); ?></li>
    <li<?php (($this->uri->uri_string == 'admin/users/roles') ? print ' class="active"' : ''); ?>><?php print anchor(base_url().'admin/users/roles', t('Roles')); ?></li>
    <li<?php (($this->uri->uri_string == 'admin/users/permissions') ? print ' class="active"' : ''); ?>><?php print anchor(base_url().'admin/users/permissions', t('Permissions')); ?></li>
    </ul><br/>
    <?php print $content; ?>
</div>