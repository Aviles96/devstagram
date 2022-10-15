<?php

namespace App\Policies; // Con este policy el usuario puede actualizar, eliminar, ver un

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can delete the model. // Determina si un usuario puede eliminar un modelo
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id; //Es el usuario actual el mismo que creo el post que esta tratando
        // de eliminar
    }

}
