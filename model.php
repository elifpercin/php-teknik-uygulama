<?php 

	Class Model{
		private $server = 'localhost';
		private $username = 'root';
		private $password = '';
		private $db;
	
		public function __construct(){
			try {
				//$this->conn = new mysqli($this->server, $this->username, $this->password, $this->db);

				$this->db = new PDO('mysql:host=127.0.0.1;dbname=record', "root", "");
    
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		

			} catch (Exception $e) {
				echo "Connection error " . $e->getMessage();
			}
		}

		public function insert($name, $email){

			$sql = "INSERT INTO kayitlar (name, email) VALUES (:name,:email)";
			$res = $this->db->prepare($sql)->execute(["name"=>$name, "email"=>$email]);

			if ($res) {
				return true;
			}else{
				return;
			}
		}

		public function fetch(){
			$data = [];

			$sql = "SELECT * FROM kayitlar";

			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $user;
		}

		public function delete($id){

			$stmt =$this->db->prepare("DELETE FROM kayitlar WHERE id = :id");
			$stmt->execute(["id"=>$id]);
				
			if ($stmt->rowCount()) {
				return true;
			}else{
				return;
			}
		}

		public function edit($id){
			$data = [];

			$query = "SELECT * FROM record WHERE `id` = '$id'";
			if ($sql = $this->db->query($query)) {
				$row = mysqli_fetch_row($sql);
				$data = $row;
			}

			return $data;
		}

		public function update($id, $name, $email){

			$sql = "UPDATE kayitlar SET name=:name, email=:email WHERE id=:id";
				$stmt= $this->db->prepare($sql);
				if($stmt->execute([
					"id"=>$id,
					"name"=>$name,
					"email"=>$email
				])){
					return true;
				}else{
					return false;
				}

			
		}
	}

 ?>
