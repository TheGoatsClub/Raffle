<?php

/* Find all the *.php files in the app folder */
$folderItems = glob(realpath(RFL_PLUGIN_PATH) . '/app/*');

if (empty($folderItems))
    return;

$initCallbacks = []; // Array to store init callbacks

/* Find ClassName and require it */
foreach ($folderItems as $path) {
    $path = str_replace('\\', '/', $path);

    if (!str_contains($path, '.php'))
        continue;

    $className = str_replace('.php', '', basename($path));

    require_once $path;

    /* Here, we don't call init but save the callback in the array */
    $initCallbacks[] = function () use ($className) {
        if (method_exists($className, 'init')) {
            $className::{'init'}();
        }
    };
}

/* Call init for all classes in the order they were included */
foreach ($initCallbacks as $initCallback) {
    $initCallback();
}
