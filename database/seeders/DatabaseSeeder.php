<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\{Company, User, Link, Role};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar empresas
        $google = Company::create([
            'name' => 'Google',
            'slug' => 'google',
            'domain' => 'google.utrack.to',
        ]);

        $apple = Company::create([
            'name' => 'Apple',
            'slug' => 'apple',
            'domain' => 'apple.utrack.to',
        ]);

        // Usuário admin Google
        $googleUser = User::create([
            'name' => 'Google Admin',
            'email' => 'admin@google.com',
            'password' => Hash::make('password'),
            'company_id' => $google->id,
            'role' => 'admin',
        ]);

        // Usuário admin Apple
        $appleUser = User::create([
            'name' => 'Apple Admin',
            'email' => 'admin@apple.com',
            'password' => Hash::make('password'),
            'company_id' => $apple->id,
            'role' => 'admin',
        ]);

        // Links Google
        Link::create([
            'company_id' => $google->id,
            'user_id' => $googleUser->id,
            'original_url' => 'https://www.google.com/search?q=utrack',
            'short_code' => $this->generateShortCode(),
            'custom_slug' => null,
            'expires_at' => now()->addDay(), // free, expira em 24h
        ]);

        Link::create([
            'company_id' => $google->id,
            'user_id' => $googleUser->id,
            'original_url' => 'https://analytics.google.com/',
            'short_code' => $this->generateShortCode(),
            'custom_slug' => 'analytics',
            'expires_at' => null, // premium, permanente
        ]);

        // Links Apple
        Link::create([
            'company_id' => $apple->id,
            'user_id' => $appleUser->id,
            'original_url' => 'https://www.apple.com/iphone/',
            'short_code' => $this->generateShortCode(),
            'custom_slug' => null,
            'expires_at' => now()->addDay(),
        ]);

        Link::create([
            'company_id' => $apple->id,
            'user_id' => $appleUser->id,
            'original_url' => 'https://developer.apple.com/',
            'short_code' => $this->generateShortCode(),
            'custom_slug' => 'dev',
            'expires_at' => null,
        ]);

        $googleAdminRole = Role::create([
            'company_id' => $google->id,
            'name' => 'Administrador',
            'slug' => 'admin',
        ]);

        $googleEditorRole = Role::create([
            'company_id' => $google->id,
            'name' => 'Editor',
            'slug' => 'editor',
        ]);

        // Criar usuário admin Google
        $googleUser = User::create([
            'name' => 'Google Admin',
            'email' => 'admin@google.com',
            'password' => Hash::make('password'),
            'company_id' => $google->id,
            'role_id' => $googleAdminRole->id,
        ]);

        // Criar roles padrão para Apple
        $appleAdminRole = Role::create([
            'company_id' => $apple->id,
            'name' => 'Administrador',
            'slug' => 'admin',
        ]);

        $appleEditorRole = Role::create([
            'company_id' => $apple->id,
            'name' => 'Editor',
            'slug' => 'editor',
        ]);

        // Criar usuário admin Apple
        $appleUser = User::create([
            'name' => 'Apple Admin',
            'email' => 'admin@apple.com',
            'password' => Hash::make('password'),
            'company_id' => $apple->id,
            'role_id' => $appleAdminRole->id,
        ]);
    }

    private function generateShortCode($length = 6): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($chars, $length)), 0, $length);
    }
}
