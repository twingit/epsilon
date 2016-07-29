<h2>Welcome, <?= $current_user['name'] ?>! (<a href="/users/logout">Logout</a>)</h2>

<h4><a href="/wishlists/add_page">Add Item</a></h4>

<h3>Your Wishlist</h3>

<table>
	<thead>
		<tr>
			<th>Item</th>
			<th>Added By</th>
			<th>Date Added</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($user_products as $product) { ?>
		<tr>
			<td><a href="/wishlists/show_product/<?= $product['id'] ?>"><?= $product['name'] ?></a></td>
			<td><?= $product['creator'] ?></td>
			<td><?= date('F j, Y', strtotime($product['created_at'])) ?></td>
			<?php if ($product['user_id'] == $current_user['id']) { ?>
				<td><a href="/wishlists/delete_product/<?= $product['id'] ?>">Delete</a></td>
			<?php } else { ?>
				<td><a href="/wishlists/remove_add_on/<?= $product['id'] ?>">Remove</a></td>
			<?php } ?>
		</tr>
		<?php } ?>
	</tbody>
</table>

<h3>Other Users' Wishlist</h3>

<table>
	<thead>
		<tr>
			<th>Item</th>
			<th>Added By</th>
			<th>Date Added</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($other_user_products as $product) { ?>
			<?php if ($product['user_id'] != $current_user['id']) { ?>
				<tr>
					<td><?= $product['name'] ?></td>
					<td><?= $product['creator'] ?></td>
					<td><?= date('F j, Y', strtotime($product['created_at'])) ?></td>
					<td><a href="/wishlists/add_on/<?= $product['id'] ?>">Add to My Wishlist</a></td>
				</tr>
			<?php } ?>
		<?php } ?>
	</tbody>
</table>

