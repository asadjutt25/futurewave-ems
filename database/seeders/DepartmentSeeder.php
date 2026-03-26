<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['department_name' => 'IT Department', 'department_head' => 'John Doe', 'description' => 'Information Technology department'],
            ['department_name' => 'HR Department', 'department_head' => 'Jane Smith', 'description' => 'Human Resources department'],
            ['department_name' => 'Marketing Department', 'department_head' => 'Mike Johnson', 'description' => 'Marketing and Sales'],
            ['department_name' => 'Finance Department', 'department_head' => 'Sarah Williams', 'description' => 'Finance and Accounting'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}