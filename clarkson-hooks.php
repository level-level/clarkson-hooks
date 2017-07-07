<?php
use Clarkson\Hooks\HookManager;

// Skip loading the hookmanager if not in a WordPress context
if ( ! defined('WPINC') ) {
  return;
}

$hookManager = new HookManager();
add_action('all', array($hookManager, 'loadHook'));
