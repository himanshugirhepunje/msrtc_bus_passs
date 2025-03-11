document.getElementById('paymentForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
    
    // Get values from the form
    const upi = document.getElementById('upi').value;
    const card = document.getElementById('card').value;
    const netBanking = document.getElementById('netBanking').value;
    
    // Validate form fields (ensure at least one payment method is selected)
    if (!upi && !card && !netBanking) {
        alert("Please provide at least one payment method.");
        return;
    }
    
    // Display a confirmation message
    document.getElementById('responseMessage').textContent = 'Payment information submitted successfully!';
});
