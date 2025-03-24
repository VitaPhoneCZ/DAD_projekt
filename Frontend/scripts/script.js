document.addEventListener("DOMContentLoaded", () => {
    const reviews = document.querySelectorAll(".review-card");
    let index = 0;

    function showReview() {
        reviews.forEach((review, i) => {
            if (i === index) {
                review.style.opacity = "1";
                review.style.transform = "translateY(0)";
            } else {
                review.style.opacity = "0";
                review.style.transform = "translateY(20px)";
            }
        });
        index = (index + 1) % reviews.length;
    }

    showReview();
    setInterval(showReview, 3000);
});


    function openLightbox(img) {
        const lightbox = document.getElementById("lightbox");
        const lightboxImg = document.getElementById("lightbox-img");

        lightbox.style.display = "flex";
        lightboxImg.src = img.src;
    }

    function closeLightbox() {
        document.getElementById("lightbox").style.display = "none";
    }

