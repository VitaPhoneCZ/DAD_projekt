document.addEventListener("DOMContentLoaded", () => {
    const reviews = document.querySelectorAll(".review-card");
    let index = 0;

    function showReview() {
        reviews.forEach((review, i) => {
            if (i === index) {
                review.style.opacity = "1";
                review.style.transform = "scale(1)"; // Zvětšení při příchodu
                review.style.transition = "transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1), opacity 0.5s ease-out"; // Plynulejší efekt
            } else {
                review.style.opacity = "0";
                review.style.transform = "scale(0.9)"; // Mírné zmenšení
                review.style.transition = "transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1), opacity 0.5s ease-out"; // Plynulejší efekt
            }
        });
        index = (index + 1) % reviews.length;
    }

    showReview();
    setInterval(showReview, 2000); // Interval pro rychlejší změnu recenzí (2s)
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
