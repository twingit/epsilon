<h1>Registration</h1>

<?php 

	if ($this->session->flashdata('errors')) {
		echo $this->session->flashdata('errors');
	}

	if ($this->session->flashdata('success')) {
		echo $this->session->flashdata('success');
	}

	if ($this->session->flashdata('date_error')) {
		echo $this->session->flashdata('date_error');
	}

?>

<form action="/users/register" method="post">
	<p>Name: <input type="text" name="name"></p>
	<p>Username: <input type="text" name="username"></p>
	<p>Password: <input type="password" name="password"></p>
	<p>*Password should be at least 8 characters</p>
	<p>Confirm Password: <input type="password" name="password_confirm"></p>
	<p>Date Hired: <input type="date" name="date_hired"></p>
	<p><input type="submit" value="Register"></p>
</form>

<h1>Login</h1>

<?php 

	if ($this->session->flashdata('login_error')) {
		echo $this->session->flashdata('login_error');
	}

?>

<form action="/users/login" method="post">
	<p>Username: <input type="text" name="username"></p>
	<p>Password: <input type="password" name="password"></p>
	<p><input type="submit" value="Login"></p>
</form>