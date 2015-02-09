<div class="row">
    <div class="col-sm-12">
        <p>
            <?php print $message; ?>
        </p>
        <?php print form_open('', array('name' => $form_name))
        . '<hr>'
        . form_button(array(
            'name' => $form_name.'_submit',
            'type' => 'submit',
            'class' => $btn_class,
            'content' => $action_text
        )).' '
        . anchor(base_url().'admin/modules', t('Cancel'), 'class="btn btn-xs btn-default"')
        . form_close(); ?>
    </div>
</div>