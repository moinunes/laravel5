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
	
		if ( $input->acao == 'excluir' ) { 
			$validar = array();

		} else {			
			$validar = [
				'grupo'      => "required|min:1|max:50|unique:tbgrupos,grupo,{$input->id}",
				'descricao'  => 'required|min:1|max:60',
				'ids_selecionados'  => 'required|min:1',
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
		$input = (object)Request::all();
		$messages = array();
		$messages = [ 'grupo.unique' => 'Grupo já cadastrado.', ];

		if ( $input->acao != 'excluir' ) {			
         $messages = [ 'ids_selecionados.required' => 'O campo Usuários selecionados é obrigatório.', ];
      }
      return $messages;
	}


}
