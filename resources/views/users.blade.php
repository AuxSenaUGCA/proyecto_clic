@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h2 class="mb-4">Gestión de Usuarios</h2>

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
                    <form method="POST" id="deleteUserForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="delete_id_user" name="id_user">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
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

</div>

<script src="{{ asset('js/cards/createCardsUsers.js') }}"></script>
<script src="{{ asset('js/searchs/searchUsers.js') }}"></script>
@endsection