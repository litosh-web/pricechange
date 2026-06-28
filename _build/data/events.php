<?php
/** @noinspection PhpIncludeInspection */
$events = include($this->config['elements'] . 'events.php');
if (!is_array($events)) {
    $this->modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in Events');

    return;
}
$attributes = [
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => !empty($this->config['update']['events']),
    xPDOTransport::UNIQUE_KEY => 'name',
];

foreach ($events as $name) {
    /** @var modEvent[] $objects */
    $event = $this->modx->newObject('modEvent');
    $event->fromArray(array(
        'name' => $name,
        'service' => 1,
        'groupname' => $this->config['name']
    ), '', true, true);

    $vehicle = $this->builder->createVehicle($event, $attributes);
    $this->builder->putVehicle($vehicle);
}

$this->modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($events) . ' Events');