// Ensure DOM is fully loaded before running the script
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');

    // Carousel Functionality
    const carouselItems = document.querySelectorAll('.carousel-item');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    let currentIndex = 0;

    function showSlide(index) {
        console.log('showSlide called with index:', index); // Debugging line
        // Hide all slides
        carouselItems.forEach(item => item.classList.remove('active'));

        // Determine the current slide index
        if (index >= carouselItems.length) {
            currentIndex = 0;
        } else if (index < 0) {
            currentIndex = carouselItems.length - 1;
        } else {
            currentIndex = index;
        }

        console.log('Showing slide index:', currentIndex); // Debugging line
        // Show the current slide
        carouselItems[currentIndex].classList.add('active');
    }

    function plusSlides(n) {
        console.log('plusSlides called with n:', n); // Debugging line
        showSlide(currentIndex + n);
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            plusSlides(1);
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            plusSlides(-1);
        });
    }

    // Automatically change slides every 5 seconds
    setInterval(() => {
        plusSlides(1);
    }, 5000);

    // Initial display
    showSlide(currentIndex);

    // Form Submission Handling
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                console.log('Server response:', result);
                // You can handle the server response here
                // For example, redirect or show a message
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle errors here
            });
        });
    });

    // Hamburger Menu Handling
    const hamburgerToggle = document.querySelector('.hamburger-toggle');
    const navLinks = document.getElementById('nav-links');

    if (hamburgerToggle && navLinks) {
        hamburgerToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });
    }
});
