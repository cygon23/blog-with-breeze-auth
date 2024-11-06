<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Clicker extends Component
{
    use WithPagination;

    #[Rule('required|min:2|max:50')]
    public $name;
    #[Rule('required|email|unique:users')]
    public $email;
    #[Rule('required|min:5')]
    public $password;

public function create(){
    $this->validate();
    User::create([
       'name' => $this->name,
       "email" => $this->email,
       "password" => $this->password
    ]);

    $this->reset(['name','email','password']);
    request()->session()->flash('success','User created succefully');


}

    public function render()
    {
        $users =User::paginate(3);

        return view('livewire.clicker',[
            'users' => $users
        ]);
    }
}
