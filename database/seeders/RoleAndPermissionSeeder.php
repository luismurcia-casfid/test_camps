<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ==============================================
        // CREAR ROL: Super Admin
        // ==============================================
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        // Super Admin tiene TODOS los permisos
        $superAdmin->givePermissionTo(Permission::all());

        // ==============================================
        // CREAR ROL: Administrador
        // ==============================================
        $administrador = Role::firstOrCreate(['name' => 'administrador']);

        // El administrador puede gestionar: Users, Seasons, Courses, Tags, News
        $adminPermissions = Permission::whereIn('name', [
            // Users
            'view_user',
            'view_any_user',
            'create_user',
            'update_user',
            'delete_user',
            'delete_any_user',

            // Seasons
            'view_season',
            'view_any_season',
            'create_season',
            'update_season',
            'delete_season',
            'delete_any_season',
            'force_delete_season',
            'force_delete_any_season',
            'restore_season',
            'restore_any_season',
            'replicate_season',

            // Courses
            'view_course',
            'view_any_course',
            'create_course',
            'update_course',
            'delete_course',
            'delete_any_course',
            'force_delete_course',
            'force_delete_any_course',
            'restore_course',
            'restore_any_course',
            'replicate_course',

            // Tags
            'view_tag',
            'view_any_tag',
            'create_tag',
            'update_tag',
            'delete_tag',
            'delete_any_tag',
            'force_delete_tag',
            'force_delete_any_tag',
            'restore_tag',
            'restore_any_tag',
            'replicate_tag',

            // News
            'view_news',
            'view_any_news',
            'create_news',
            'update_news',
            'delete_news',
            'delete_any_news',
            'force_delete_news',
            'force_delete_any_news',
            'restore_news',
            'restore_any_news',
            'replicate_news',

            // Roles (pueden gestionar roles)
            'view_role',
            'view_any_role',
            'create_role',
            'update_role',
            'delete_role',
            'delete_any_role',
        ])->pluck('name')->toArray();

        $administrador->givePermissionTo($adminPermissions);

        // ==============================================
        // CREAR ROL: Gestor (Taquilleros)
        // ==============================================
        $gestor = Role::firstOrCreate(['name' => 'gestor']);

        // El gestor tiene acceso SOLO a las páginas de Gestión
        $gestorPermissions = Permission::where('name', 'like', 'page_%')
            ->whereIn('name', [
                'page_Plazas',
                'page_Inscripciones',
                'page_NuevaInscripcion',
            ])->pluck('name')->toArray();

        $gestor->givePermissionTo($gestorPermissions);

        // ==============================================
        // CREAR ROL: Monitor (Personal de la academia)
        // ==============================================
        $monitor = Role::firstOrCreate(['name' => 'monitor']);

        // El monitor puede ver y gestionar cursos/actividades asignadas
        $monitorPermissions = Permission::whereIn('name', [
            // Courses (solo ver y actualizar, no crear ni eliminar)
            'view_course',
            'view_any_course',
            'update_course',
        ])->pluck('name')->toArray();

        $monitor->givePermissionTo($monitorPermissions);

        // ==============================================
        // CREAR ROL: Usuario (Padres, tutores, etc.)
        // ==============================================
        $usuario = Role::firstOrCreate(['name' => 'usuario']);

        // Los usuarios finales NO tienen acceso al panel admin
        // No les damos ningún permiso de Filament

        $this->command->info('✅ Roles y permisos creados correctamente:');
        $this->command->info('   - super_admin (todos los permisos - Desarrolladores/PM)');
        $this->command->info('   - administrador (acceso completo al panel)');
        $this->command->info('   - gestor (taquilleros - acceso limitado)');
        $this->command->info('   - monitor (personal academia - gestiona cursos/actividades)');
        $this->command->info('   - usuario (padres/tutores - NO acceden al panel admin)');
    }
}
