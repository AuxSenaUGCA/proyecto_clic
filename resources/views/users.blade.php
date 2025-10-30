@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/users/race.css') }}">

@section('content')
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Gestión de Usuarios</h2>
        <div class="d-flex justify-content-between align-items-center gap-4">
            <form id="clearDataForm">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash3"></i> Limpiar Datos
                </button>
            </form>
            <form id="truncateDataForm">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash3"></i> Eliminar Usuarios
                </button>
            </form>
        </div>
    </div>

    <!-- Barra de búsqueda -->
    <div class="mb-3">
        <label for="userSearch" class="form-label">Buscar Usuario</label>
        <input type="text" id="userSearch" class="form-control" placeholder="Buscar por nombre...">
        <div id="searchResults" class="list-group mt-1"></div>
    </div>

    <!-- Modal Eliminar Usuario -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Eliminar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>¿Estás seguro que deseas eliminar este usuario?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteUserForm">
                        <input type="hidden" id="delete_id_user" name="id_user">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Limpiar Datos de Usuario -->

    <div class="modal fade" id="clearUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Limpiar datos de usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p>¿Estás seguro que desea limpiar los datos de este usuario?</p>
                </div>
                <div class="modal-footer">
                    <form id="clearUserForm">
                        <input type="hidden" id="clear_id_user" name="id_user">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Limpiar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor de usuarios -->
    <div class="container mt-5">
        <h2 class="mb-4">Usuarios Registrados</h2>
        <div id="usersContainer" class="row"></div>
    </div>

    <div class="race-container mt-5">
        <h2 class="mb-4">Carrera de Usuarios</h2>
        <div id="raceTrack"></div>
    </div>

</div>

<script type="module" src="{{ asset('js/load/loadUsers.js') }}"></script>
<script type="module" src="{{ asset('js/cards/createCardsUsers.js') }}"></script>
<script type="module" src="{{ asset('js/cards/createRaceUsers.js') }}"></script>
<script type="module" src="{{ asset('js/users/fillFieldsUsers.js') }}"></script>
<script type="module" src="{{ asset('js/users/Users.js') }}"></script>
<script type="module" src="{{ asset('js/searchs/searchUsers.js') }}"></script>
@endsection