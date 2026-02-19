<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'category_id'    => 'required|exists:categories,id',
            'branch_id'      => 'required|exists:branches,id',
            'serial_type'    => 'required|in:single,range,bulk,custom',
            'serial_no'      => 'nullable|required_if:serial_type,single|unique:products,serial_no',
            'serial_start'   => 'nullable|required_if:serial_type,range|integer',
            'custom_serials'   => 'nullable|required_if:serial_type,custom|array|max:200',
            'custom_serials.*' => 'nullable|string|max:255|unique:products,serial_no',
            'serial_end'     => [
                'nullable',
                'required_if:serial_type,range',
                'integer',
                'gte:serial_start',
                function ($attribute, $value, $fail) {
                    if ($this->serial_type === 'range' && $this->serial_start && $value) {
                        $count = (int)$value - (int)$this->serial_start + 1;
                        if ($count > 200) {
                            $fail("The serial range cannot exceed 200 items (currently $count).");
                        }
                    }
                },
            ],
        ];
    }
}
