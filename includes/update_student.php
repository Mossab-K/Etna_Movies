<?php

function	update_student($login, $collection)
{
	if (login_exists($login) == 0)
	{
		echo "Unknown login!\n";
		return 0;
	}
	echo "What do you want to update?\n";
	$answer = my_readline();

	if ($answer == "name" || $answer == "age" ||
		$answer == "login" || $answer == "email" ||
		$answer == "phone")
	{
		$answer($login, $collection);
	}
	else
		echo $answer . "\n";
}

function	name($login, $collection) 
{
	echo "New name ?\n";
	$name = my_readline();
	if (preg_match("/[a-zA-Z ]+/", $name, $name_reg) && $name != "")
	{
		if ($collection->update(array("login" => $login), 
				array('$set' => array("name" => $name_reg[0]))))
		{
			echo "User informations modified !\n";
		}
		else
			echo "Error try again !\n";
	}
	else 
	{
		echo "Please, type a valid Name\n";
		return name($login, $collection);
	} 
}

function	age($login, $collection) 
{
	echo "New age ?\n";
	$age = my_readline();
	if (is_numeric($age) && $age <= 99 && $age >= 1)
	{
		if ($collection->update(array("login" => $login), 
				array('$set' => array("age" => $age))))
		{
			echo "User informations modified !\n";
		}
		else
			echo "Error try again !\n";
	}
	else 
	{	
		echo "Please, type a valid Age\n";
		return age($login, $collection);
	} 
}

function	phone($login, $collection) 
{
	echo "New phone ?\n";
	$phone = my_readline();
	$regex = "/^0[1-9]{1}(([0-9]{2}){4})|((\s[0-9]{2}){4})|((-[0-9]{2}){4})$/";
	if (preg_match($regex, $phone, $phone_reg))
	{
		if ($collection->update(array("login" => $login), 
				array('$set' => array("phone" => $phone_reg[0]))))
		{
			echo "User informations modified !\n";
		}
		else
			echo "Error try again !\n";
	}
	else 
	{	
		echo "Please, type a valid Phone Number\n";
		return phone($login, $collection);
	} 
}

function	email($login, $collection) 
{
	echo "New email ?\n";
	$email = my_readline();
	$regex = "/^([a-z0-9_\.-]+\@[\da-z\.-]{3,}\.[a-z\.]{2,6})$/";
	if (preg_match($regex, $email, $email_reg) && $email != "")	
	{
		if ($collection->update(array("login" => $login), 
				array('$set' => array("email" => $email_reg[0]))))
		{
			echo "User informations modified !\n";
		}
		else
			echo "Error try again !\n";
	}
	else 
	{	
		echo "Please, type a valid Email\n";
		return email($login, $collection);
	} 
}