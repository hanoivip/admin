<?php

namespace Hanoivip\Admin\Requests;

use Hanoivip\Admin\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RemoveServer extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        return [
            
        ];
    }
}
