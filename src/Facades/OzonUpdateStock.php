<?php

namespace Islomzoda\OzonUpdateStock\Facades;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Log;

class OzonUpdateStock extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'ozonupdatestock';
    }

    static public function  update($items){
        try {
            $client  = new Client();
            $headers = [
                'Client-Id' => config('ozonupdatestock.client_id'),
                'Api-Key' => config('ozonupdatestock.api_key'),
            ];
            $req = new Request('POST', 'https://api-seller.ozon.ru/v2/products/stocks',$headers,  json_encode($items));
            $client->sendAsync($req)->wait();
        }catch (Exception $e) {
            Log::error($e);
            return false;
        }
    }
}
