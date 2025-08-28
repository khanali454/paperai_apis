<?php
namespace Database\Seeders;

use App\Models\StudyMaterial;
use Illuminate\Database\Seeder;

class StudyMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $material_1 = StudyMaterial::create( [
                'title'       => 'Key Books',
                'description' => 'Govt Key Books for Class 8',
                'user_id'     => 1, // user 1 aqeel abbas
                'class_id'    => 1, // class 8th
                'subject_id'  => 1, // subject 1 is Mathematics
                'tags'        => 'keybook 8th class, 8th class key book, 8th class mathematics',
                'is_public'   => false,
            ]);

        $material_1->files()->createMany([
            [
                'file_path' => 'study_materials/key_books/class_8th/mathematics-1.pdf',
                'file_type' => 'pdf',
                'file_name' => 'Mathematics Key Book Class 8',
            ],
            [
                'file_path' => 'study_materials/key_books/class_8th/mathematics-2.pdf',
                'file_type' => 'pdf',
                'file_name' => 'Science Key Book Class 8',
            ],
        ]);

       

            

            $past_paper_materials = [
                [
                    'title'       => '2015 Past Paper',
                    'description' => 'Past Paper of 2015 for Class 8',
                    'user_id'     => 1,
                    'class_id'    => 1,
                    'subject_id'  => 1,
                    'tags'        => 'past paper 2015, class 8 past paper, mathematics past paper',
                    'is_public'   => false,
                ],
                [
                    'title'       => '2016 Past Paper',
                    'description' => 'Past Paper of 2016 for Class 8',
                    'user_id'     => 1,
                    'class_id'    => 1,
                    'subject_id'  => 1,
                    'tags'        => 'past paper 2016, class 8 past paper, mathematics past paper',
                    'is_public'   => false,
                ],
            ];

        foreach ($past_paper_materials as $child) {
            $child_material = StudyMaterial::create($child);
            $child_material->files()->createMany([
                [
                    'file_path' => 'study_materials/past_papers/class_8th/mathematics/' . strtolower(str_replace(' ', '_', $child['title'])) . '.pdf',
                    'file_type' => 'pdf',
                    'file_name' => $child['title'] . ' Class 8',
                ],
                [
                    'file_path' => 'study_materials/past_papers/class_8th/mathematics/' . strtolower(str_replace(' ', '_', $child['title'])) . '-solution.pdf',
                    'file_type' => 'pdf',
                    'file_name' => $child['title'] . ' Class 8 Solution',
                ],
            ]);
        }

    }
}
