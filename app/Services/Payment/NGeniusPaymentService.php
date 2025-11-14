<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;
use App\Enums\PaymentStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class NGeniusPaymentService
{
    private string $apiUrl;
    private string $identityUrl;
    private string $apiKey;
    private string $outletReference;
    private string $currency;

    public function __construct()
    {
        $env = config('ngenius.environment');
        $config = config("ngenius.{$env}");

        $this->apiUrl = $config['api_url'];
        $this->identityUrl = $config['identity_url'];
        $this->apiKey = $config['api_key'];
        $this->outletReference = $config['outlet_reference'];
        $this->currency = config('ngenius.currency');
    }

    /**
     * Get Access Token from N-Genius
     */
    public function getAccessToken(): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $this->apiKey,
                'Content-Type' => 'application/vnd.ni-identity.v1+json',
                'Accept' => 'application/vnd.ni-identity.v1+json'
            ])->post($this->identityUrl . '/auth/access-token', [
                'realm' => $this->outletReference
            ]);

            if ($response->successful()) {
                return $response->json('access_token');
            }

            Log::error('N-Genius Access Token Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('N-Genius Access Token Exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    // private function getAccessToken(): ?string
    // {
    //     try {
    //         // استخدم Guzzle مباشرة للتحكم الكامل
    //         $client = new \GuzzleHttp\Client([
    //             'base_uri' => $this->apiUrl,
    //             'verify' => false,
    //             'timeout' => 30
    //         ]);

    //         $response = $client->request('POST', '/identity/auth/access-token', [
    //             'headers' => [
    //                 'Authorization' => 'Basic ' . $this->apiKey,
    //                 'Content-Type' => 'application/vnd.ni-identity.v1+json',
    //                 'Accept' => 'application/vnd.ni-identity.v1+json'
    //             ],
    //             'json' => [] // empty body أو ['realm' => $this->outletReference]
    //         ]);

    //         $body = json_decode($response->getBody()->getContents(), true);

    //         if (isset($body['access_token'])) {
    //             Log::info('✅ Token received via Guzzle!');
    //             return $body['access_token'];
    //         }

    //         Log::error('No access token in response', $body);
    //         return null;
    //     } catch (\GuzzleHttp\Exception\ClientException $e) {
    //         $response = $e->getResponse();
    //         $body = $response ? $response->getBody()->getContents() : 'No response body';

    //         Log::error('Guzzle Client Error', [
    //             'status' => $response ? $response->getStatusCode() : 'unknown',
    //             'body' => $body
    //         ]);

    //         return null;
    //     } catch (\Exception $e) {
    //         Log::error('Guzzle Exception: ' . $e->getMessage());
    //         return null;
    //     }
    // }

    /**
     * Create Payment Order
     */
    public function createPaymentOrder(Order $order): ?array
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return null;
        }

        try {
            $billingAddress = $order->billingAddress;
            $shippingAddress = $order->shippingAddress;

            $orderData = [
                'action' => 'SALE',
                'amount' => [
                    'currencyCode' => $this->currency,
                    'value' => (int)($order->total * 100)
                ],
                'merchantAttributes' => [
                    'redirectUrl' => url(config('ngenius.return_url')),
                    'webhookUrl' => url(config('ngenius.webhook_url')),
                    'skipConfirmationPage' => false,
                    'offerOnly' => 'VISA,MASTERCARD,APPLE_PAY,SAMSUNG_PAY'
                ],
                'merchantOrderReference' => $order->order_number,
                'description' => 'Order #' . $order->order_number,
                'billingAddress' => [
                    'firstName' => $billingAddress->first_name,
                    'lastName' => $billingAddress->last_name,
                    'address1' => $billingAddress->street_address,
                    'city' => $billingAddress->city,
                    'countryCode' => $billingAddress->country ?? 'AE',
                ],
                'shippingAddress' => [
                    'firstName' => $shippingAddress->first_name,
                    'lastName' => $shippingAddress->last_name,
                    'address1' => $shippingAddress->street_address,
                    'city' => $shippingAddress->city,
                    'countryCode' => $shippingAddress->country ?? 'AE',
                ],
                'emailAddress' => $billingAddress->email,
                'phoneNumber' => [
                    'countryCode' => '971',
                    'number' => $billingAddress->phone
                ]
            ];


            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/vnd.ni-payment.v2+json',
                'Accept' => 'application/vnd.ni-payment.v2+json'
            ])->post(
                $this->apiUrl . '/transactions/outlets/' . $this->outletReference . '/orders',
                $orderData
            );

            if ($response->successful()) {
                $responseData = $response->json();

                Log::info('N-Genius Order Response', [
                    'reference' => $responseData['reference'] ?? 'no-reference',
                    'links' => $responseData['_links'] ?? 'no-links',
                    'state' => $responseData['state'] ?? 'no-state'
                ]);

                $paymentUrl = $responseData['_links']['payment']['href'] ?? null;

                if (!$paymentUrl) {
                    Log::error('No payment URL in response!', $responseData);
                }

                // Save payment record
                Payment::create([
                    'order_id' => $order->id,
                    'payment_reference' => $responseData['reference'],
                    'outlet_id' => $responseData['outletId'] ?? null,
                    'amount' => $order->total,
                    'currency' => $this->currency,
                    'status' => 'pending',
                    'gateway_status' => $responseData['state'] ?? null,
                    'gateway_response' => $responseData,
                ]);

                return [
                    'success' => true,
                    'payment_url' => $paymentUrl,
                    'reference' => $responseData['reference']
                ];
            }

            Log::error('N-Genius Create Order Error', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('N-Genius Create Order Exception', [
                'message' => $e->getMessage(),
                'order_id' => $order->id
            ]);
            return null;
        }
    }

    /**
     * Get Payment Status
     */
    public function getPaymentStatus(string $orderReference): ?array
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept' => 'application/vnd.ni-payment.v2+json'
            ])->get(
                $this->apiUrl . '/transactions/outlets/' . $this->outletReference . '/orders/' . $orderReference
            );

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('N-Genius Get Payment Status Exception', [
                'message' => $e->getMessage(),
                'reference' => $orderReference
            ]);
            return null;
        }
    }

    /**
     * Process Payment Callback
     */
    public function processCallback(string $orderReference): bool
    {
        $paymentData = $this->getPaymentStatus($orderReference);

        if (!$paymentData) {
            return false;
        }

        $payment = Payment::where('payment_reference', $orderReference)->first();

        if (!$payment) {
            Log::error('Payment not found for reference: ' . $orderReference);
            return false;
        }

        $state = $paymentData['state'] ?? null;
        $paymentInfo = $paymentData['_embedded']['payment'][0] ?? null;

        // Update payment record
        $payment->gateway_status = $state;
        $payment->gateway_response = $paymentData;

        if ($paymentInfo) {
            $payment->payment_id = $paymentInfo['reference'] ?? null;

            $paymentState = $paymentInfo['state'] ?? null;

            switch ($paymentState) {
                case 'CAPTURED':
                case 'PURCHASED':
                    $payment->status = 'captured';
                    $payment->paid_at = now();

                    // Update order status
                    $payment->order->update([
                        'payment_status' => PaymentStatus::Paid->value
                    ]);
                    break;

                case 'FAILED':
                    $payment->status = 'failed';
                    $payment->order->update([
                        'payment_status' => PaymentStatus::Failed->value
                    ]);
                    break;

                case 'CANCELLED':
                    $payment->status = 'cancelled';
                    break;

                default:
                    $payment->status = 'processing';
                    break;
            }
        }

        $payment->save();

        return $payment->isSuccessful();
    }
}
