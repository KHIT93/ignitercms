<?php foreach($items as $item) { ?>
<a href="<?php print base_url().$item['link']; ?>" class="list-group-item">
    <?php print heading($item['title'], 4, 'class="list-group-item-heading"'); ?>
    <p class="list-group-item-text"><?php print $item['description']; ?></p>
</a>
<?php } ?>