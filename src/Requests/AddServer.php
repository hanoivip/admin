<?php

namespace Hanoivip\Admin\Requests;

use Hanoivip\Admin\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddServer extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            'name' => 'required|string',
            'ident' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'login_uri' => 'required|string',
            'recharge_uri' => 'required|string',
            'operate_uri' => 'required|string'
        ];
    }
}
