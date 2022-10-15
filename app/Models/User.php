<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts() 
    {
        return $this->hasMany(Post::class); //Relacion de muchos de un usuario tiene muchos posts 
    }

    public function likes()
    {
        return $this->hasMany(Like::class);//Un post puede tener multiples likes
    }

    //Almacena los seguidores de un usuario los que sigo
    public function followers()
    {
        // puedo tener mutltiples seguidores le decimos la tabla de followers pertenece a muchos usuarios
        // Hay que especificar la tablas pibote por que me estoy saliendo de la convenciones normales de laravel
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }
    //Almacenar los que seguimos
    public function followings()
    {
        //Se modifico el orden de las columnas de followers y user_id
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    //Comprobar si un usuario ya sigue a otro
    public function siguiendo(User $user)
    {
        //En le contains verifica si ya esta siguiendo otro usuario
        return $this->followers->contains($user->id);
    }
}
