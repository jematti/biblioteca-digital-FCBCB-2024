<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;



class UsersIndex extends Component
{

    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }
    public function render()
    {
        // $users=User::where('name','LIKE','usuario 1')->paginate();
        $users = User::where('name', 'LIKE' , '%' .$this->search . '%')
                ->orWhere('email', 'LIKE' , '%' .$this->search . '%')->simplepaginate(10);

        return view('livewire.admin.users-index', compact('users'));
    }
}
