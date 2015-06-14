<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class GrupoRequest extends Request {

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
				'grupo'      => "required|min:1|max:50|unique:tbgrupos,grupo,{$input->id}",
				'descricao'  => 'required|min:1|max:60',				
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
			'grupo.unique' => 'Grupo já cadastrado.',            
      ];
	}

}
