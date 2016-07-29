<h2><?= $product['name'] ?></h2>

<p><a href="/wishlists">Home</a> | <a href="/users/logout">Logout</a></p>

<h3>Creator:</h3>
<p><?= $product['creator'] ?></p>

<h3>Adders:</h3>
<?php foreach ($adders as $adder) { ?>
	<p><?= $adder['name'] ?></p>
<?php } ?>
