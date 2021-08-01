<?php

return [
    'frontend' => [
        'porthd/webhelp/resourcesforviewhelpers' => [
            'target' => \Porthd\Webhelp\Middleware\ResourcesForViewhelpers::class,
            'after' => [
                'typo3/cms-frontend/tsfe',
            ],
            'before' => [
                'typo3/cms-frontend/prepare-tsfe-rendering',
            ],
        ],
    ],
];
