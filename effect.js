document.addEventListener("DOMContentLoaded", function() {
    const flowerImage = document.createElement('img');
    flowerImage.src = 'path/to/your-flower-image.png';
    flowerImage.className = 'flower';
    document.getElementById('hero').appendChild(flowerImage);
});
