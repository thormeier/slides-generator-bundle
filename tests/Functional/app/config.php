<?php

$container->loadFromExtension('framework', array(
    'secret' => 'foobar',
));

// Twig Configuration
$container->loadFromExtension('thormeier_slides_generator', array(
    'identifier_pattern' => '/(TICKET [0-9]+)/',
    'keyword_add' => ':slides',
    'repository_service' => 'thormeier_slides_generator.repository.git',
    'renderer_service' => 'thormeier_slides_generator.renderer.markdown',
    'generator_service' => 'thormeier_slides_generator.generator',
));
