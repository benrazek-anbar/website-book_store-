<?php
$con = mysqli_connect('localhost','root','','bibliotheque');

session_start();
$id_user = $_SESSION['user_id'];
if (!isset($id_user)) {
	header('location:sign_in.php');
}
if (isset($_POST['add_cart'])) {
	$name_product = $_POST['name_product'];
	$price_product = $_POST['price_product'];
	$number_product = $_POST['product-number'];
	$image_product = $_POST['image_product'];

	$check_cart = mysqli_query($con,"SELECT * FROM `cart` WHERE name = '$name_product' AND user_id = '$id_user'");
	if(mysqli_num_rows($check_cart) > 0){
		$message[] ='déjà ajouté au panier';
	}else{
		mysqli_query($con,"INSERT INTO `cart` (user_id,name,price,quantity,image) VALUES ('$id_user','$name_product','$price_product','$number_product','$image_product')");
		$message[] = 'Produit ajouté au panier';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
	<!--Link CSS-->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!--Link ICON-->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
	<!--font-->
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700;800;900;1000&family=Open+Sans:wght@300;400;500;600;700;800&family=Oswald&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:wght@300;400;500;700;900&family=Work+Sans:wght@200;300;400;500&display=swap" rel="stylesheet">
</head>
<body>
	<!--header start-->
	<?php include 'header.php';?>
	<!--header end-->
	<!--home start-->
	<section class="home">
		<div class="content-bg">
			<h1>HAND PICKED BOOK TO YOUR DOOR.</h1>
		    <p>Lorem ipsum sit amet consectetur adipisicin eit. Excepturi,quod? Reiciendis ut porro iste totam.</p><br><br>
		    <a href="#">Discover More</a>
		</div>
	</section>
	<!--home end-->
	<!--Afficher le produit start-->
	<section class="show-products">
		<h1>Latest product</h1>
		<?php
			if (isset($message)) {
				foreach ($message as $message) {
					echo '		
					    <div class="message">
				            <span>'.$message.'</span>
				            <i class="fa-sharp fa-solid fa-circle-xmark" onclick="this.parentElement.remove();"></i>
			            </div> 
			            ';
			 	}
			}
		?>
		<div class="show-content">
			<?php
			$select_products = mysqli_query($con,"SELECT * FROM `products` LIMIT 6");

			if (mysqli_num_rows($select_products) > 0) {
				while ($fetch_product = mysqli_fetch_assoc($select_products)) {
			?>
			<div class="show_information">
				<form action="" method="post">
					<div class="price_prod"><?php echo $fetch_product['price'];?><span> Dh</span></div>
					<img src="uploaded_img/<?php echo $fetch_product['image'];?>" alt="book">
					<div class="name_prod"><?php echo $fetch_product['name'];?> </div>
			        <input type="number" name="product-number" min="1" max="20" value="1" class="name_product"><br>
			        <input type="hidden" name="name_product" value="<?php echo $fetch_product['name'];?>">
			        <input type="hidden" name="price_product" value="<?php echo $fetch_product['price'];?>">
			        <input type="hidden" name="image_product" value="<?php echo $fetch_product['image'];?>">
			        <input type="submit" name="add_cart" value="Add to cart" class="btn">
				</form>
			</div>
			
			<?php
			}
			}else{
				echo "<p class='empty'>pas encore de produit ajouté</p>";
			}
			?>
		</div>
	</section>
	<!--Affiche le produit end-->
	<!--About start-->
	<section>
		<h1>About</h1>
		<div class="about-home">
		<div class="about-home-img">
			<img src="images/about-img.jpg">
		</div>
		<div class="about-home-text">
			<h2>About Us</h2>
			<p>Lorem ipsum dolor, sit amet consectetur adipisicin elit. Impedit quos enim minima ipsa officia corporis ratione ratione saepe sed adipisci?</p><br>
			<a href="about.php" class="btn" style="text-decoration: none;">Read more</a>
		</div>
	</div>
	</section>
	<!--About end-->

	<!--contact start-->
	<section >
		<div class="contact-home">
			<h1>HAVE ANY QUESTIONS?</h1>
			<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.Atque cumque exercitationem repellendus, amet ullam voluptatibus?</p><br><br>
			<a href="contact.php" class="btn" style="text-decoration:none;">Conatct US</a>
		</div>
	</section>
	<!--conatct end-->
	<!--footer start-->
	<?php include 'footer.php';?>
	<!--footer end-->

	<!--script user-->
	<script src="js/script.js"></script>
</body>
</html>