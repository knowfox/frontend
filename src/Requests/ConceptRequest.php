<?php

namespace Knowfox\Core\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Knowfox\Core\Models\Concept;
use Illuminate\Validation\Rule;

class ConceptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $concept = $this->route('concept');
        return !$concept || $this->user()->can('update', $concept);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $title_rule = [
            'required',
            'max:255',
        ];

        return [
            'title' => $title_rule,
        ];
    }
}
