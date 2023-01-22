<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\ExceptionServer;
use Illuminate\Validation\Rule;

class MarcaRequest extends FormRequest
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
            "id" => "required|integer|min:0",
            "nom_marca" => "required"
        ];
    }

    public function messages()
    {
        return [
                "id.required" =>"El campo id es obligatorio",
                "id.integer" =>"El campo id de ser númerico",
                "id.min" =>"El campo id debe ser mayor a 0(cero)",
                "nom_marca.required" =>"El campo Marca es obligatorio",
        ];
    }
}
