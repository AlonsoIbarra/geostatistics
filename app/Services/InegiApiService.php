<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;


class InegiApiService {
    private $url;
    public function __construct( $url ) {
        $this->url = $url;
        
    }

    public function makeRequest( $method = 'GET' ) {
        if ( 'GET' == strtoupper( $method ) ) {
            try {
                $response = Http::withHeaders(
                    [
                        'Accept' => 'application/json',
                    ]
                )->get(
                    $this->url
                );
        
                return $response->json()['datos'];
            } catch (\Throwable $th) {
                throw new Exception( "Error on HTTP request. {$th->getMessage()}" , 1 );
            }
        }
        throw new Exception( "Method $method not implemented.", 1 );
        
    }
}