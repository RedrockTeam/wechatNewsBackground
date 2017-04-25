<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Model\User;

class UserController extends Controller
{
    public  function register(Request $request) {
        $validator = \Validator::make($request->all(),[
            'username' => 'bail|between:5,25|unique:users,username|required|alpha_dash',
            'nickname' => 'max:25|required|alpha_dash',
            'password' => 'required|between:10,32|confirmed',
        ]);
//        $validator = \Validator::make($request->all(), [
//            'username' => 'bail|between:5,25|unique:users,username|required|alpha_dash',
//            'nickname' => 'between:5,25|required|alpha_dash',
//            'password' => 'required|between:10,32|confirmed',
//        ]);
        if ($validator->fails()) {
            return \Response::json([
                'status' => 404,
                'state' => 404,
                'info' => 'error parameter',
                'errors'=>$validator->errors()->all()
            ], 403);
        }
        $data = $request->only(['username', 'nickname', 'password']);
        $data['password'] = $this->pwdHash($data['password']);
        $user = User::create($data);
        session('user', $user->toArray());
        return \Response::json(['state'=>200,'info'=>'success']);

    }

    public function changePwd(Request $request) {

        $validator = \Validator::make($request->all(),[
            'username' => 'exists:users,username,state,1',
            'user_id' => 'numeric|required_if:username,null|exists:users,id,state,1',
            'oldPassword' => 'required|digits_between:10:32',
            'newPassword' => 'required|digits_between:10:32|confirmed',
        ]);
        if ($validator->fails()) {
            return \Response::json([
                'status' => 404,
                'state' => 404,
                'info' => 'error parameter',
                'errors'=>$validator->errors()->all()
            ], 403);
        }
        $user = $request->has('username')? User::find($request->get('user_id')) : User::where("username",$request->get('username'))->frist();
        if ($this->pwdVerify($request->get('oldPassword'), $user->password)) {
            $user->password = $this->pwdHash($request->get('password'));
            $user->save();
            return \Response::json(['status' => 200, 'state' => 200, 'info' => 'success']);
        }
        return \Response::json(['status' => 403, 'state' => 403, 'info' => 'forbid', 'errors'=>['密码错误']], 403);

    }

    //密码序列化
    protected function pwdHash($password) {
        $opt = ['cost' => 10];
        return password_hash($password, PASSWORD_BCRYPT, $opt);
    }
    //密码验证
    protected  function pwdVerify($password, $hash) {
        return password_verify($password, $hash);
    }

    public function login(Request $request){
        $this->validate($request, [
            'username' => 'required|exists:users,username,state,1',
            'password' => 'required'
        ]);
        $user = User::where('username', $request->get('username'))->first();
        if(!$this->pwdVerify($request->get('password'), $user->password))
            return \Redirect::action('loginPage')->withErrors(['你的密码或者用户名错误']);
        $request->session()->put('user', $user->toArray());
        return \Redirect::route('home');
    }


}
