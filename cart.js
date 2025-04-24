// Function to remove item from cart
async function removeItem(cartId, userId) {
    try {
        const response = await fetch('rmv_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ cart_id: cartId }), // Send cart_id to the server
        });

        const result = await response.json();
        if (result.success) {
            alert('Item removed from cart.');
            loadCart(userId); // Reload cart after removing the item
        } else {
            console.error('Failed to remove item:', result.message);
        }
    } catch (error) {
        console.error('Error removing item:', error);
    }
}

// Function to load the cart
async function loadCart(userId) {
    try {
        const response = await fetch(`fetch_cart.php?user_id=${userId}`);
        const cartItems = await response.json();

        const cartList = document.getElementById("cart-list");
        const cartTotal = document.getElementById("cart-total");
        let total = 0;

        cartList.innerHTML = "";

        if (cartItems.length === 0) {
            cartList.innerHTML = "<p>Your cart is empty!</p>";
            cartTotal.textContent = "$0.00";
            return;
        }

        cartItems.forEach((item) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            const cartItem = document.createElement("div");
            cartItem.classList.add("cart-item");

            cartItem.innerHTML = `
                <div>
                    <h4>${item.name}</h4>
                    <p>$${item.price.toFixed(2)} each</p>
                    <p>Quantity: ${item.quantity}</p>
                </div>
                <button class="remove-item-btn" data-id="${item.id}">Remove</button>
            `;

            cartList.appendChild(cartItem);
        });

        cartTotal.textContent = `$${total.toFixed(2)}`;
    } catch (error) {
        console.error('Error loading cart:', error);
    }
}

// Event Listeners
document.addEventListener("DOMContentLoaded", () => {
    const userId = sessionStorage.getItem('userId');
    if (!userId) {
        alert('You are not logged in. Please log in to view your cart.');
        return;
    }

    loadCart(userId);

    // Delegate event to the cart list for dynamically added buttons
    document.getElementById("cart-list").addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-item-btn")) {
            const cartId = e.target.dataset.id; // Get cart ID from button
            if (cartId) {
                removeItem(cartId, userId);
            } else {
                console.error('Cart ID not found on button.');
            }
        }
    });

    // Checkout button
    document.getElementById("checkout-btn").addEventListener("click", () => {
        alert("Proceeding to checkout...");
        // Placeholder: Add checkout logic
    });
});
