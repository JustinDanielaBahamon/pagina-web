
document.addEventListener('DOMContentLoaded', function() {
    // Selecciona todos los botones de añadir al carrito
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productName = this.getAttribute('data-name');
            const productPrice = parseFloat(this.getAttribute('data-price'));
            
            // Obtener el carrito actual de localStorage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Verificar si el producto ya está en el carrito
            const existingProduct = cart.find(product => product.name === productName);
            
            if (existingProduct) {
                existingProduct.quantity += 1; // Aumentar la cantidad
            } else {
                // Añadir nuevo producto al carrito
                cart.push({ name: productName, price: productPrice, quantity: 1 });
            }

            // Guardar carrito actualizado en localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // Actualizar el contador del carrito
            updateCartCount();
        });
    });

    // Función para actualizar el contador de artículos del carrito
    function updateCartCount() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const totalItems = cart.reduce((total, product) => total + product.quantity, 0);
        document.getElementById('cart-count').textContent = totalItems;
    }

    // Llamar a la función para actualizar el contador al cargar la página
    updateCartCount();
});

document.addEventListener('DOMContentLoaded', function() {
    // Función para actualizar el contador de artículos del carrito
    function updateCartCount() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const totalItems = cart.reduce((total, product) => total + product.quantity, 0);
        document.getElementById('cart-count').textContent = totalItems;
    }

    // Llamar a la función para actualizar el contador al cargar la página
    updateCartCount();
});


