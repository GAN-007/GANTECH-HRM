<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstallationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'purchasecode' => 'required',
            'cpanel_api_key' => ['required', 'regex:/^\S*$/'],
            'cpanel_username' => ['required', 'regex:/^\S*$/'],
            'central_domain' => 'required|url',
            'db_prefix' => 'required',
            'db_host' => 'required|string',
            'db_port' => 'required|numeric',
            'db_name' => ['required', 'regex:/^\S*$/'],
            'db_username' => ['required', 'regex:/^\S*$/'],
            'db_password' => ['required', 'regex:/^\S*$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'cpanel_api_key.regex' => "The :attribute must not contain any whitespace",
            'cpanel_username.regex' => "The :attribute must not contain any whitespace",
            'db_name.regex' => "The :attribute must not contain any whitespace",
            'db_username.regex' => "The :attribute must not contain any whitespace",
            'db_password.regex' => "The :attribute must not contain any whitespace",
        ];
    }
}
