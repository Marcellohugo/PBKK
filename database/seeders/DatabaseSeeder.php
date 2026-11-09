<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Staf', 'guard_name' => 'web']);
        $admin->givePermissionTo(Permission::firstOrCreate(['name' => 'projects.delete', 'guard_name' => 'web']));

        if (! app()->environment('local')) {
            return;
        }

        $sampleCount = User::where('email', 'like', '%@student.its.ac.id')->has('projects', '=', 2)->count();
        User::factory(max(0, 15 - $sampleCount))->create()
            ->each(fn (User $user) => Project::factory(2)->for($user)->create());

        $demo = User::firstOrCreate(
            ['email' => 'dosenpbkk@its.ac.id'],
            ['name' => 'Marco Marcello Hugo', 'password' => 'demo12345'],
        );

        $demo->projects()->firstOrCreate(['judul' => 'Pemetaan literatur pembelajaran adaptif'], [
            'deskripsi' => 'Menata pertanyaan riset, sumber artikel, dan kandidat celah penelitian untuk ditinjau ulang.',
            'tema_agent' => 'Ollama',
        ]);
        $demo->projects()->firstOrCreate(['judul' => 'Verifikasi bukti pada penelitian kesehatan digital'], [
            'deskripsi' => 'Membandingkan metode studi dan menyusun ringkasan dengan rujukan yang dapat diperiksa.',
            'tema_agent' => 'Senopati AI',
        ]);

        foreach (['Admin' => 'admin@researchmate.local', 'Staf' => 'staf@researchmate.local'] as $role => $email) {
            User::updateOrCreate(
                ['email' => $email],
                ['name' => "Demo {$role}", 'password' => 'demo12345'],
            )->syncRoles([$role]);
        }
    }
}
