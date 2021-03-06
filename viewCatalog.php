<?php
	include('cartClass.php');
	require_once('gameClass.php');
	require_once('action.php');
	session_start();
	//session_destroy();
	$action = new Action();
	$cart = new Cart();
	$gameList = $action->showGameList();

	if(isset($_POST['add'])){
		$gameId = $_POST['gameId'];
		$gameName = $_POST['gameName'];
		$gameQuantity = $_POST['gameQuantity'];
		$gamePrice = $_POST['gamePrice'];
		$gameTotal = $gameQuantity * $gamePrice;
		$cart->setGameId($gameId);
		$cart->setGameName($gameName);
		$cart->setGameQuantity($gameQuantity);
		$cart->setGamePrice($gamePrice);
		$cart->setGameTotal($gameTotal);
		if(isset($_SESSION['elemtosCarrito'])){
			$esta = false;
			foreach ($_SESSION['elemtosCarrito'] as $key => $value) {
				if ($value->getGameId()==$cart->getGameId()) {
					$esta=true;				
				}
			}
			if($esta){
				$action->alert('ya esta en el carro ese juego');
			}else{
				$_SESSION['elemtosCarrito'][] = $cart;
			}
		}else{
			$_SESSION['elemtosCarrito'][] = $cart;
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Catalogo de videojuegos</title>
</head>
<body>
	<h1 id="titulo">Indie World</h1>
		<ul id="menu">
			<li><a href="">Inicio</a></li>
			<li><a href="">Iniciar sesión</a></li>
			<li><a href="cart.php?view">Carrito</a></li>
		</ul>
	<?php foreach ($gameList as $game) { ?>
		<div style="margin: 10px; border: 1px black solid;">
			<form action="" method="post">
				<div>
					<input readonly type="hidden" name="gameId" value="<?php echo $game->getidGame();?>">
				</div>
				<div>
					<?php echo '<img width="200" src="data:image;base64,'.base64_encode($game->getportada() ).' "/>'; ?>
				</div>
				<div>
					<input type="text" name="gameName" value="<?php echo $game->getGameName();?>">
				</div>
				<div>
					<input readonly type="text" name="gamePrice" value="<?php echo $game->getprecio(); ?>">
				</div>
				<div><input type="number" min="1" name="gameQuantity" value="1"></div>
				<div><input type="submit" name="add" value="Añadir"></div>
			</form>
		</div>
	<?php }?>
</body>
</html>