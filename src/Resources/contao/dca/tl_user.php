<?php

declare(strict_types=1);

Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addField('limitedWidth', 'backendTheme', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_user')
    ->applyToPalette('login', 'tl_user')
    ->applyToPalette('admin', 'tl_user')
    ->applyToPalette('group', 'tl_user')
    ->applyToPalette('extend', 'tl_user')
    ->applyToPalette('custom', 'tl_user')
;

$GLOBALS['TL_DCA']['tl_user']['fields'] = [
    ...$GLOBALS['TL_DCA']['tl_user']['fields'],
    ...[
        'limitedWidth' => [
            'exclude' => true,
            'inputType' => 'checkbox',
            'default' => false,
            'eval' => [
                'tl_class' => 'w50 m12',
            ],
            'save_callback' => [static fn ($v) => '1' === $v], // Correctly store boolean types
            'sql' => [
                'type' => Doctrine\DBAL\Types\Types::BOOLEAN,
                'default' => false,
            ],
        ],
    ],
];
