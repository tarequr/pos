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
            'serial_type'    => 'required|in:single,range,bulk',
            'serial_no'      => 'nullable|required_if:serial_type,single|unique:products,serial_no',
            'serial_start'   => 'nullable|required_if:serial_type,range|integer',
            'serial_end'     => 'nullable|required_if:serial_type,range|integer|gte:serial_start',
            'bulk_serials'   => 'nullable|required_if:serial_type,bulk|array',
            'bulk_serials.*' => 'nullable|string|max:255|unique:products,serial_no',
        ];
    }
}
