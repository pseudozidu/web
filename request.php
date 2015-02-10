<?php

require_once "slave.php";

class Request {
	
	public $sock;
	
	public function createSocket($address = "127.0.0.1", $port = "1335", $password = "PWD") {
		$this->sock = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		
		socket_connect($this->sock, $address, $port);
		$error = socket_strerror(socket_last_error($this->sock));
		if (strpos($error, "successfully") === false) {
			return " Error: " . $error;
		}
				
		$this->write(sha1($password));		
		
		return "";
	}
	
	public function getSlaves() {
		$this->write(1);
		$raw = socket_read($this->sock, 1024 * 10, PHP_NORMAL_READ) or die("Could not read from socket\n");
		
		$slaveStrings = explode(";", $raw);
		$slaves = array();
		
		foreach ($slaveStrings as $string) {
			if (strlen($string) <= 1) {
				continue;
			}

			$s = new Slave();
			$s->makearray($string);
			array_push($slaves, $s);
		}
		
		return $slaves;
	}
	
	public function getCountryStats() {
		$this->write( 12);
		$raw = socket_read($this->sock, 1024 * 10, PHP_NORMAL_READ) or die("Could not read from socket\n");
		
		$rawStrings = explode(";", $raw);
		$countries = array();
		
		foreach ($rawStrings as $string) {
			if (strlen($string) <= 1) {
				continue;
			}
		
			$split = explode(",", $string);
			$countries[$split[0]] = $split[1];
		}
		
		return $countries;
	}
	
	public function getOperatingSystemStats() {
		$this->write(13);
		$raw = socket_read($this->sock, 1024 * 10, PHP_NORMAL_READ) or die("Could not read from socket\n");
	
		$rawStrings = explode(";", $raw);
		$os = array();
	
		foreach ($rawStrings as $string) {
			if (strlen($string) <= 1) {
				continue;
			}
	
			$split = explode(",", $string);
			$os[$split[0]] = $split[1];
		}
	
		return $os;
	}

	
	public function disconnect() {
		$this->write(-1);
		socket_close($this->sock);
	}
	
	public function write($s) {
		socket_write($this->sock, $s . "\n", strlen($s) + 1) or die("Failed to write to socket\n");
	}
	
 	public function isError() {
 		return strpos($this->sock, "Error") == 1;
 	}
}