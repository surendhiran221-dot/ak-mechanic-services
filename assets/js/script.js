// AK MECHANIC SERVICES - Client Side Logic

document.addEventListener('DOMContentLoaded', function() {
    console.log("AK Mechanic Services Website Loaded Successfully!");

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Form Validation (Simple)
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            const phone = document.getElementById('phone').value;
            if (phone.length < 10) {
                alert("Please enter a valid 10-digit mobile number.");
                e.preventDefault();
            }
        });
    }
});
