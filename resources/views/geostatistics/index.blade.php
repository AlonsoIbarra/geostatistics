@extends('layouts.main')

@section('content')
        <div>

                <!-- If success show alert -->
                @if ( session( 'success' ) )
                        <div class="alert alert-success alert-dismissible" role="alert">
                                Registro actualizado con éxito.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                @endif
                <!-- If has errors show alert -->
                @if ( $errors->any() )
                        <div class="alert alert-danger" role="alert">
                                <ul>
                                @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                        </div>
                @endif
                <h1>Catalogo geográfico INEGI 2020</h1>
                <a href="{{ url()->current().'?sync=1' }}" class="btn btn-light"><i class="fas fa-sync"></i></a> 
                <table id="dataTable" class="table">
                        <thead>
                        <tr>
                                <th>Clave de localidad</th>
                                <th>Nombre</th>
                                <!-- Add more columns as needed -->
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($states as $state)
                                <tr data-json="{{ $state->toJson() }}" id="row_{{ $state->id }}">
                                        <td>{{ $state->cvegeo }}</td>
                                        <td>{{ $state->nom_agee }}</td>
                                        <!-- Add more columns as needed -->
                                </tr>
                        @endforeach
                        </tbody>
                </table>
        </div>

        <!-- Bootstrap Modal -->
        <div class="modal fade show" id="stateModal" tabindex="-1" aria-labelledby="stateModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <h5 class="modal-title" id="stateModalLabel">Detalle</h5>
                                        <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                                <div class="modal-body">
                                        <form method="POST" action="{{ url()->current() }}" >
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id" id="id">
                                                <div class="form-group">
                                                        <label for="cvegeo">Clave de localidad</label>
                                                        <input type="text" class="form-control" id="cvegeo" name="cvegeo" aria-describedby="cvegeo" placeholder="Clave de localidad">
                                                </div>
                                                <div class="form-group">
                                                        <label for="cve_agee">Clave de AGEE</label>
                                                        <input type="text" class="form-control" id="cve_agee" name="cve_agee" aria-describedby="cve_agee" placeholder="Clave de AGEE">
                                                </div>
                                                <div class="form-group">
                                                        <label for="nom_agee">Nombre</label>
                                                        <input type="text" class="form-control" id="nom_agee" name="nom_agee" aria-describedby="nom_agee" placeholder="Nombre">
                                                </div>
                                                <div class="form-group">
                                                        <label for="nom_abrev">Nombre abreviado</label>
                                                        <input type="text" class="form-control" id="nom_abrev" name="nom_abrev" aria-describedby="nom_abrev" placeholder="Nombre abreviado">
                                                </div>
                                                <div class="form-group">
                                                        <label for="pob">Población</label>
                                                        <input type="number" class="form-control" id="pob" name="pob" aria-describedby="pob" placeholder="Población">
                                                </div>
                                                <div class="text-center mt-2">
                                                         <button type="submit" class="btn btn-primary">Guardar</button>
                                                </div>
                                        </form>
                                </div>
                        </div>
                </div>
        </div>

@endsection

@section('script')
        <script>
                $(document).ready(function () {
                        const objectFields = [
                                'id',
                                'cvegeo',
                                'cve_agee',
                                'nom_agee',
                                'nom_abrev',
                                'pob',
                        ];
                        const table = $('#dataTable').DataTable();
                        $('#dataTable tbody').on('click', 'tr', function () {
                                const rowObject = $(this).data('json');

                                $.each(
                                        objectFields,
                                        function( index, field ) {
                                                let component = $("#"+field);
                                                component.val(rowObject[field]);
                                        }
                                );

                                $('#stateModal').modal('show');
                        });
                });
        </script>
@endsection