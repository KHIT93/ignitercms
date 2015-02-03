<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?php print base_url().'user/login'; ?>">Login</a></li>
    <li role="presentation" class="active"><a href="<?php print base_url().'user/register'; ?>">Register</a></li>
</ul><br/>
<?php
print form_open();
print '<div class="form-group">'.form_input('username', '', 'class="form-control" placeholder=Username').'</div>';
print '<div class="form-group">'.form_input('name', '', 'class="form-control" placeholder=Name').'</div>';
print '<div class="form-group">'.form_input('email', '', 'class="form-control" placeholder=Email').'</div>';
print '<div class="form-group">'.form_password('password', '', 'class="form-control" placeholder=Password').'</div>';
print '<div class="form-group">'.form_submit('login_submit', 'Login', 'class="btn btn-default"');
print form_close();
?>