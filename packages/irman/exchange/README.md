# Exchange

This package provides a convenient way to convert currencies based on the latest exchange rates from the [European Central Bank](https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml). It is designed to be used internally by other applications that need currency conversion functionality.

## Getting Started

To install this package, you need to run the command `composer install` in your terminal. This will download and install all the required dependencies for this package.

## How To Use

This package defines a GET endpoint at `{exchange.route.group.prefix}/convert` that accepts two query parameters: `amount` and `currency`. These parameters specify the source amount and target currencies for the conversion. For example, to convert 100 euros to Malaysian Ringgit, you can send a request like this:

```
GET {exchange.route.group.prefix}/convert?amount=100&currency=MYR
```

The response will be a JSON object with the following fields:

- `success`: an integer value indicating whether the conversion was successful or not
- `data`: an array of numeric values containing the converted amount and rate

## API Documentation

You can find the OpenAPI documentation for this package in the file `api-docs.yaml` located in the root directory of this package. This file contains detailed information about the endpoint, parameters, responses, and examples for this package. You can use any OpenAPI-compatible tool to view or edit this file.
