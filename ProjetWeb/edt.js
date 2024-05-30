document.addEventListener("DOMContentLoaded", function() {
    const freeCells = document.querySelectorAll(".free");
    const confirmBtn = document.getElementById("confirm-btn");
    let selectedCell = null;

    freeCells.forEach(cell => {
        cell.addEventListener("click", function() {
            if (selectedCell) {
                selectedCell.classList.remove("selected");
            }
            selectedCell = cell;
            cell.classList.add("selected");
            confirmBtn.classList.add("visible");

            // Get the selected day and hour
            const day = cell.cellIndex;
            const hour = cell.parentElement.firstChild.textContent;
            document.getElementById("selected-day").value = day;
            document.getElementById("selected-hour").value = hour;
        });
    });

    confirmBtn.addEventListener("click", function() {
        if (selectedCell) {
            document.getElementById("rdv-form").submit();
        }
    });
});