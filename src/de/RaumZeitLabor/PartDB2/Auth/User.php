<?php
namespace de\RaumZeitLabor\PartDB2\Auth;
declare(encoding = 'UTF-8');

/** @Entity @Table(name="users") */

class User {
	/**
	 * @Id @Column(type="integer")
	 * @GeneratedValue(strategy="AUTO")
	 * @var unknown_type
	 */
	private $id;
	
	/** @Column(length=50) */
	private $username;
	
	/** @Column(length=32) */
	private $password;
	
	/**
	 * Creates a new user object.
	 * 
	 * @param string $username		The username to set (optional)
	 * @param string $password		The password to set (optional)
	 */
	public function __construct ($username = null, $password = null) {
		if ($username !== null) {
			$this->setUsername($username);
		}
		
		if ($password !== null) {
			$this->setPassword($password);
		}
	}
	/**
	 * Sets the username.
	 * 
	 * Forces the username to have
	 * lowercase a-z characters. 
	 * 
	 * Replaces space with an underscore.
	 * 
	 * @param string $username	The username to set. Applies automatic username modification.
	 * @return nothing
	 */
	public function setUsername ($username) {
		$username = strtolower($username);
		
		
		preg_match_all("/[a-z\s]+/", $username, $out);
		$username = implode('', $out[0]);
		
		$username = str_replace(" ", "_", $username);
		
		$this->username = $username;
		
	}
	
	/**
	 * Sets the raw username, without replacing any special chars.
	 * 
	 * This method should only be used for building a temporary user
	 * for login checks.
	 *
	 * @param string $username	The raw username
	 * @return nothing
	 */
	public function setRawUsername ($username) {
		$this->username = $username;
	}
	
	/**
	 * Returns the username.
	 * @param none
	 * @return string The username
	 */
	public function getUsername () {
		return $this->username;
	}
	
	/**
	 * Sets the user's password. Automatically
	 * applies md5 hashing.
	 * 
	 * @param string $password
	 */
	public function setPassword ($password) {
		$this->setHashedPassword(md5($password));
	}
	
	/**
	 * Returns the user's md5-hashed password.
	 * @param none
	 * @return string The md5-hashed password
	 */
	public function getHashedPassword () {
		return $this->password;
	}
	
	/**
	 * Sets the user's password. Expects a hash
	 * and does not apply md5 hasing.
	 * 
	 * @param string $hashedPassword
	 */
	public function setHashedPassword ($hashedPassword) {
		$this->password = $hashedPassword;
	}
	
	/**
	 * Compares the given un-hashed password with the
	 * object's hashed password.
	 * 
	 * 
	 * @param string	$password	The unhashed password
	 * @return boolean	true if the passwords match, false otherwise
	 */
	public function comparePassword ($password) {
		return $this->compareHashedPassword(md5($password));
	}
	
	/**
	 * Compares the given hashed password with the object's
	 * hashed password.
	 *
	 * @param string	$hashedPassword	The md5-hashed password
	 * @return boolean	true if the passwords match, false otherwise
	 */
	public function compareHashedPassword ($hashedPassword) {
		if ($hashedPassword == $this->password) {
			return true;
		} else {
			return false;
		}
	}
	
}
?>