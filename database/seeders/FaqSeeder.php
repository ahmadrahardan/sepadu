<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pertanyaans = [
            'Apa itu Simbako?',
            'Bagaimana cara untuk mengajukan pelatihan terkait tembaku?',
            'Bagaimana cara untuk mendaftar pelatihan?',
        ];

        $jawabans = [
            'Simbako adalah Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum minus eius numquam necessitatibus accusantium fuga saepe reiciendis omnis voluptatem? Ratione!',
            'Cara untuk mengajukan pelatihan Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum minus eius numquam necessitatibus accusantium fuga saepe reiciendis omnis voluptatem? Ratione!',
            'Cara untuk mendaftar pelatihan Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum minus eius numquam necessitatibus accusantium fuga saepe reiciendis omnis voluptatem? Ratione!',
        ];

        foreach ($pertanyaans as $index => $pertanyaan) {
            Faq::create([
                'user_id' => 1,
                'pertanyaan' => $pertanyaan,
                'jawaban' => $jawabans[$index] ?? 'Jawaban belum tersedia',
            ]);
        }
    }
}
