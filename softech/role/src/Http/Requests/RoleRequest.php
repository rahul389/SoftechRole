<?php

namespace Softech\Role\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        $roleId = isset($this->role->id) ? $this->role->id : null;
        return [
            'name' => 'required|unique:roles,name,'.$roleId,
            'permissions' => 'required'
            
        ];
    }
}
