<?php

	class Usuario {
		 
		private $idusuario;
		private $deslogin;
		private $dessenha;
		private $dtcadastro;
		
		public function getIdusuario(){
			return $this->idusuario;
		}
		public function setIdusuario($value){
			$this->idusuario = $idusuario;
		}
		public function getDeslogin(){
			return $this->deslogin;
		}
		public function setDeslogin($value){
			$this->deslogin = $deslogin;
		}
		public function getDessenha(){
			return $this->dessenha;
		}
		public function setDessenha($value){
			$this->dessenha = $dessenha;
		}
		public function getDtcadastro(){
			return $this->dtcadastro;
		}
		public function setDtcadastro($value){
			$this->dtcadastro = $dtcadastro;
		}
		
		public function loadById($id){
			
			$sql = new Sql();
			
			$results = $sql->select("SELECT * FROM tb_usuarios WHERE id = :ID", array(
				":ID"=>$id
			));
			
			if(count($results) > 0) {
				
				$this->setData($results[0]);
			}
		}
		
		public static function getList(){
			
			$sql = new Sql();
			
			return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");
		}
		
		public static function search($login){
			
			$sql = new Sql();
			
			return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
				':SEARCH'=>"%" . $login . "%"
			));
		}
		
		public function login($login, $password){
			$sql = new Sql();
			
			$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
				":LOGIN"=>$login,
				":PASSWORD"=>$password
			));
			
			if(count($results) > 0) {
				
				$this->setData($results[0]);
			
			} else {
				
				throw new Exception("Login e/ou senha inválidos!");
				
			}
		}
		
		public function setData($data){
			
			$this->setIdusuario($data['id']);
			$this->setDeslogin($data['deslogin']);
			$this->setDessenha($data['dessenha']);
			//$this->setDtcadastro(new DateTime($row['dtcadastro']));
		}
		
		public function insert(){
			
			$sql = new Sql();
			
			$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
				':LOGIN'=>$this->getDeslogin(),
				':PASSWORD'=>$this->getDessenha()
			));
			
			if (count($results) > 0){
				$this->setData($results[0]);
			}
		}
		
		public function __construct($login = "", $password = ""){
			$this->setDeslogin($login);
			$this->setDessenha($password);
		}
		
		public function __toString(){
			
			return json_encode(array(
				"id"=>$this->getIdusuario(),
				"deslogin"=>$this->getDeslogin(),
				"dessenha"=>$this->getDessenha(),
				//"dtcadastro"=>$this->getDtcadastro()->format("d/m/y H:i:s"),
			));
		}
	}

?>
