<?php

namespace Database\Seeders;

use Database\Factories\PublisherFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PublisherFactory::new()->count(10)->create();
    }
}
