<?php

namespace App\Repositories;

use App\Models\State;
use App\Services\InegiApiService;

class GeostatisticsRepository {

    public function getAllStates() {
        return State::all();
    }

    public function updateState( $stateId, $data ) {
        $state = State::find( $stateId );
        $state->fill( $data );
        return $state->save();
    }

    public function syncStatesFromAPI( InegiApiService $inegiApiService ) {
        $jsonData = $inegiApiService->makeRequest( 'GET' );
        foreach ( $jsonData as $jsonStateData ) {
            // Retrieve state using backup field.
            $state = State::where( 'cvegeo_key', $jsonStateData['cvegeo'] )->first();
            if ( $state ) {
                $changes = array_filter(
                    $state->getAttributes(),
                    function ( $modelValue, $modelKey ) use ( $jsonStateData ) {
                        // database field exists in json data.
                        if ( array_key_exists( $modelKey, $jsonStateData ) ) {
                            // parse to string because in raw always returns true.
                            if ( strval( $modelValue ) !== strval( $jsonStateData[ $modelKey ] ) ){
                                return $modelKey;
                            }

                        }
                    },
                    ARRAY_FILTER_USE_BOTH // To send key and value to callback function.
                );

                // if row has changes then update.
                if ( 0 < count( $changes ) ) {
                    $state->fill( $jsonStateData );
                    $state->save();
                }
            } else {
                state::create( $jsonStateData );
            }
        }
    }
}