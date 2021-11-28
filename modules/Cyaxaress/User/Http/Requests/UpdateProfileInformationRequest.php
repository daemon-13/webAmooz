<?php


namespace Cyaxaress\User\Http\Requests;


use Cyaxaress\RolePermissions\Models\Permission;
use Cyaxaress\User\Rules\ValidPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileInformationRequest  extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =[
            "name" => 'required|min:3|max:190',
            "email" => 'required|email|min:3|max:190|unique:users,email,' .auth()->id(),
            "username" => 'nullable|min:3|max:190|unique:users,username,' .auth()->id(),
            "mobile" => 'nullable|unique:users,mobile,' . auth()->id(),
            "password" => ['nullable',new ValidPassword()],

        ];
        if (auth()->user()->hasPermissionTo(Permission::PERMISSION_TEACH)) {
            $rules = [
                "username" => 'nullable|min:3|max:190|unique:users,username,' . request()->route('user'),
                "card_number" => 'required|string|size:16',
                "shaba" => 'required|size:24',
                "headline" => 'required|min:3|max:60',
                "bio" => 'required',

            ];
        }
        return  $rules ;
    }
}