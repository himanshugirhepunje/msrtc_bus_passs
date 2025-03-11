let currentIndex = 0;

function changeSlide(direction) {
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;

    currentIndex = (currentIndex + direction + totalSlides) % totalSlides;
    document.querySelector('.slider').style.transform = `translateX(-${currentIndex * 100}%)`;
}

// Auto slide every 3 seconds
setInterval(() => changeSlide(1), 1000); // 3000ms (3 seconds)