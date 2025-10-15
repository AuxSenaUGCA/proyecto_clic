@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h2 class="mb-4">Gestión de Frases</h2>

    <div class="mb-3">
        <label for="sentenceSearch" class="form-label">Buscar Por Texto</label>
        <input type="text" id="sentenceSearch" class="form-control" placeholder="Escribe para buscar...">
        <div id="searchResults" class="list-group mt-1"></div>
    </div>

    <!-- Botones -->
    <div class="d-flex gap-3 mb-4">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createSentenceModal">Crear Frase</button>
    </div>

    <!-- Modal Crear Frase -->
    <div class="modal fade" id="createSentenceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Crear Frase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sentences.store') }}" method="POST" id="sentenceForm">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" name="state_sentence">
                                <option value="active" selected>Activo</option>
                                <option value="inactive">Inactivo</option>
                            </select>
                        </div>

                        <!-- Cubos -->
                        <div class="mb-3">
                            <label class="form-label">Cubos</label>
                            <div id="cubesContainer"></div>
                            <button type="button" class="btn btn-sm btn-primary mt-2" id="addCubeBtn">Agregar Sección</button>
                        </div>

                        <input type="hidden" name="text_sentence" id="text_sentence">

                        <button type="submit" class="btn btn-success">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Actualizar Frase -->
    <div class="modal fade" id="updateSentenceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Actualizar Frase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updateSentenceForm">
                        @csrf
                        @method('PUT')

                        <input type="hidden" id="update_id_sentence" name="id_sentence">

                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select class="form-select" id="update_state_sentence" name="state_sentence">
                                <option value="active">Activo</option>
                                <option value="inactive">Inactivo</option>
                            </select>
                        </div>

                        <!-- Cubos -->
                        <div class="mb-3">
                            <label class="form-label">Cubos</label>
                            <div id="updateCubesContainer"></div>
                            <button type="button" class="btn btn-sm btn-primary mt-2" id="addCubeUpdateBtn">Agregar Sección</button>
                        </div>

                        <input type="hidden" name="text_sentence" id="update_text_sentence">

                        <button type="submit" class="btn btn-warning">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar Frase -->
    <div class="modal fade" id="deleteSentenceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Eliminar Frase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>¿Estás seguro que deseas eliminar esta frase?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" id="deleteSentenceForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="delete_id_sentence" name="id_sentence">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-5">
        <h2 class="mb-4">Frases existentes</h2>
        <div id="sentencesContainer" class="row"></div>
    </div>
</div>

<script src="{{ asset('js/cards/createCardsSentences.js') }}"></script>
<script src="{{ asset('js/inputs/DynamicInputsSentences.js') }}"></script>
<script src="{{ asset('js/searchs/searchSentences.js') }}"></script>
@endsection