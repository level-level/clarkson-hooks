<?php
use Clarkson\Hooks\HookManager;
$hookManager = new HookManager();
add_action('all', array($hookManager, 'loadHook'));