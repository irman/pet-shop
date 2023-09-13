<?php

namespace Irman\Notify\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Irman\Notify\Contracts\Notifiable;

class ModelUpdated
{
    use Dispatchable, SerializesModels;

    private Notifiable $model;

    public function __construct(Notifiable $model)
    {
        $this->model = $model;
    }

    public function getModel(): Notifiable
    {
        return $this->model;
    }
}
