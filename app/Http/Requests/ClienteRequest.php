<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome'        => 'required|max:255',
            'cidade_id'   => 'required|numeric',
            'email'       => 'required|nullable|email',
            'observacoes' => 'required',
            'cpf_cnpj'    => 'required|unique:clientes,cpf_cnpj'
        ];
    }
    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
   public function messages()
   {
       return [
           'cpf_cnpj.unique' => 'O :attribute já está sendo utilizado por outro cliente',
       ];
   }
   
   public function attributes()
   {
       return [
           'cpf_cnpj'    => 'CPF',
           'observacoes' => 'Observações',
       ];
   }
}
