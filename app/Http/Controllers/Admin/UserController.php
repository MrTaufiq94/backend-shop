<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $users = User::latest()->when(request()->q, function($users) {
            $users = $users->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.user.index', compact('users'));
    }
    
    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('admin.user.create');
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
       $this->validate($request, [
           'name'       => 'required',
           'email'      => 'required|email|unique:users',
           'password'   => 'required|confirmed'      
       ]); 

       //save to DB
       $user = User::create([
           'name'       => $request->name,
           'email'      => $request->email,
           'password'   => bcrypt($request->password),
       ]);

       if($user){
            //redirect dengan pesan sukses
            return redirect()->route('admin.user.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.user.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    
    /**
     * edit
     *
     * @param  mixed $user
     * @return void
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $user
     * @return void
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'       => 'required',
            'email'      => 'required|email|unique:users,email,'.$user->id,
            'password'   => 'required|confirmed'      
        ]); 

        //cek password
        if($request->password == "") {

            //update tanpa password
            $user = User::findOrFail($user->id);
            $user->update([
                'name'       => $request->name,
                'email'      => $request->email
            ]);

        } else {

            //update dengan password
            $user = User::findOrFail($user->id);
            $user->update([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => bcrypt($request->password),
            ]);
        }
 
        if($user){
             //redirect dengan pesan sukses
             return redirect()->route('admin.user.index')->with(['success' => 'Data Berhasil Diupdate!']);
         }else{
             //redirect dengan pesan error
             return redirect()->route('admin.user.index')->with(['error' => 'Data Gagal Diupdate!']);
         }
    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if($user){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
