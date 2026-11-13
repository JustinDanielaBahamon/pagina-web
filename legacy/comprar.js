document.addEventListener('DOMContentLoaded', function() {
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
                alert("Este producto ya está en el carrito."); // Mensaje de alerta si ya existe
            } else {
                // Añadir nuevo producto al carrito
                cart.push({ name: productName, price: productPrice, quantity: 1 });
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCount();
            }
        });
    });
    

    function updateCartCount() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const totalItems = cart.reduce((total, product) => total + product.quantity, 0);
        document.getElementById('cart-count').textContent = totalItems;
    }

    updateCartCount();
});






