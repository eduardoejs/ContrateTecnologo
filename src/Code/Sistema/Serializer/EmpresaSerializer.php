<?php

namespace Code\Sistema\Serializer;

use Code\Sistema\Entity\Empresa;

class EmpresaSerializer{

	private $empresa;

	public function __construct(Empresa $empresa){
		$this->empresa = $empresa;
	}

	public function serialize(){
		$empresa['id'] = $this->empresa->getId();
		$empresa['nome'] = $this->empresa->getNome();
		$empresa['endereco'] = $this->empresa->getEndereco();
		$empresa['cidade'] = $this->empresa->getCidade();
		$empresa['estado'] = $this->empresa->getEstado();
		$empresa['fone'] = $this->empresa->getFone();
		$empresa['email'] = $this->empresa->getEmail();
		$empresa['createdAt'] = $this->empresa->getCreatedAt();
		$empresa['updatedAt'] = $this->empresa->getUpdatedAt();

		return $empresa;
	}
}