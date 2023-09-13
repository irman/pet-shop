<?php

namespace Irman\Notify\Tests;

use Irman\Notify\Contracts\Notifiable;

class MockModel implements Notifiable
{
    /**
     * @return string|array<string, string>
     */
    function getNotifiableContent(): string|array
    {
        return [
            'Test Key' => 'Test Content',
        ];
    }
}
