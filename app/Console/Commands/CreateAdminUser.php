<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create
                            {--name= : Nombre del administrador}
                            {--email= : Correo electrónico}
                            {--password= : Contraseña}';

    protected $description = 'Crea la cuenta de administrador. No hace nada si ya existe una.';

    public function handle(): int
    {
        if (User::where('is_admin', true)->exists()) {
            $this->components->warn('Ya existe una cuenta de administrador. No se realizó ningún cambio.');
            return self::SUCCESS;
        }

        $name     = $this->option('name')     ?? $this->ask('Nombre del administrador');
        $email    = $this->option('email')    ?? $this->ask('Correo electrónico');
        $password = $this->option('password') ?? $this->secret('Contraseña');

        if (User::where('email', $email)->exists()) {
            $this->components->error("Ya existe un usuario con el correo «{$email}».");
            return self::FAILURE;
        }

        User::create([
            'name'              => $name,
            'email'             => $email,
            'password'          => Hash::make($password),
            'is_admin'          => true,
            'email_verified_at' => now(),
        ]);

        $this->components->success("Administrador «{$name}» creado correctamente.");
        return self::SUCCESS;
    }
}
