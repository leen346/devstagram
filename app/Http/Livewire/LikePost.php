<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    // En estos archivos no estan permitidos los Request
    
    public $post;
    public $isLiked;
    public $likes;
    public function render()
    {
        return view('livewire.like-post');
    }

    // Ciclo de vida de Livewire

    public function mount($post)// se ejecuta cuando es instanciado el componente
    {
        $this->isLiked = $post->checkLike(auth()->user());
        $this->likes = $post->likes->count();
    }

    public function like()
    {
        if($this->post->checkLike(auth()->user())) {
            $this->post->likes()->where('post_id', $this->post->id)->delete();// user_id se tiene por automatico la referencia por la relacion de likes() del modelo User 
            $this->isLiked = false;
            $this->likes--;
        } else {
            $this->post->likes()->create([
                'user_id' => auth()->user()->id// no mandamos el post->id porque comenzamos del modelo post y ya lo mapea en el insert del modelo likes, tmb porque tiene una relacion
            ]);
            $this->isLiked = true;// cada cambio, livewire hace los re render en automatico
            $this->likes++;
        }
    }
}
