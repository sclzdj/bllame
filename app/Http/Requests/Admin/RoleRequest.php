<?php

namespace App\Http\Requests\Admin;

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
        $action=explode('@',mca())[1];
        $method=$this->method();
        if($action=='store' && $method=='POST'){//新增场景
            $rules=[
                'title' => 'required|min:2|max:20|unique:bs_roles,title',
                'name' => 'required|min:2|max:20|unique:bs_roles,name|regex:/^^[\x4e00-\x9fa5]+$/',
                'bs_node_ids'=>'required',
                'status'=>'regex:/^[0,1]$/',
            ];
        }
        if($action=='update' && ($method=="PUT" || $method=="PATCH")){//修改场景
            $role=$this->route('role');
            $id=$role?$role->id:null;
            $rules=[
                'title' => 'required|min:2|max:20|unique:bs_roles,title,'.$id,
                'name' => 'required|min:2|max:20|unique:bs_roles,name,'.$id.'|regex:/^^[\x4e00-\x9fa5]+$/',
                'bs_node_ids'=>'required',
                'status'=>'regex:/^[0,1]$/',
            ];
        }
        return $rules;
    }
    
    public function messages()
    {
        return [
            'title.required' => '名称不能为空',
            'title.min' => '名称长度最小2位',
            'title.max' => '名称长度最大10位',
            'title.unique' => '名称已存在',
            'name.required' => '标识不能为空',
            'name.min' => '标识长度最小2位',
            'name.max' => '标识长度最大10位',
            'name.unique' => '标识已存在',
            'name.regex' => '标识含有中文或空格',
            'bs_node_ids.required' => '至少选择一个节点',
            'status.regex' => '状态值错误',
        ];
    }
}
