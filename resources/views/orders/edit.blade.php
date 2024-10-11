<style>
    .gradient-background {
        background: linear-gradient(135deg, #6a0dad, #ffeb3b, #2196f3);
        color: white;
        padding: 20px;
        border-radius: 10px;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.8);
        color: #333;
    }

    .btn-primary {
        background-color: #6a0dad;
        border-color: #6a0dad;
    }

    .btn-secondary {
        background-color: #ffeb3b;
        border-color: #ffeb3b;
        color: #333;
    }
</style>

<div class="container gradient-background">
    <h2>Editar Estado de la Orden #{{ $order->id }}</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="status">Estado de la Orden</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="processed" {{ $order->status === 'processed' ? 'selected' : '' }}>Procesada</option>
                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Enviada</option>
                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Entregada</option>
                <option value="canceled" {{ $order->status === 'canceled' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar Estado</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Volver</a>
    </form>
</div>