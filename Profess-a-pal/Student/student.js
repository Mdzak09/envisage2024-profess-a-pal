let counter = 0;

document.addEventListener('visibilitychange', () => {
    console.log("Visibility State: ", document.visibilityState);
    console.log("Hidden: ", document.hidden);
    
    if (document.hidden) {
        counter += 1;
        
        if (counter === 1) {
            console.log("First tab change detected.");
            alert("Please make sure you don't change tabs next time, otherwise your quiz will be discarded and marked as copied.");
        }
        if (counter >= 2) {
            console.log("Multiple tab changes detected. Counter: ", counter);
            showConfirmationModal(counter);
        }
    }
});

function showConfirmationModal(counter) {
    document.getElementById('copyCounter').textContent = counter;
    document.getElementById('confirmationModal').style.display = "block";

    const confirmBtn = document.getElementById('confirmBtn');
    
    const closeWindow = function() {
        window.close();
    };

    confirmBtn.addEventListener('click', function() {
        if (counter === 2) {
            closeWindow();
        } else {
            confirmBtn.removeEventListener('click', closeWindow);
        }
    });
}
