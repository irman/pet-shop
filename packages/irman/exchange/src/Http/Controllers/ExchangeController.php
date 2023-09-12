<?php

namespace Irman\Exchange\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Irman\Exchange\Services\Exchange;

class ExchangeController extends Controller
{
    /**
     * @throws Exception
     */
    public function convert(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'amount' => ['required', 'numeric'],
            'currency' => ['required', 'string', Rule::in(config('exchange.currency.supported'))],
        ], [
            'currency.in' => "Unsupported currency",
        ]);

        $amount = floatval($validated['amount']);
        $destinationCurrency = $validated['currency'];

        return $this->response($amount, $destinationCurrency);
    }

    /**
     * @throws Exception
     */
    protected function response($amount, $destinationCurrency)
    {
        $exchange = (new Exchange($amount));

        return response()->json([
            'success' => 1,
            'data' => [
                'source' => [
                    'currency' => 'EUR',
                    'amount' => $amount,
                ],
                'destination' => [
                    'currency' => $destinationCurrency,
                    'amount' => $exchange->to($destinationCurrency),
                    'rate' => $exchange->getRate($destinationCurrency),
                ],
            ],
            'error' => null,
            'errors' => [],
            'extra' => [],
        ], 200, [], JSON_PRETTY_PRINT);
    }
}
