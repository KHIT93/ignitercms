<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?php print base_url().'user/profile'; ?>">View</a></li>
    <li role="presentation"><a href="<?php print base_url().'user/'.$this->user->_uid().'/edit'; ?>">Edit</a></li>
    <li role="presentation"><a href="<?php print base_url().'user/'.$this->user->_uid().'/changepassword'; ?>">Change password</a></li>
    <li role="presentation"><a href="<?php print base_url().'user/logout'; ?>">Logout</a></li>
</ul><br/>