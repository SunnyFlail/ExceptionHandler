document.addEventListener("click", (event) => {
    if (event.target.classList.contains("button__expand")) {
        const panelId = event.target.dataset.toggleId;
        document.getElementById(panelId).classList.toggle("expanded");
    }
})