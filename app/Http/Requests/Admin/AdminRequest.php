<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $action=explode('@',mca())[1];
        $method=$this->method();
        if($action=='store' && $method=='POST'){//新增场景
            $rules=[
                'username' => 'required|min:2|max:20|regex:/^^[\x4e00-\x9fa5]+$/|unique:bs_admins,username',
                'password' => 'required|min:6|max:18|regex:/^[0-9a-zA-Z_!@#$%^&*]+$/',
                'nickname' => 'required|min:2|max:20',
                'access_type'=>'required|regex:/^[0,1]$/',
                'bs_role_ids'=>'required_if:access_type,0',
                'bs_node_ids'=>'required_if:access_type,1',
                'status'=>'regex:/^[0,1]$/',
            ];
        }
        if($action=='update' && ($method=="PUT" || $method=="PATCH")){//修改场景
            $admin=$this->route('admin');
            $id=$admin?$admin->id:null;
            $rules=[
                'username' => 'required|min:2|max:20|regex:/^^[\x4e00-\x9fa5]+$/|unique:bs_admins,username,'.$id,
                'password' => 'nullable|min:6|max:18|regex:/^[0-9a-zA-Z_!@#$%^&*]+$/',
                'nickname' => 'required|min:2|max:20',
                'access_type'=>'required|regex:/^[0,1]$/',
                'bs_role_ids'=>'required_if:access_type,0',
                'bs_node_ids'=>'required_if:access_type,1',
                'status'=>'regex:/^[0,1]$/',
            ];
        }
        return $rules;
    }
    
    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'username.min' => '用户名长度最小2位',
            'username.max' => '用户名长度最大10位',
            'username.regex' => '用户名含有中文或空格',
            'username.unique' => '用户名已存在',
            'password.required' => '密码不能为空',
            'password.min' => '密码长度最小6位',
            'password.max' => '密码长度最大18位',
            'password.regex' => '密码含有只能包含:0-9a-zA-Z_!@#$%^&*',
            'nickname.required' => '昵称不能为空',
            'nickname.min' => '昵称长度最小2位',
            'nickname.max' => '昵称长度最大10位',
            'access_type.required' => '权限类型不能为空',
            'access_type.regex' => '权限类型值错误',
            'bs_role_ids.required_if' => '至少选择一位角色',
            'bs_node_ids.required_if' => '至少选择一个节点',
            'status.regex' => '状态值错误',
        ];
    }
}
