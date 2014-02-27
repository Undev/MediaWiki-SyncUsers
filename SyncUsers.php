<?php
$wgExtensionCredits['api'][] = array(
	'path' => __FILE__,
	'name' => 'SyncUsers API Function',
);

// Map class name to filename for autoloading
$wgAutoloadClasses['SyncUsers'] = __DIR__ . '/ApiSyncUsers.php';

// Map module name to class name
$wgAPIModules['SyncUsers'] = 'SyncUsers';

// Load the internationalization file
//$wgExtensionMessagesFiles['myextension'] = __DIR__ . '/SampleApiExtension.i18n.php';

return true;
