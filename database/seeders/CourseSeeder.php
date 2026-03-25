<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'name' => 'Mathematics — Algebra & Geometry',
                'description' => 'Core concepts in linear equations, polynomials, angles, triangles, and coordinate geometry. Builds problem-solving skills for higher math.',
                'image' => 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=800&q=80',
                'views' => 1240,
            ],
            [
                'name' => 'English Literature',
                'description' => 'Reading and analysis of novels, poetry, and drama. Focus on themes, literary devices, and essay writing.',
                'image' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=800&q=80',
                'views' => 980,
            ],
            [
                'name' => 'Science — Physics Fundamentals',
                'description' => 'Motion, forces, energy, waves, and electricity. Hands-on labs and conceptual understanding aligned with the curriculum.',
                'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=800&q=80',
                'views' => 2105,
            ],
            [
                'name' => 'Science — Chemistry Basics',
                'description' => 'Atoms, periodic table, chemical bonding, reactions, and acids & bases with safe laboratory practice.',
                'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=800&q=80',
                'views' => 1560,
            ],
            [
                'name' => 'History & Social Studies',
                'description' => 'World and national history, civics, and geography. Critical thinking through primary sources and discussion.',
                'image' => 'https://images.unsplash.com/photo-1461360370896-922624d12aa1?w=800&q=80',
                'views' => 742,
            ],
            [
                'name' => 'Computer Science & ICT',
                'description' => 'Programming logic, algorithms, data structures basics, and responsible use of technology in school projects.',
                'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&q=80',
                'views' => 3320,
            ],
            [
                'name' => 'Physical Education',
                'description' => 'Team sports, fitness, teamwork, and health education. Emphasis on participation and lifelong wellness.',
                'image' => 'https://images.unsplash.com/photo-1576678927484-cc907957088c?w=800&q=80',
                'views' => 890,
            ],
            [
                'name' => 'Art & Design',
                'description' => 'Drawing, painting, digital design, and art history. Portfolio development and creative expression.',
                'image' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=800&q=80',
                'views' => 615,
            ],
        ];

        foreach ($courses as $course) {
            Course::query()->updateOrCreate(
                ['name' => $course['name']],
                $course
            );
        }
    }
}
