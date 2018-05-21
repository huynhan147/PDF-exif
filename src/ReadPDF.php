<?php
	namespace ReadPDF;

	use ReadPDF\Exceptions\FindException;
	use ReadPDF\Exceptions\ReadException;

class ReadPDF{
	private $p;
	private $ouput = array();
	private $readfile;
	public function __construct($path){
		$this->p = new \PDFlib();
		try{
			 $this->readfile = $this->p->open_pdi_document(realpath($path), "");
		}catch(\Exception $e){
			throw new FindException('Can\'t find file');
		}
		try{
			$this->set_info_key();

		}catch(\Exception $e){
			throw new ReadException('Can\'t get info');
		}
		 $this->p->close_pdi_document($this->readfile);
	}
	public function set_info_key(){
		$count = $this->p->pcos_get_number($this->readfile,"length:/Info");
		for($i=0;$i<$count;$i++){
			$info = "type:/Info[".$i."]";
			$objtype = $this->p->pcos_get_string($this->readfile,$info);
			$info = "/Info[".$i."].key";
			$key = $this->p->pcos_get_string($this->readfile,$info);
			if($objtype=="name"|| $objtype=="string"){
				$info = "/Info[".$i."]";
				$this->output[$key] = $this->p->pcos_get_string($this->readfile,$info);
			}else{
				$info = "type:/Info[" . $i . "]";
				$this->output[$key] = $this->p->pcos_get_string($this->readfile,$info);
			}
		}
	}
	public function getAllInfo(){
		return $this->output;
	}
	public function getInfoByKey($key){
		if($key!==''){
			return $this->output[$key];
		}
	}




}
// $a = new ReadPDF('filetest.pdf');
// echo '<pre>';
// print_r($a->getInfoByKey('Title'));

	


?>