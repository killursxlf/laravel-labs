<?php return array (
  'App\\Providers\\EventServiceProvider' => 
  array (
    'App\\Events\\TaskCreated' => 
    array (
      0 => 'App\\Listeners\\SendTaskCreatedNotification',
      1 => 'App\\Listeners\\SendTaskCreatedTelegramNotification',
    ),
  ),
  'Illuminate\\Foundation\\Support\\Providers\\EventServiceProvider' => 
  array (
    'App\\Events\\TaskCreated' => 
    array (
      0 => 'App\\Listeners\\SendTaskCreatedNotification@handle',
      1 => 'App\\Listeners\\SendTaskCreatedTelegramNotification@handle',
    ),
  ),
);