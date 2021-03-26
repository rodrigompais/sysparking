<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;

class PerfilController extends Component
{
    public function render()
    {
        $info = User::where('id', auth()->user()->id)->first();
        $info->all();
        //dd($info);
        return view('livewire.perfil.component',[
            'info' => $info
        ]);
    }
}