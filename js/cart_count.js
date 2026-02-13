
fetch('php/cart_count.php')
    .then(response => response.json())
    .then(data => {
        document.getElementById('cart-count').textContent = data;
        console.log('Cart count updated:', data);
    })
    .catch(error => {
        console.error('Error fetching cart count:', error);
    });