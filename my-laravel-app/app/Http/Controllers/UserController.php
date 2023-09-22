<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function show()
    {
        return 'show';
    }

    public function all()
    {
        return 'show all';
    }

    public function showName($name)
    {
        return $name;
    }

    public function showNameSurname($name, $surname)
    {
        return 'user: ' . $name .$surname;
    }

    public function showUserCity($user)
    {
        $users = [
          'user1' => 'city 1',
          'user2' => 'city 2',
          'user3' => 'city 3',
        ];
        return $users[$user];
    }

    public function showView(){
        return view('user.show',[
            'title' => 'user title 1',
            'name' => 'eugene',
            'age' => '39',
            'salary' => '100000',
            'css' => 'sClass',
            'redColor' => 'red',
            'text' => 'text link',
            'href' => 'ya.ru',
        ]);
    }

    public function showView2(){
        return view('user.show2', [
            'title' => 'user title 2',
            'text' => 'user content 2'
        ]);
    }

    public function showView3(){
        return view('user.show3', [
            'title' => 'user title 3',
            'text' => 'user content3',
        ]);
    }
}
