async function openAddMedicineForm() {
    const name = prompt("Enter medicine name:");
    const price = prompt("Enter price:");
    const quantity = prompt("Enter quantity:");

    if (name && price && quantity) {
        const formData = new URLSearchParams();
        formData.append('name', name);
        formData.append('price', price);
        formData.append('quantity', quantity);

        const response = await fetch('add_medicine.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString(),
        });

        const result = await response.json();
        if (result.success) {
            alert('Medicine added successfully!');
            location.reload();
        } else {
            alert(`Failed to add medicine: ${result.error}`);
        }
    }
}


async function editMedicine(medicineId) {
    const quantity = prompt("Enter new stock quantity:");
    if (quantity) {
        const response = await fetch('update_stock.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: medicineId, quantity }),
        });

        const result = await response.json();
        if (result.success) {
            alert('Stock updated successfully!');
            location.reload();
        } else {
            alert(`Failed to update stock: ${result.error}`);
        }
    }
}


async function deleteMedicine(medicineId) {
    if (confirm("Are you sure you want to delete this medicine?")) {
        const response = await fetch('delete_medicine.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: medicineId }),
        });

        const result = await response.json();
        if (result.success) {
            alert('Medicine deleted successfully!');
            location.reload();
        } else {
            alert(`Failed to delete medicine: ${result.error}`);
        }
    }
}

async function updateOrderStatus(orderId) {
    const newStatus = prompt("Enter new status for the order (e.g., 'Processing', 'Completed', 'Cancelled'):");

    if (newStatus) {
        const response = await fetch('update_order_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ order_id: orderId, status: newStatus }),
        });

        const result = await response.json();
        if (result.success) {
            alert('Order status updated successfully!');
            location.reload();
        } else {
            alert(`Failed to update order status: ${result.error}`);
        }
    }
}
