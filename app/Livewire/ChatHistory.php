<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class ChatHistory extends Component
{
    protected $listeners = ['history-updated' => '$refresh'];

    public function render(): View
    {
        return view('livewire.chat-history', [
            'threads' => auth()->user()->conversations()->latest('updated_at')->orderByDesc('id')->get(['id', 'title']),
        ]);
    }
}
