
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Crear Producto</title>
    <style>
        .preview {
            position: relative;
            display: inline-block;
        }

        .preview img {
            max-width: 100%;
            max-height: 200px;
        }

        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Registro de Producto</h2>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="description" name="description" required maxlength="15">
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Precio</label>
                <input type="number" class="form-control" id="price" name="price" required step="0.01" min="0">
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" required min="0">
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Imagen</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                <div class="preview mt-3">
                    <img id="imagePreview" src="#" alt="Vista previa de la imagen" style="display: none;">
                    <button type="button" class="remove-image" onclick="removeImage()" style="display: none;">X</button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Suscribete</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const image = document.getElementById('imagePreview');
            const removeBtn = document.querySelector('.remove-image');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    image.src = e.target.result;
                    image.style.display = 'block';
                    removeBtn.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            const imageInput = document.getElementById('image');
            const image = document.getElementById('imagePreview');
            const removeBtn = document.querySelector('.remove-image');

            imageInput.value = '';
            image.src = '#';
            image.style.display = 'none';
            removeBtn.style.display = 'none';
        }
    </script>
</body>
</html>
