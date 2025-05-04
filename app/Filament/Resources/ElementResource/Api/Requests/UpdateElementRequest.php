<?php

namespace App\Filament\Resources\ElementResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateElementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'nom' => 'required',
			'ref_inf_h' => 'required',
			'ref_sup_h' => 'required',
			'ref_inf_f' => 'required',
			'ref_sup_f' => 'required',
			'ref_inf_enf' => 'required',
			'ref_sup_enf' => 'required',
			'ref_inf_nour' => 'required',
			'ref_sup_nour' => 'required',
			'ref_inf_nne' => 'required',
			'ref_sup_nne' => 'required',
			'unite' => 'required',
			'category_id' => 'required'
		];
    }
}
