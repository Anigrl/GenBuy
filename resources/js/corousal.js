    const carousel = document.getElementById('carousel');
    const left = document.getElementById('leftButton');
    const right = document.getElementById('rightButton');

    let index = 0; // Tracks the current slide
    const totalSlides = document.querySelectorAll("#carousel div").length;

    // Auto-slide every 5 seconds
    let interval = setInterval(() => {
        nextSlide();
    }, 5000);

    function updateCarousel() {
        // Moves the carousel based on the current index
        carousel.style.transform = `translateX(-${index * 100}%)`;
    }

    function nextSlide() {
        // Moves to the next slide and loops back to the first slide
        index = (index + 1) % totalSlides;
        updateCarousel();
    }

    function prevSlide() {
        // Moves to the previous slide and loops to the last slide if on the first
        index = (index - 1 + totalSlides) % totalSlides;
        updateCarousel();
    }

    right.addEventListener('click', function () {
        clearInterval(interval); // Clear auto-slide on manual action
        nextSlide();
        interval = resetInterval(); // Restart the auto-slide
    });

    left.addEventListener('click', function () {
        clearInterval(interval); // Clear auto-slide on manual action
        prevSlide();
        interval = resetInterval(); // Restart the auto-slide
    });

    function resetInterval() {
        // Resets the auto-slide interval
        return setInterval(() => {
            nextSlide();
        }, 5000);
    }
