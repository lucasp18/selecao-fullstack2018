<?php
class AplicacaoVacina{
	
	private $anv_int_codigo;
	private $ani_int_codigo;
	private $vac_int_codigo;	
	private $usu_int_codigo;

	public function getAnv_int_codigo() {
		return $this->anv_int_codigo;
	}

	public function setAnv_int_codigo($anv_int_codigo) {
		$this->anv_int_codigo = $anv_int_codigo;
	}


	public function getAni_int_codigo() {
		return $this->ani_int_codigo;
	}

	public function setAni_int_codigo($ani_int_codigo) {
		$this->ani_int_codigo = $ani_int_codigo;
	}


	public function getVac_int_codigo() {
		return $this->vac_int_codigo;
	}

	public function setVac_int_codigo($vac_int_codigo) {
		$this->vac_int_codigo = $vac_int_codigo;
	}

	public function getUsu_int_codigo() {
		return $this->usu_int_codigo;
	}

	public function setUsu_int_codigo($usu_int_codigo) {
		$this->usu_int_codigo = $usu_int_codigo;
	}



}