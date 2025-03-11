document.addEventListener("DOMContentLoaded", function () {
    const source = document.getElementById("source");
    const destination = document.getElementById("destination");
    const date = document.getElementById("date");
    const costInput = document.getElementById("cost");
    const costDisplay = document.getElementById("costDisplay");
    const saveButton = document.getElementById("saveButton");

    const fareRate = 50; // Cost per km

    // Define distances (in km)
    const distanceChart = {
        "location a-location b": 10,
        "location a-location c": 15,
        "location b-location c": 20
    };

    function getNextMonthDate() {
        let today = new Date();
        today.setMonth(today.getMonth() + 1);
        return today.toISOString().split('T')[0]; // Format: YYYY-MM-DD
    }

    function updateCostAndDate() {
        const src = source.value.toLowerCase();
        const dest = destination.value.toLowerCase();

        if (src === dest) {
            alert("Source and Destination cannot be the same.");
            costInput.value = "";
            costDisplay.textContent = "0";
            return;
        }

        let routeKey = `${src}-${dest}`;
        let reverseKey = `${dest}-${src}`;
        let distance = distanceChart[routeKey] || distanceChart[reverseKey];

        if (distance) {
            let calculatedCost = (distance * fareRate).toFixed(2);
            costInput.value = calculatedCost;
            costDisplay.textContent = calculatedCost;
            date.value = getNextMonthDate();
        } else {
            costInput.value = "N/A";
            costDisplay.textContent = "0";
        }
    }

    source.addEventListener("change", updateCostAndDate);
    destination.addEventListener("change", updateCostAndDate);

    saveButton.addEventListener("click", function () {
        if (!date.value || !costInput.value || costInput.value === "N/A") {
            alert("Invalid selection. Please check your inputs.");
            return;
        }

        alert(`Pass details saved successfully!\nSource: ${source.value}\nDestination: ${destination.value}\nDate: ${date.value}\nCost: ₹${costInput.value}`);
    });

    // Set default values when page loads
    date.value = getNextMonthDate();
    updateCostAndDate(); // Ensure cost is calculated initially
});