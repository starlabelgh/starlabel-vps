<?php

return [
    'audit_columns' => [
        'creator_column' => 'creator',
        'editor_column'  => 'editor',
        'default_active' => true,
    ],
    'activity_log'  => [
        'model' => \Shipu\Watchable\Models\Activity::class,
    ],
];
