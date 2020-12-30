<?php

use App\Models\MatchMakers;
use Illuminate\Database\Seeder;

class MatchMakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (MatchMakers::count() == 0) {
            $questions = [
                'How Do You Like Your Coffee?',
                'What’s Your Preferred Taste?',
                'Which Do You Prefer?',
                'What’s Your Preferred Roast?',
                'What’s Your Price Range?'
            ];

            $match_makers_types = [
                'best_for',
                'characteristic',
                'type',
                'level',
                'price'
            ];

            $images = [
                'coffee.svg',
                'taste.png',
                'prefer-icon.svg',
                'coffee.svg',
                'price-icon.svg'
            ];

            foreach($questions as $key => $question) {
                MatchMakers::create([
                    'image_url' => 'uploads/match-makers/' . $images[$key],
                    'question' => $question,
                    'type' => $match_makers_types[$key],
                    'min_select' => ($key == 1) ? 3 : 1,
                    'max_select' => ($key == 1) ? 3 : 1,
                    'status' => 1
                ]);
            }
        }
    }
}
