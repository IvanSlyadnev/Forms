<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Message::updateOrCreate(['text' => 'Откуда ты?']);
        Message::updateOrCreate(['text' => 'Сколько тебе лет?']);
    }
}
