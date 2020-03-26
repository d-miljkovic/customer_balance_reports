<?php 
class FormHelper
{	
	public $method = "POST";
	public $action = "";

	public function __construct($method,$action){
		$this->method = $method;
		$this->action = $action;
	}

	function open_tag($name=null,$class=null){
		echo "<form name='{$name}' method='{$this->method}' action='{$this->action}' class='{$class}'>";
	}
	function close_tag(){
		echo "</form>";
	}

	function input($id=null,$type=null,$name=null,$value=null,$onClick=null,$placeholder=null,$class=null,$readonly=null){
		echo "<input id='{$id}' type='{$type}' name='{$name}' value='{$value}' onClick='{$onClick}' placeholder='{$placeholder}' class='{$class}' {$readonly}  />"; 
	}

	function textarea($id=null,$name=null,$placeholder=null,$cols=null,$rows=null){
		echo "<textarea id='{$id}' name='{$name}' placeholder='{$placeholder}' cols='{$cols}' rows='{$rows}' >";
		echo "</textarea>";
	}

	function fieldset_open($id=null){
		echo "<fieldset id='{$id}'>";
	}

	function fieldset_close(){
		echo "</fieldset>";
	}

	function legend($content=null){
		echo "<legend>{$content}</legend>";
	}




	function select($id=null,$select_name=null,$option=null,$class=null){
		echo "<select id='{$id}' name='{$select_name}' class='{$class}'>";
			foreach ($option as $key => $value) {
				echo "<option value = '{$value}'>";
				echo "{$value}";
				echo "</option>";
			}
		echo "</select>";
	}


	function selectQuery($id=null,$select_name=null,$option=null,$default=null,$class=null,$onchange=null){
		echo "<select id='{$id}' name='{$select_name}' class='{$class}' onchange='{$onchange}'>";
					echo "<option value = 'default' selected disabled hidden > - {$default} -";
			foreach ($option as $key => $value) {
				foreach ($value as $key1 => $value1) {
					echo "<option value = '{$value1}'>";
					echo "{$value1}";
				}
					echo "</option>";
			}

		echo "</select>";
	}



	function select1($onchange=null,$name=null,$q=null,$selected_id=null, $class=null){
		echo "<select onchange = '{$onchange}' name = '{$name}' class='{$class}'>";
		
		echo "<option value='-1'> - Izaberi kupca - </option>";	
		while($rw=mysqli_fetch_object($q)){
		echo "<option " . ($selected_id==$rw->sifra_kupca?"selected":"") . " value='{$rw->sifra_kupca}'>{$rw->naziv_kupca}</option>";
		}
		
		echo "</select>";		
	}


	function multiSelect($id=null,$onchange=null,$name=null,$q=null,$selected_id=null,$multiple=null, $class=null){
		echo "<select id='{$id}' onchange = '{$onchange}' name = '{$name}' multiple='{$multiple}' class='{$class}'>";
		
		// echo "<option value='-1'>Slect Category</option>";	
		while($rw=mysqli_fetch_object($q)){
		echo "<option " . ($selected_id==$rw->sifra_kupca?"selected":"") . " value='{$rw->sifra_kupca}'>{$rw->naziv_kupca}</option>";
		}
		
		echo "</select>";		
	}
}


 ?>

