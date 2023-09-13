# Notify

This package provides a convenient way to send a webhook.

## Getting Started

To install this package, you need to run the command `composer install` in your terminal. This will download and install all the required dependencies for this package.

## How To Use

### Step 1

Implement `Irman\Notify\Contracts\Notifiable` and its methods on a model or any entity.

For example:

```php
<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Irman\Notify\Contracts\Notifiable;
use Irman\Notify\Events\ModelUpdated;

class Order extends Model implements Notifiable
{
    /**
     * @return string|array<string, mixed>
     */
    function getNotifiableContent(): string|array
    {
        $description = "Order status for " . $this->uuid . " has been updated";
        return [
            "@type" => "MessageCard",
            "@context" => "http://schema.org/extensions",
            "themeColor" => "0076D7",
            "summary" => $description,
            "sections" => [
                [
                    "activityTitle" => $description,
                    "activitySubtitle" => "PetShop",
                    "facts" => [
                        [
                            "name" => "New Status",
                            "value" => $this->order_status->title,
                        ],
                    ],
                    "markdown" => true
                ]
            ],
        ];
    }
}

```

### Step 2

Trigger the event `Irman\Notify\Events\ModelUpdated` and pass the entity/model as the parameter. Like so:

```php
use Irman\Notify\Events\ModelUpdated;

// Some other codes ...

if($order->wasChanged('order_status_uuid')){
    event(new ModelUpdated($order));
}
```
