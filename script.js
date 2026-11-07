let images = [
    "images/scene1.jpg",
    "images/parking1.jpg",
    "images/garage.webp",
    "images/scene2.jpg",
    "images/night-runners_gameplay.jpg"
];

let titles = [];
let StartImage = 0;

function showImage()
{
    document.getElementById("slider-image").src = images[StartImage];
    document.getElementById("slider-title").textContent = titles[StartImage];
    document.getElementById("slider-count").textContent = (StartImage + 1) + " 
	/ " + images.length;
}

function nextImage()
{
    StartImage++;
    if (StartImage >= images.length)
    {
        StartImage = 0;
    }
    showImage();
}

function prevImage()
{
    StartImage--;
    if (StartImage < 0)
    {
        StartImage = images.length - 1;
    }
    showImage();
}