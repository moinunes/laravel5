<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProdutoRequest extends Request {

	/**
   * Determine if the user is authorized to make this request.
	*
	* @return bool
	*/
	public function authorize() {
		return true;
	}

	/**
	* Regras de validação.
	*
	* @return array
	*/
	public function rules()	{		
		$input = (object)Request::all();
	
		if ( $input->acao == 'E' ) { 
			$validar = array();

		} else {			
			$validar = [
				'codigo'     => "required|min:1|max:15|unique:tbprodutos,codigo,{$input->id}",
				'descricao'  => 'required|min:1|max:60',
				'quantidade' => 'required|numeric',
	         'preco'      => 'required|numeric',
			];		

		}
		return $validar;
	}

	/**
	* Mensagens personalizadas da validação.
	*
	* @return array
	*/	
	public function messages() {
		return [ 
			'codigo.unique' => 'Código já cadastrado.',            
      ];
	}

}
