<?php

namespace App\Http\Controllers;
use Auth;
use DataTables;
use App\Models\User;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Show the users dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        return view('users');
    }

    /**
     * Show User List
     *
     * @param Request $request
     * @return mixed
     */
    public function getUserList(Request $request): mixed
    {
        $data = User::get();
        $hasManageUser = Auth::user()->can('manage_user');

        return Datatables::of($data)
            ->addColumn('roles', function ($data) {
                $roles = $data->getRoleNames()->toArray();
                $badge = '';
                if ($roles) {
                    $badge = implode(' , ', $roles);
                }

                return $badge;
            })
            ->addColumn('permissions', function ($data) {
                $roles = $data->getAllPermissions();
                $badges = '';
                foreach ($roles as $key => $role) {
                    $badges .= '<span class="badge badge-dark m-1">' . $role->name . '</span>';
                }

                return $badges;
            })
            ->addColumn('action', function ($data) use ($hasManageUser) {
                $output = '';
                if ($data->name == 'Super Admin') {
                    return '';
                }
                if ($hasManageUser) {
                    $output = '<div class="table-actions">
                                <a href="' . url('user/' . $data->id) . '" ><i class="ik ik-edit-2 f-16 mr-15 text-green"></i></a>
                                <a href="' . url('user/delete/' . $data->id) . '"><i class="ik ik-trash-2 f-16 text-red"></i></a>
                            </div>';
                }

                return $output;
            })
            ->rawColumns(['roles', 'permissions', 'action'])
            ->make(true);
    }




    /**
     * User Create - Show form to create new user
     *
     * @return mixed
     */
    public function create(): mixed
    {
        try {
            $roles = Role::pluck('name', 'id');

            return view('create-user', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }




    /**
     * Store User  // POST CREATE NEW USER
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        
        // validate user fields
        $validator = Validator::make($request->all(), [
            'name' => ['required','string'],
            'email' => ['required', 'email', Rule::unique('users','email','unique:users')],
            'password' => ['required', 'confirmed']
        ]);
            
           
            
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }


            // Το hash γίνεται στο model User.php
            // store user information
            $user = User::create($validator);
            // $user = User::create([
            //     'name' => $user_fields['name'],
            //     'email' => $user_fields['email'],
            //     'password' => $user_fields['password']
            // ]);
            
            
        try {
            
            if ($user) {
                // assign new role to the user
                $user->syncRoles($request->role);
                return redirect('users')->with('success', 'New user created!');
            }
            return redirect('users')->with('error', 'Failed to create new user! Try again.');


        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Edit User - Show Form to edit user
     *
     * @param int $id
     * @return mixed
     */
    public function edit($id): mixed
    {
        try {
            $user = User::with('roles', 'permissions')->find($id);

            if ($user) {
                $user_role = $user->roles->first();
                $roles = Role::pluck('name', 'id');

                return view('user-edit', compact('user', 'user_role', 'roles'));
            }

            return redirect('404');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Update User
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        // update user info
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required | string ',
            'email' => 'required | email ',
            'role' => 'required',
        ]);
        
        // check validation for password match
        if ($request->password) {
                $validator = Validator::make($request->all(), [
                    'password' => 'required | confirmed',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }

        try {
            if ($user = User::find($request->id)) {
                $payload = [
                    'name' => $request->name,
                    'email' => $request->email,
                ];
                // update password if user input a new password
                if (isset($request->password) && $request->password) {
                    $payload['password'] = $request->password;
                }

                $update = $user->update($payload);
                // sync user role
                $user->syncRoles($request->role);

                return redirect()->back()->with('success', 'User information updated succesfully!');
            }

            return redirect()->back()->with('error', 'Failed to update user! Try again.');
        } catch (\Exception $e) {
            $bug = $e->getMessage();

            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Delete User
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        if ($user = User::find($id)) {
            $user->delete();

            return redirect('users')->with('success', 'User removed!');
        }

        return redirect('users')->with('error', 'User not found');
    }





            /**
             * Edit User profile by his/her own - show form to edit user profile
             *
             * @param int $id
             * @return mixed
             */
            public function editmyprofile()
            {
                // the user object 
                $user = Auth::user();
              
                // $user_rows=DB::select(DB::raw(' SELECT * FROM users WHERE id='.$userid.';'));
                //     $user= $user_rows[0];
                return view('myprofile')->with('user',$user);
            }

  
            // Update User profile by his/her own, POST METHOD
            public function updateprofile(Request $request)
            {
                    // the user object
                    $user = Auth::user();

                    // $userid=Auth::id();
                    // $mypics = $request->file('mypic');
                    // $locale = $request->locale;
          

                
                       //dd($mypics);


                    // if( !is_null($mypics)) 
                    // {   

                    //     foreach($mypics as $mypic)
                    //     {
                    //         $directory="users";
                    //             $stored=false;
                    //             if( !is_null($mypic)) 
                    //             {   
                    //             $allowedfileExtension=['pdf','jpg','avi','mp4','png','docx','PNG'];
                    //             $filename = $mypic->getClientOriginalName();
                    //             $extension = $mypic->getClientOriginalExtension();
                    //             $originalName = $mypic->getClientOriginalName();
                    //             $check=in_array($extension,$allowedfileExtension);
                    //             $stored=($stored or $check)?true:false;
                    //             //dd($file);

                    //             if($check)
                    //                 {
                    //                 //dd($directory);

                    //                 $storagePath=Storage::putFileAs($directory, $mypic, $originalName);
                                    
                    //                     DB::select(DB::raw('UPDATE `users` SET  mypic="storage/azure_ext/'.$storagePath.'"WHERE id='.$userid.';'));
                    //             }

                    //         }


                    //     }

                    // }


                    // update user profile
                    if ($request->password)
                    {
                        $user->password = $request->password;  // το hash γίνεται αυτόματα στο μοντέλο User
                    }
                    $user->locale = $request->locale;
                    $user->save();

                    if ($request->file('avatar'))
                    {
                        $avatar_directory = 'public/avatars';
                        $request->file('avatar')->storeAs($avatar_directory, $user->id.'.jpg');
                    }


                    //  DB::select(DB::raw('UPDATE `users` SET  locale="'. $locale.'" WHERE id='.$userid.';'));  
                    //     $user_rows=DB::select(DB::raw(' SELECT * FROM users WHERE id='.$userid.';'));
                    //         $user= $user_rows[0];
                    //         $mypic=URL::to($user->mypic);
                        // return view('myprofile')->with('user',$user)->with('mypic',$mypic);
                    return view('myprofile')->with('user',$user);
                    }













}
