<?php
function check_auth($email, $password) {
	$db = new Database();

	$password = md5($password);
	$result = $db->get_query("SELECT * FROM users WHERE email='$email' AND password='$password'");

	if($result) {
		set_auth($result[0]['id']);
		return true;
	}

	return false;
}

function set_auth($id) {
	$_SESSION["auth"] = true;
	$_SESSION["id"] = $id;
}

function clear_auth() {
	unset($_SESSION["auth"]);
	unset($_SESSION["id"]);
}

function insert_user($name, $email, $password) {
	$db = new Database();

	$password = md5($password);
	$result = $db->set_query("INSERT INTO users (name, email, password) VALUES ('$name','$email','$password')");

	if($result) {
		set_auth();
		return $result;
	}

	return false;
}

function update_name($name) {
	$db = new Database();

	$user = get_user_data();
	$id = $user['id'];
	$result = $db->set_query("UPDATE users SET name='$name' WHERE id=$id");

	return $result;
}

function update_password($password) {
	$db = new Database();

	$user = get_user_data();
	$id = $user['id'];
	$password = md5($password);
	$result = $db->set_query("UPDATE users SET password='$password' WHERE id=$id");

	return $result;
}