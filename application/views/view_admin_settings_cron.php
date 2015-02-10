<p><?php print t('Scheduled tasks, also know as Cron tasks, is a set of periodic actions that are performed on the website. This could be re-indexing content for faster access and checkiing for module or core updates'); ?></p>
<?php print form_open(base_url().'cron/execute')
        . form_button(array(
            'name' => 'cron_execute_submit',
            'type' => 'submit',
            'content' => t('Run scheduled tasks now'),
            'class' => 'btn btn-sm btn-default'
        ))
        . form_close().'<br/>'; ?>
<p><?php print t('Go to %link in order to run the scheduled tasks without being logged in', array('%link' => anchor(base_url().'cron/execute/'.$this->configuration->get('cron_key'), base_url().'cron/execute/'.$this->configuration->get('cron_key')))); ?></p>
<legend><?php print t('Settings for scheduled tasks'); ?></legend>
<p><?php print t('Choose how often scheduled tasks should be executed'); ?></p>
<?php print $form; ?>
