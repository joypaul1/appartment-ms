<?php

namespace App\Http\Requests\Admin;

use App\Helpers\Image;
use App\Models\Backend\Employee;
use App\Models\Backend\Owner;
use App\Models\Backend\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'email' => ['required', Rule::unique('admins')->ignore($this->admin->id)],
            'mobile' => ['required','max:13', Rule::unique('admins')->ignore($this->admin->id)],
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ];
    }

    public function updateData($request ,$admin)
    {
        try {
            $data = $request->validated();

            if(!empty($request->image)){
                $data['image'] =  (new Image)->dirName('admin')->file($request->image)
                ->resizeImage(100, 100)
                ->deleteIfExists($admin->image)
                ->save();
            }
            if($admin->role_type != 'super_admin'){
                if($admin->role_type == 'owner'){
                    Owner::where('email', $admin->email)->first()->update($data);
                }
                if($admin->role_type == 'employee'){
                    Employee::where('email', $admin->email)->first()->update($data);
                }
                if($admin->role_type == 'tenant'){
                    Tenant::where('email', $admin->email)->first()->update($data);
                }
            }
            unset($data['password']);
            if(($request->filled('password'))){
                $data['password'] = Hash::make($request->password);
            }


            $admin->update($data);
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'msg' =>$ex->getMessage()]);
        }
        return response()->json(['status' => true, 'msg' => 'Data Updated Successfully']);
    }
}
