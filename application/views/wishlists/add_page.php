<h2>Create a New Wishlist Item</h2>

<p><a href="/wishlists">Home</a> | <a href="/users/logout">Logout</a></p>

<?php 

	if ($this->session->flashdata('errors')) {
		echo $this->session->flashdata('errors');
	}

?>

<form action="/wishlists/add_product" method="post">
	<p>Item/Product: <input type="text" name="name"></p>
	<p><input type="submit" value="Add"></p>
</form>