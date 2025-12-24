<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            'Main Branch',
            'Downtown',
            'Uptown',
            'Westside',
        ];

        foreach ($branches as $branch) {
            \App\Models\Branch::create([
                'name' => $branch,
                'slug' => \Illuminate\Support\Str::slug($branch),
                'status' => true,
            ]);
        }
    }
}
