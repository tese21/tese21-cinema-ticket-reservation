// Ensure the DOM is fully loaded before executing any script
document.addEventListener('DOMContentLoaded', function () {
    // Select all the schedule item dates
    const scheduleItems = document.querySelectorAll('.schedule-item');
    const scheduleDates = document.querySelector('.schedule-dates');

    // Add click event to each date to select and highlight it
    scheduleItems.forEach(item => {
        item.addEventListener('click', function () {
            // Remove selected class from all schedule items
            scheduleItems.forEach(i => i.classList.remove('schedule-item-selected'));
            // Add selected class to the clicked item
            this.classList.add('schedule-item-selected');
            updateSchedule(this.textContent); // Update schedule when a new date is selected
        });
    });

    // Function to update the movie schedule based on the selected date
    function updateSchedule(selectedDate) {
        const allRows = document.querySelectorAll('.schedule-table tr');

        // Iterate over all schedule rows and show or hide based on the selected date
        allRows.forEach(row => {
            const movieDate = row.querySelector('td:first-child p');
            if (movieDate && movieDate.textContent.includes(selectedDate)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Highlight the current date when the page loads
    const currentDate = new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
    const currentDateElement = Array.from(scheduleItems).find(item => item.textContent === currentDate);
    if (currentDateElement) {
        currentDateElement.classList.add('schedule-item-selected');
        updateSchedule(currentDate);
    }

    // Movie Details Modal (Pop-up when clicking 'Details')
    const detailButtons = document.querySelectorAll('.schedule-item.details-button');
    detailButtons.forEach(button => {
        button.addEventListener('click', function () {
            const movieTitle = this.closest('td').querySelector('h2').textContent;
            const movieSynopsis = this.closest('td').querySelector('p').textContent;
            showMovieDetails(movieTitle, movieSynopsis);
        });
    });

    // Function to show the movie details in a modal
    function showMovieDetails(title, synopsis) {
        const modal = document.createElement('div');
        modal.classList.add('modal');
        modal.innerHTML = `
            <div class="modal-content">
                <h2>${title}</h2>
                <p>${synopsis}</p>
                <button id="closeModal">Close</button>
            </div>
        `;
        document.body.appendChild(modal);

        // Close modal when 'Close' button is clicked
        document.getElementById('closeModal').addEventListener('click', function () {
            modal.remove();
        });
    }
});
