document.addEventListener('DOMContentLoaded', () => {
    const circle = document.querySelector('.boutton');
    const overlay = document.getElementById('overlay');
    const closeButton = document.getElementById('close-button');

    circle.addEventListener('click', () => {
        overlay.style.display = 'flex';
    });

    closeButton.addEventListener('click', () => {
        overlay.style.display = 'none';
    });
});


function toggleContent(id) {
    var content = document.getElementById(id);
    if (content.classList.contains('open')) {
        content.classList.remove('open');
        content.style.maxHeight = null;
    } else {
        var allContents = document.querySelectorAll('.content');
        allContents.forEach(function (item) {
            item.classList.remove('open');
            item.style.maxHeight = null;
        });
        content.classList.add('open');
        content.style.maxHeight = content.scrollHeight + "px";
    }
}