<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;


use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class Todolist extends Component
{
    use WithPagination;

     #[Rule('required|min:3|max:255')]
    public $name;

    public $search;

    public $editingTodoID;
    #[Rule('required|min:3|max:255')]
    public  $editingTodoName;

    public function create(){
     $validate = $this->validateOnly('name');

     Todo::create($validate);

     $this->reset('name');

     session()->flash('success','user created successfully');

     $this->resetPage();

    }

    public function render()
    {

        return view('livewire.todolist',[
            'todos' => Todo::latest()->where('name','like',"%{$this->search}%")->paginate(3)
        ]);
    }

    public function delete($todoID){
       try{
             Todo::findOrFail($todoID)->delete();
       }catch(Exeption $e){
        session()->flash('error','failed to delete todo');
        return;
       }

    }

    public function toggle($todoID){
       $todo = Todo::find($todoID);
       $todo->completed = !$todo->completed;
       $todo->save();
    }

    // public function edit($todoID){
    //     $this->editingTodoID->$todoID;
    //     $this->editingTodoName = Todo::find($todoID)->name;

    // }

    public function edit($todoID)
{
    $this->editingTodoID = $todoID;

    $todo = Todo::find($todoID);

    if ($todo) {
        $this->editingTodoName = $todo->name;
    } else {
        // Handle the case where the Todo item is not found
        $this->editingTodoName = null; // Or set a default value, or display an error
        // You could also add a session flash message or log an error
    }
}

public function cancel(){
    $this->reset('editingTodoID','editingTodoName');
}

public function update(){
    $this->validateOnly('editingTodoName');
    Todo::find($this->editingTodoID)->update([
       'name' => $this->editingTodoName
    ]);

    $this->cancel();
}

}
