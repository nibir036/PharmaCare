let cartProducts = []; // Global variable to store cart items

async function loadCartForCheckout(userId) {
    try {
        const response = await fetch(`fetch_cart.php?user_id=${userId}`);
        const cartItems = await response.json();

        cartProducts = cartItems; // Save cart items globally

        const cartItemsDiv = document.getElementById("cart-items");
        const totalAmountElem = document.getElementById("total-amount");
        let total = 0;

        cartItemsDiv.innerHTML = "";

        if (cartItems.length === 0) {
            cartItemsDiv.innerHTML = "<p>Your cart is empty!</p>";
            totalAmountElem.textContent = "Total: $0.00";
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
            `;

            cartItemsDiv.appendChild(cartItem);
        });

        totalAmountElem.textContent = `Total: $${total.toFixed(2)}`;
    } catch (error) {
        console.error('Error loading cart for checkout:', error);
    }
}


async function submitOrder(event) {
    event.preventDefault();

    console.log("Submitting order...");
    const userId = sessionStorage.getItem('userId');
    const fullName = document.getElementById('full-name').value;
    const address = document.getElementById('address').value;
    const phone = document.getElementById('phone').value;
    const paymentMethod = document.getElementById('payment-method').value;

    // Prepare order details
    const orderData = {
        user_id: userId,
        full_name: fullName,
        address: address,
        phone: phone,
        payment_method: paymentMethod
    };

    console.log(orderData); // Log for debugging

    try {
        const response = await fetch('submit_order.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(orderData),
        });

        const result = await response.json();
        if (result.success) {
            alert('Order placed successfully!');
            window.location.href = 'index.html';
        } else {
            alert('There was an error placing the order. Please try again.');
        }
    } catch (error) {
        console.error('Error placing order:', error);
    }
}


// Event Listeners for Checkout Page
document.addEventListener("DOMContentLoaded", () => {
    const userId = sessionStorage.getItem('userId');
    if (userId) {
        loadCartForCheckout(userId);
    } else {
        alert("You need to be logged in to view the checkout page.");
        window.location.href = 'login.php'; // Redirect to login page
    }

    // Handle the order submission when the user clicks "Place Order"
    document.getElementById("submit-order-btn").addEventListener("click", submitOrder);
});
