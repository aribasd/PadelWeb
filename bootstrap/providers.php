<?php

return [
    App\Providers\AppServiceProvider::class,
    ...(env('APP_ENV') === 'local' && env('TELESCOPE_ENABLED', false)
        ? [App\Providers\TelescopeServiceProvider::class]
        : []),
];
