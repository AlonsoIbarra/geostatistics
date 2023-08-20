<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Repositories\GeostatisticsRepository;
use App\Services\InegiApiService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GeostatisticsController extends Controller {

    public function index( Request $request, GeostatisticsRepository $geostatisticsRepository ) {
        $sync = $request->query( 'sync', false );

        if ( $sync ) {
            $inegiApiService = app(InegiApiService::class);
            $geostatisticsRepository->syncStatesFromAPI( $inegiApiService );
        }

        $states = $geostatisticsRepository->getAllStates();

        return view(
            'geostatistics.index',
            [
                'states' => $states
            ]
        );
    }

    public function update( Request $request, GeostatisticsRepository $geostatisticsRepository ) {
        $validator = Validator::make(
            $request->all(),
            [
                'id'        => [ 'required', 'integer', 'exists:states,id'],
                'cvegeo'    => [ 'required', 'string' ],
                'cve_agee'  => [ 'required', 'string' ],
                'nom_agee'  => [ 'required', 'string' ],
                'nom_abrev' => [ 'required', 'string' ],
                'pob'       => [ 'required', 'integer' ],
            ]
        );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        try {

            $data = $request->all();
            $update = $geostatisticsRepository->updateState( $data['id'], $data );

            if ( $update ) {
                return redirect( '/geostatistics' )->with('success', 'Registro actualizado con éxito');
            } else {
                return back()->withErrors(
                    [
                        'Error' => 'Ocurrio un error al actualizar registro, intente nuevamente.'
                    ]
                );

            }
        } catch (\Throwable $th) {
            return back()->withErrors(
                [
                    'Error' => $th->getMessage()
                ]
            );
        }

    }
}
