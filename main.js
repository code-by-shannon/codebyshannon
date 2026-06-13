const nextBtn = document.querySelector('.next');
const prevBtn = document.querySelector('.prev');
const band_carousel = document.getElementById('band-carousel');

nextBtn.addEventListener('click', nextSlide);
prevBtn.addEventListener('click', prevSlide);

let current = 0;
const slides = document.querySelectorAll('.slide');

function showSlide(index){
  slides.forEach(s => s.classList.remove('active'));
  slides[index].classList.add('active');
}

function nextSlide(){
  current = (current + 1) % slides.length;
  showSlide(current);
}

function prevSlide(){
  current = (current - 1 + slides.length) % slides.length;
  showSlide(current);
}

setInterval(nextSlide, 10000);

band_carousel.addEventListener('click', () => 
    window.location.href = 'https://localstageweb.com');