<?php

namespace Hanoivip\Admin\Requests;

use Hanoivip\Admin\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AddBalance extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        
        if (Auth::guard('token')->check())
        {
            $uid = Auth::guard('token')->user()['id'];
            $role = UserRole::find($uid);
            if (!empty($role))
                return $role->role == 'admin';
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tid' => 'required|string',//target id
            'balance' => 'required|integer',
            'reason' => 'required|string'
        ];
    }
}
