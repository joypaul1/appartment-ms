<?php

namespace App\Http\Requests\Admin;

use App\Helpers\Image;
use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class StoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|unique:admins,email',
            'mobile' => 'required|unique:admins,mobile',
            'branch_id' => 'required',
            'image' => 'required',
        ];
    }

    public function storeData($request)
    {

        try {
            $data = $request->validated();
            if($request->image){
                $data['image'] =  (new Image)->dirName('admin')->file($request->image)
                ->resizeImage(100, 100)
                ->save();
            }

            if($request->password){
                $data['password'] = Hash::make($request->password);
            }
            $data['role_type'] = 'super_admin';
            Admin::create($data);
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'msg' =>$ex->getMessage()]);
        }
        return response()->json(['status' => true, 'msg' => 'Data Updated Successfully']);
    }
}
