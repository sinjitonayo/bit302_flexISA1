<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   \App\Models\Department::truncate();
        \App\Models\Department::create([
            'id'=>1,
            'department_id' => '001',
            'department_name' => 'Information Technology',
        ]);
        \App\Models\Department::create([
            'id'=>2,
            'department_id' => '002',
            'department_name' => 'Finance',
        ]);
        \App\Models\Department::create([
            'id'=>3,
            'department_id' => '003',
            'department_name' => 'Student Affairs',
        ]);
        \App\Models\HRAdmin::truncate();
        \App\Models\HRAdmin::create([
            'id'=>1,
            'name' => 'HR Admin',
            'email' => 'admin@admin.com',
            'password' => '$2a$12$BaRH.U.yybmsYua4hzUb8OOdwUnSUTIiZwgsxGsPvsF7/CFb75CBy' //admin2023
        ]);
    }
}
