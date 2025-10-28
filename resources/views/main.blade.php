@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h2 class="mb-4">Gestión de Secciones</h2>

    <div class="mb-3">
        <label for="SearchBar" class="form-label">Buscar Sección</label>
        <input type="text" id="SearchBar" class="form-control" placeholder="Escribe para buscar...">
        <div id="searchResults" class="list-group mt-1"></div>
    </div>

    <!-- Botón principal -->
    <div class="d-flex gap-3 mb-4">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createSectionModal">
            Crear Sección
        </button>
    </div>

    <!-- Contenedor de Secciones -->
    <div class="container mt-5">
        <h2 class="mb-4">Secciones Existentes</h2>
        <div id="sectionsContainer" class="row"></div>
    </div>
    <div id="paginator" class="mt-3"></div>
</div>

<!-- ============= MODALES SECCIONES ============= -->

<!-- Modal Crear Sección -->
<div class="modal fade" id="createSectionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Crear Nueva Sección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="sectionForm">

                    <div class="mb-3">
                        <label class="form-label">Nombre de la Sección</label>
                        <input type="text" class="form-control" name="name_section" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Profesor (opcional)</label>
                        <select name="id_profesor" class="form-select">
                            <option value="">-- Sin asignar --</option>
                            <!-- Puedes llenar esta lista dinámicamente -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="state_section" class="form-select">
                            <option value="active" selected>Activo</option>
                            <option value="inactive">Inactivo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Crear Sección</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Actualizar Seccion -->
<div class="modal fade" id="updateSectionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Actualizar Sección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="updateSectionForm">

                    <input type="hidden" id="update_id_section" name="id_section" value="">

                    <!-- Campos de la Sección -->
                    <div class="mb-3">
                        <label for="update_name_section" class="form-label">Nombre de la Sección</label>
                        <input type="text" class="form-control" id="update_name_section" name="name_section" required>
                    </div>

                    <div class="mb-3">
                        <label for="update_state_section" class="form-label">Estado</label>
                        <select class="form-select" id="update_state_section" name="state_section">
                            <option value="active">Activo</option>
                            <option value="inactive">Inactivo</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="update_id_profe" class="form-label">Profesor</label>
                        <select class="form-select" id="update_id_profe" name="id_profe">
                            <!-- Opciones de profesores -->
                        </select>
                    </div>

                    <!-- Sentencias Reordenables -->
                    <h6>Sentencias (arrastra para reordenar)</h6>
                    <div id="sentencesContainer" class="list-group mb-3">
                        <!-- Aquí se rellenan las sentencias dinámicamente -->
                    </div>

                    <button type="submit" class="btn btn-warning">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar Seccion -->
<div class="modal fade" id="deleteSectionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Eliminar Seccion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p>¿Estás seguro que deseas eliminar esta seccion?, se eliminaran todas las frases asociadas a esta</p>
            </div>
            <div class="modal-footer">
                <form id="deleteSectionForm">
                    <input type="hidden" id="delete_id_section" name="id_section">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ============= MODALES FRASES ============= -->

<!-- Modal Crear Frase -->
<div class="modal fade" id="createSentenceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Crear Frase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="sentenceForm">

                    <input type="hidden" id="id_section" name="id_section" value="">

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
                        <button type="button" class="btn btn-sm btn-primary mt-2" id="addCubeBtn">
                            Agregar Cubo
                        </button>
                    </div>

                    <!-- Frase completa concatenada -->
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
                <form id="updateSentenceForm">
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
                        <button type="button" class="btn btn-sm btn-primary mt-2" id="addCubeUpdateBtn">
                            Agregar Sección
                        </button>
                    </div>

                    <!-- Frase completa concatenada -->
                    <input type="hidden" name="text_sentence" id="update_text_sentence">
                    <input type="hidden" name="deleted_cubes" id="deleted_cubes">

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
                <form id="deleteSentenceForm">
                    <input type="hidden" id="delete_id_sentence" name="id_sentence">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="module" src="{{ asset('js/load/paginador.js') }}"></script>
<script type="module" src="{{ asset('js/load/loadPage.js') }}"></script>
<script type="module" src="{{ asset('js/sections/fillFieldsSections.js') }}"></script>
<script type="module" src="{{ asset('js/sentences/fillFieldsSentences.js') }}"></script>
<script type="module" src="{{ asset('js/inputs/sentences/CreateSentencesInputs.js') }}"></script>
<script type="module" src="{{ asset('js/inputs/sentences/UpdateSentencesInputs.js') }}"></script>
<script type="module" src="{{ asset('js/cards/createCardsSentences.js') }}"></script>
<script type="module" src="{{ asset('js/sections/Sections.js') }}"></script>
<script type="module" src="{{ asset('js/sentences/Sentences.js') }}"></script>
<script type="module" src="{{ asset('js/cards/createCardsSections.js') }}"></script>
<script type="module" src="{{ asset('js/searchs/searchSections.js') }}"></script>
@endsection