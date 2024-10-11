<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Órdenes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #6f42c1; /* Fondo morado */
            color: #fff; /* Color del texto */
        }

        .header {
            background: linear-gradient(to right, #ffd700, #007bff, #6f42c1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        .table {
            background-color: rgba(255, 255, 255, 0.9); /* Fondo blanco semi-transparente */
            color: #333; /* Color del texto de la tabla */
        }

        .table th, .table td {
            vertical-align: middle; /* Alinear verticalmente el contenido de las celdas */
        }

        .alert {
            margin-bottom: 20px; /* Margen para alertas */
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="header">
        <h2>Lista de Órdenes</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->status }}</td>
                    <td>
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Cancelar</button>
                        </form>

                        @if(Auth::user()->rol === 'admin')
                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">Editar Estado</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
