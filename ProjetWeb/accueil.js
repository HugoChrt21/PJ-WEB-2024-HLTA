 
var map = L.map('map').setView([48.851292238925666, 2.288565896514548], 15);

 
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

 
L.marker([48.851292238925666, 2.288565896514548]).addTo(map)
  .bindPopup('Siège de Sportify')
  .openPopup();


  $(document).ready(function () {
    var $carrousel = $('#carrousel');
    var $img = $('#carrousel img');
    var indexImg = $img.length - 1;
    var i = 0;

    $img.hide();  
    $img.eq(i).show();  

 
    function nextImage() {
        $img.eq(i).fadeOut(500);  
        i = (i + 1) % $img.length;  
        $img.eq(i).fadeIn(500);  
    }

 
    function prevImage() {
        $img.eq(i).fadeOut(500); 
        i = (i - 1 + $img.length) % $img.length; 
        $img.eq(i).fadeIn(500);  
    }

    
    $('.next').click(nextImage);
    $('.prev').click(prevImage);

    
    function slideImg() {
        setTimeout(function () {
            nextImage();  
            slideImg(); 
        }, 3000);
    }

    slideImg(); 
});