<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListarPost extends Component
{
    public $posts;
    
    // Un constructor va ser la informacion que se le va pasar a un componente
    public function __construct($posts)
    {
        // Aqui le hacemos saber sobre la variable posts en homeblade para que pueda leerla
        $this->posts = $posts;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.listar-post');
    }
}
