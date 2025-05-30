// Ensure the DOM is fully loaded before attaching event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Optional: Add event listener for the "Add Item" button if it’s not already using onclick
    const addItemButton = document.getElementById('add-item');
    if (addItemButton) {
        addItemButton.addEventListener('click', openAddPopup);
    }
});

// Function to open the pop-up
function openAddPopup() {
    const popup = document.getElementById('add_Popup_Form');
    if (popup) {
        popup.style.display = 'block';
    }
}

// Function to close the pop-up
function closeAddPopup() {
    const popup = document.getElementById('add_Popup_Form');
    if (popup) {
        popup.style.display = 'none';
    } else {
        console.error('Popup form not found. Check the ID in your HTML.');
    }
}