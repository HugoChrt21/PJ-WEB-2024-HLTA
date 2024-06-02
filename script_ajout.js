document.addEventListener("DOMContentLoaded", () => {
    const handleDrop = (dropContainer, fileInput) => {
        dropContainer.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropContainer.classList.add("drop-active");
        });

        dropContainer.addEventListener("dragenter", () => {
            dropContainer.classList.add("drop-active");
        });

        dropContainer.addEventListener("dragleave", () => {
            dropContainer.classList.remove("drop-active");
        });

        dropContainer.addEventListener("drop", (e) => {
            e.preventDefault();
            dropContainer.classList.remove("drop-active");
            fileInput.files = e.dataTransfer.files;
        });
    };

    const photoDropContainer = document.getElementById("photoDropContainer");
    const photoInput = document.getElementById("photo");
    handleDrop(photoDropContainer, photoInput);

    const cvDropContainer = document.getElementById("cvDropContainer");
    const cvInput = document.getElementById("cv");
    handleDrop(cvDropContainer, cvInput);
});