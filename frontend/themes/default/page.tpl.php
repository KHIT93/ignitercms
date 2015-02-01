<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?php print $site_name; ?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="<?php print ($page['sidebar_first']) ? 'col-sm-8' : 'col-sm-12'; ?>">
            <?php print $page['content']; ?>
        </div>
        <?php if($page['sidebar_first']) : ?>
        <div class="col-sm-4">
            <?php print $page['sidebar_first']; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<div class="container">
    <?php print $page['footer']; ?>
</div>
