<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Validator;

    class UserController extends Controller
    {
        public function index()
        {
            //
        }

        public function create()
        {
            return view('admin.user.register');
        }

        public function store(Request $request)
        {
            $validation = Validator::make($request->all(),
                [
                    'username'  => 'required|min:3|unique:users',
                    'password1' => 'required|min:6',
                    'password2' => 'required|same:password1'
                ]
            );

            if ($validation->passes()) {
                //save data to db

                $password = $request->get('password1');

                $user = new User;

                $user->username = $request->get('username');
                $user->password = Hash::make($password);
                $user->remember_token = '';
                $user->active = 0;

                // $user = User::create([
                // 		'username'			=>	$request->get('username'),
                // 		'password'			=> 	Hash::make($password),
                // 		'remember_token'	=> '',
                // 		'active'			=>	0
                // 	]);

                if ($user->save()) {
                    return Redirect::to('/')
                        ->with('success', 'Registered successfully.');
                } else {
                    return Redirect::to('/')
                        ->with('fail', 'There was an error creating an account. Please try again');
                }
            } else {
                //redirect user back with data and errors
                return Redirect::to('user/create')
                    ->withErrors($validation)
                    ->withInput();
            }
        }


        public function getSignIn()
        {
            return view('admin.user.signin');
        }


        public function signIn(Request $request)
        {
            $validation = Validator::make($request->all(), User::$loginRules);

            if ($validation->passes()) {

                $remember = ($request->has('remember')) ? true : false;

                if (Auth::attempt($request->only('username', 'password'), $remember)) {
                    return Redirect::intended();
                } else {
                    return Redirect::to('user/signin')
                        ->withInput()
                        ->with('fail', 'Incorrect username / password');

                }
            } else {
                return Redirect::to('user/signin')
                    ->withInput()
                    ->withErrors($validation);
            }
        }

        public function logout()
        {
            Auth::logout();
            return Redirect::route('home')
                ->with('success', 'You have been logged out!');
        }


        public function edit($id)
        {
            //
        }

        public function update($id)
        {
            //
        }

        public function destroy($id)
        {
            //
        }


    }
