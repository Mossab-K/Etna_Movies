<?php

function add_student($login, $collection)
{
	if (login_exists($login) == 0)
	{
		$name = add_name();
		$age = add_age();
		$email = add_email();
		$phone = add_phone();

		$doc = array(
			"login" => $login,
			"name" => $name,
			"age" => intval($age),
			"email" => $email,
			"phone" => $phone,
			"rented_movies" => array()
			);
		if ($collection->insert($doc))
			echo "User registered !\n";
		else
			echo "Error try again !\n";
	}
	else
		echo "Error: Login already exists\n";
}

function add_name()
{
	echo "Name ?\n";
	$name = my_readline();
	if (preg_match("/[a-zA-Z ]+/", $name, $name_reg) && $name != "")
		return $name_reg[0];
	else 
	{
		echo "Please, type a valid Name\n";
		return add_name();
	} 
}

function add_age()
{
	echo "Age ?\n";
	$age = my_readline();
	if (is_numeric($age) && $age <= 99 && $age >= 1)
		return $age;
	else 
	{	
		echo "Please, type a valid Age\n";
		return add_age();
	} 
}

function add_email()
{
	echo "Email ?\n";
	$email = my_readline();
	$regex = "/^([a-z0-9_\.-]+\@[\da-z\.-]{3,}\.[a-z\.]{2,6})$/";
	if (preg_match($regex, $email, $email_reg) && $email != "")
		return $email_reg[0];
	else 
	{	
		echo "Please, type a valid Email\n";
		return add_email();
	} 	
}

function add_phone()
{
	echo "Phone number ?\n";
	$phone = my_readline();
	$regex = "/^0[1-9]{1}(([0-9]{2}){4})|((\s[0-9]{2}){4})|((-[0-9]{2}){4})$/";
	if ((preg_match($regex, $phone, $phone_reg) && $phone != "") &&
		(strlen($phone) == 10))
		return $phone_reg[0];
	else 
	{	
		echo "Please, type a valid Phone Number\n";
		return add_phone();
	} 
}