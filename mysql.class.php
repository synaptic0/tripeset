<?php

/*
 * Data Analysis Tool for TRIPESET 1.0 - Experiment 1
 * (C) 2017, Università degli Studi della Campania "Luigi Vanvitelli"
 * http://www.unicampania.it
 *
 * Powered by Giovanni dr. Federico
 * dev@giovannifederico.net
 * http://www.giovannifederico.net
 *
 * MySQL Connetion Class
*/

class MySQL {
	
	private $MySQL_host = "localhost";
	private $MySQL_user = "root";
	private $MySQL_pwd = "root";
	private $MySQL_db = "tripeset";
	
	
	public function Connessione() {
		$Link = mysqli_connect($this->MySQL_host, $this->MySQL_user, $this->MySQL_pwd, $this->MySQL_db) or die( mysqli_error($Link));
		return $Link;
	}
	
}

?>