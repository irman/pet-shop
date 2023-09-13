<?php

namespace Irman\Notify\Contracts;

interface Notifiable
{
    function getNotifiableContent(): string|array;
}
