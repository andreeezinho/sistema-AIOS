<?php

namespace App\Services\Pagamento;

use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

class PagamentoService {
    
    private $client;
    private $request_options;

    public function __construct(){
        MercadoPagoConfig::setAccessToken("APP_USR-3294321174722593-072420-2dfc4d1f81aa12110063e7b743ae0494-2577048617");
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

        $this->client = new PaymentClient();
        $this->request_options = new RequestOptions();
    }

    public function requestPayment(float $price, string $os_uuid, string $client_mail){

        try{

            $request = [
                "payment_method_id" => "pix",
                "transaction_amount" => $price,
                "description" => "Pagamento referente aos serviços de Andrezinho Informática",
                "external_reference" => $os_uuid,
                "payer" => [
                    "email" => $client_mail,
                ],
                "statement_descriptor" => "Andrézinho Informática",
                //"notification_url" => "https://seusite.com.br/webhook/mercadopago"
            ];

            $this->request_options->setCustomHeaders(["X-Idempotency-Key: " . uniqid()]);

            $payment = $this->client->create($request, $this->request_options);
            
            return [
                'id_pix' => $payment->id,
                'status' => $payment->status,
                'qr_code' => $payment->point_of_interaction->transaction_data->qr_code_base64,
                'codigo' => $payment->point_of_interaction->transaction_data->qr_code
            ];

        }catch(MPApiException $e) {
            echo "Status do PIX: " . $e->getApiResponse()->getStatusCode() . "\n";
            echo "Content: ";
            var_dump($e->getApiResponse()->getContent());
            echo "\n";
            return null;
        }catch(\Exception $e) {
            echo $e->getMessage();
            return null;
        }

    }

}