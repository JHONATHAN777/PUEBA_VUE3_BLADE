<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }
        .product-image {
            max-height: 200px;
            object-fit: cover;
        }
        .search-bar {
            margin-bottom: 30px;
        }
        .cart-summary {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <!-- Buscador -->
        <div class="col-12 search-bar">
            <input type="text" id="search" class="form-control" placeholder="Buscar producto..." onkeyup="searchProduct()">
        </div>

        <!-- Carrito -->
        <div class="col-md-3 cart-summary">
            <h5>Carrito de Compras</h5>
            <p>Número de productos: <span id="cart-count">0</span></p>
            <p>Total a pagar: $<span id="total-price">0.00</span></p>
            <button class="btn btn-success w-100" id="pay-btn">Pagar</button>
        </div>

        <!-- Productos -->
        <div class="col-md-9">
            <div class="row" id="product-list">
                @foreach($products as $product)
                <div class="col-md-4 product-card" data-title="{{ $product->name }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid product-image">
                    <h6>{{ $product->name }}</h6>
                    <p>Precio: ${{ $product->price }}</p>
                    <button class="btn btn-warning btn-sm" onclick="addToCart({{ $product->price }})">Agregar al carrito</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal para Confirmar el Pedido -->
<div class="modal fade" id="confirmOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar Pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas realizar el pedido?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="confirmOrder">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let cartCount = 0;
    let totalPrice = 0;

    function addToCart(productPrice) {
        cartCount++;
        totalPrice += productPrice;

        document.getElementById('cart-count').innerText = cartCount;
        document.getElementById('total-price').innerText = totalPrice.toFixed(2);
    }

    function searchProduct() {
        const searchValue = document.getElementById('search').value.toLowerCase();
        const products = document.querySelectorAll('.product-card');

        products.forEach(product => {
            const title = product.getAttribute('data-title').toLowerCase();
            if (title.includes(searchValue)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    }

    document.getElementById('pay-btn').addEventListener('click', () => {
        if (cartCount > 0) {
            const confirmOrderModal = new bootstrap.Modal(document.getElementById('confirmOrderModal'));
            confirmOrderModal.show();
        } else {
            alert('Tu carrito está vacío.');
        }
    });

    document.getElementById('confirmOrder').addEventListener('click', () => {
        const items = []; // Aquí debes recopilar los productos del carrito
        // Suponiendo que tienes una forma de obtener los productos en el carrito
        // Agrega los productos al arreglo `items` aquí

        // Ejemplo de producto, deberías reemplazarlo por los productos reales
        items.push({ id: 1, quantity: 1, price: 10 }); // Cambia esto según tus productos

        fetch('/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                items: items,
                total_price: totalPrice,
            }),
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error al realizar el pedido.');
            }
        })
        .then(data => {
            alert('Pedido realizado con éxito: ' + data.order_id);
            window.location.reload();
        })
        .catch(error => {
            alert('Error al realizar el pedido: ' + error.message);
        });
    });
</script>

</body>
</html>
