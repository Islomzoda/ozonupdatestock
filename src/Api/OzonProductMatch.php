<?php
namespace Islomzoda\OzonUpdateStock\Api;
use Exception;
use GuzzleHttp\Client ;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Islomzoda\OzonUpdateStock\Import\OzonAliasImport;
use Maatwebsite\Excel\Facades\Excel;

class OzonProductMatch
{
    public  function getMath(){
    try{
        $count = 0;
        $items = [];
        $header = [
            'Client-Id' => config('ozonupdatestock.client_id'),
            'Api-Key' => config('ozonupdatestock.api_key'),
        ];
        do{
            $count += 100;
            $client = new Client();

            $body = '{
              "filter": {},
              "limit": "'.$count.'"
            }';
            $request = new Request('POST',  'https://api-seller.ozon.ru/v3/product/info/stocks', $header, $body);
            $res = $client->sendAsync($request)->wait();
            $result = json_decode($res->getBody(), true)['result']['items'];
            $items = [...$items, ...$result];
        }while(count($result) >= 99);
        foreach($items as $item){
            DB::table('ozon_match')->where('offer_id', $item['offer_id'])->update(['product_id' => $item['product_id']]);
        }
    }catch (Exception $e){
        \Illuminate\Support\Facades\Log::info(__METHOD__, (array)$e);
    }
    }
    public function uploadAlias(){
        try {
            return Excel::import(new OzonAliasImport, storage_path('app/asset/alias.xlsx'));
        }catch(Exception $e){
            Log::error(__METHOD__, (array)$e);
        }

    }
}
