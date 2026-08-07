<?php

include "includes/db_connect.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid property.");
}

$id = (int)$_GET['id'];

/* ======================================
   GET PROPERTY
====================================== */

$stmt = $conn->prepare("
    SELECT *
    FROM properties
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$property = $stmt->get_result()->fetch_assoc();

if (!$property) {
    die("Property not found.");
}

/* ======================================
   GET GALLERY IMAGES
====================================== */

$galleryStmt = $conn->prepare("
    SELECT *
    FROM property_images
    WHERE property_id = ?
    ORDER BY sort_order ASC, id ASC
");

$galleryStmt->bind_param("i", $id);
$galleryStmt->execute();

$gallery = $galleryStmt->get_result();

?>

<!doctype html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

<title>

<?= htmlspecialchars($property['title']) ?>

</title>

<link rel="stylesheet" href="css/style.css">

<link rel="stylesheet" href="css/property.css">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<!-- ================= HEADER ================= -->

<header>

<nav>

<div class="logo">

<a href="index.php">

<img
src="images/headerlogo.jpg"
class="header-logo"
alt="HopeWays Realty">

<span>HopeWays Realty</span>

</a>

</div>

<ul>

<li><a href="index.php">Home</a></li>

<li><a href="properties.php" class="active">Properties</a></li>

<li><a href="about.php">About</a></li>

<li><a href="services.php">Services</a></li>

<li><a href="contact.php">Contact</a></li>

</ul>

</nav>

</header>

<!-- ================= COVER IMAGE ================= -->

<section class="property-hero">

<img
src="<?= htmlspecialchars($property['cover_image']) ?>"
alt="<?= htmlspecialchars($property['title']) ?>">

</section>

<!-- ================= CONTENT ================= -->

<div class="container">

<h1>

<?= htmlspecialchars($property['title']) ?>

</h1>

<h2>

₱<?= number_format($property['price'],2) ?>

</h2>

<p class="location">

<i class="fas fa-location-dot"></i>

<?= htmlspecialchars($property['location']) ?>

</p>

<div class="property-badges">

<span>

<?= htmlspecialchars($property['property_type']) ?>

</span>

<span>

<?= htmlspecialchars($property['status']) ?>

</span>

</div>

<!-- ================= DETAILS ================= -->

<div class="property-details">

<div class="detail-box">

<i class="fas fa-bed"></i>

<h3><?= $property['bedrooms'] ?></h3>

<p>Bedrooms</p>

</div>

<div class="detail-box">

<i class="fas fa-bath"></i>

<h3><?= $property['bathrooms'] ?></h3>

<p>Bathrooms</p>

</div>

<div class="detail-box">

<i class="fas fa-car"></i>

<h3><?= htmlspecialchars($property['garage']) ?></h3>

<p>Garage</p>

</div>

<div class="detail-box">

<i class="fas fa-ruler-combined"></i>

<h3><?= htmlspecialchars($property['lot_area']) ?></h3>

<p>Lot Area</p>

</div>

<div class="detail-box">

<i class="fas fa-house"></i>

<h3><?= htmlspecialchars($property['floor_area']) ?></h3>

<p>Floor Area</p>

</div>

<div class="detail-box">

<i class="fas fa-couch"></i>

<h3><?= htmlspecialchars($property['furnishing']) ?></h3>

<p>Furnishing</p>

</div>

</div>

<!-- ================= GALLERY ================= -->

<section class="property-gallery">

<h2>

Property Gallery

</h2>

<div class="gallery-grid">

<?php while($image = $gallery->fetch_assoc()) { ?>

<div class="gallery-item">

<img

src="<?= htmlspecialchars($image['image_path']) ?>"

alt="<?= htmlspecialchars($property['title']) ?>">

</div>

<?php } ?>

</div>

</section>

</div>

<!-- ================= LIGHTBOX ================= -->

<div id="lightbox" class="lightbox">

<span class="close-lightbox">&times;</span>

<span class="prev-image">&#10094;</span>

<img id="lightbox-image" src="" alt="">

<span class="next-image">&#10095;</span>

</div>

<!-- ================= JAVASCRIPT ================= -->

<script>

const galleryImages=document.querySelectorAll(".gallery-item img");

const lightbox=document.getElementById("lightbox");

const lightboxImage=document.getElementById("lightbox-image");

const closeBtn=document.querySelector(".close-lightbox");

const prevBtn=document.querySelector(".prev-image");

const nextBtn=document.querySelector(".next-image");

let currentIndex=0;

function showImage(index){

lightbox.style.display="flex";

lightboxImage.src=galleryImages[index].src;

}

galleryImages.forEach((image,index)=>{

image.addEventListener("click",()=>{

currentIndex=index;

showImage(currentIndex);

});

});

nextBtn.onclick=function(){

currentIndex++;

if(currentIndex>=galleryImages.length){

currentIndex=0;

}

showImage(currentIndex);

};

prevBtn.onclick=function(){

currentIndex--;

if(currentIndex<0){

currentIndex=galleryImages.length-1;

}

showImage(currentIndex);

};

document.addEventListener("keydown",function(e){

if(lightbox.style.display==="flex"){

if(e.key==="ArrowRight"){

nextBtn.click();

}

if(e.key==="ArrowLeft"){

prevBtn.click();

}

if(e.key==="Escape"){

lightbox.style.display="none";

}

}

});

closeBtn.onclick=function(){

lightbox.style.display="none";

};

lightbox.onclick=function(e){

if(e.target===lightbox){

lightbox.style.display="none";

}

};

</script>

</body>

</html>