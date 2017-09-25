<?php

use marvin255\bxcontent\SnippetManager;
use marvin255\bxcontent\Exception;
use Bitrix\Main\Event;

require_once __DIR__ . '/lib/Autoloader.php';

$snippetManager = SnippetManager::getInstance(true);
$snippetManager->addJs('/bitrix/js/marvin255.bxcontent/plugin.js');
$snippetManager->addCss('/bitrix/css/marvin255.bxcontent/plugin.css');

//add test snippets
$snippetManager->set('slider', new \marvin255\bxcontent\snippets\Base([
    'label' => 'Слайдер',
    'controls' => [
        new \marvin255\bxcontent\controls\Combine([
            'name' => 'slides',
            'label' => 'Слайды',
            'multiple' => true,
            'elements' => [
                new \marvin255\bxcontent\controls\File([
                    'name' => 'image',
                    'label' => 'Изображение',
                ]),
                new \marvin255\bxcontent\controls\Input([
                    'name' => 'sign',
                    'label' => 'Подпись',
                ]),
            ],
        ]),
    ],
]));

$event = new Event(
    'marvin255.bxcontent',
    'collectSnippets',
    ['snippetManager' => $snippetManager]
);
$event->send();
foreach ($event->getResults() as $eventResult) {
    if ($eventResult->getType() === EventResult::ERROR) {
        throw new Exception('Get error while collecting snippets: ' . implode(',', $eventResult->getErrorMessages()));
    }
}
