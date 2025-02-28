const track = document.querySelector('.carousel-track');
const prevBtn = document.querySelector('.prev');

const items = document.querySelectorAll('.carousel-item');

let currentIndex = 0;
const itemWidth = items[0].offsetWidth + 20; // Adjust for larger images (with margin)

const totalImages = 6; // Number of images to display at once

// Function to move carousel
const moveCarousel = (index) => {
    track.style.transform = `translateX(-${index * itemWidth}px)`;
};

// Next button functionality
nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % items.length;
    moveCarousel(currentIndex);
});

// Previous button functionality
prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + items.length) % items.length;
    moveCarousel(currentIndex);
});



// Dark Mode Toggle
// Dark Mode Toggle
// Dark Mode Toggle
$(document).ready(function () {
    $('#dark-mode-toggle').click(function () {
        $('body').toggleClass('dark-mode'); // Toggle dark mode class on body
        $('#future').toggleClass('dark-mode'); // Toggle dark mode for future section
        $('#features').toggleClass('dark-mode'); // Toggle dark mode for features section

        // Toggle dark mode styles for specific elements
        $('header').toggleClass('dark-mode');
        $('header nav ul li a').toggleClass('dark-mode');
        $('.nav-icons i').toggleClass('dark-mode');
        $('footer').toggleClass('dark-mode');
        $('.footer-links a').toggleClass('dark-mode');
        $('.social-icon').toggleClass('dark-mode');
        $('.marquee-box').toggleClass('dark-mode'); // Add dark mode to marquee box
    });

    // Optional: Make dark mode persistent using localStorage
    if (localStorage.getItem('darkMode') === 'enabled') {
        $('body').addClass('dark-mode');
        $('#future').addClass('dark-mode'); // Add dark mode to future section
        $('#features').addClass('dark-mode'); // Add dark mode to features section
        $('header').addClass('dark-mode');
        $('header nav ul li a').addClass('dark-mode');
        $('.nav-icons i').addClass('dark-mode');
        $('footer').addClass('dark-mode');
        $('.footer-links a').addClass('dark-mode');
        $('.social-icon').addClass('dark-mode');
        $('.marquee-box').addClass('dark-mode'); // Add dark mode to marquee box
    }

    // Save dark mode preference
    $('#dark-mode-toggle').click(function () {
        if ($('body').hasClass('dark-mode')) {
            localStorage.setItem('darkMode', 'enabled');
        } else {
            localStorage.setItem('darkMode', 'disabled');
        }
    });
});
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');


function updateButtons() {
    if (currentIndex === 0) {
        prevButton.style.visibility = 'hidden'; // Hide prev button if at the first slide
    } else {
        prevButton.style.visibility = 'visible';
    }

    if (currentIndex === items.length - 1) {
        nextButton.style.visibility = 'hidden'; // Hide next button if at the last slide
    } else {
        nextButton.style.visibility = 'visible';
    }
}

// Move the carousel to the specified index
function moveCarousel(index) {
    const slideWidth = items[0].getBoundingClientRect().width;
    track.style.transform = `translateX(-${slideWidth * index}px)`;
    currentIndex = index;
    updateButtons();
}

// Event listeners for buttons
prevButton.addEventListener('click', () => {
    if (currentIndex > 0) {
        moveCarousel(currentIndex - 1);
    }
});

nextButton.addEventListener('click', () => {
    if (currentIndex < items.length - 1) {
        moveCarousel(currentIndex + 1);
    }
});

// Initial setup
updateButtons();
