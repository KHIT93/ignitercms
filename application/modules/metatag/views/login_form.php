<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="<?php print base_url().'user/login'; ?>">Login</a></li>
    <li role="presentation"><a href="<?php print base_url().'user/register'; ?>">Register</a></li>
</ul><br/>
<?php
print form_open();
print '<div class="form-group">'.form_input('username', '', 'class="form-control" placeholder=Username').'</div>';
print '<div class="form-group">'.form_password('password', '', 'class="form-control" placeholder=Password').'</div>';
print '<div class="modal-footer">'.form_submit('login_submit', 'Login', 'class="btn btn-primary"');
print anchor(base_url(), 'Return to site', 'class="btn btn-default"').'</div>';

print form_close();