<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['title' => 'IBIS Building', 'file' => 'Cliente1.png'],
            ['title' => 'Gilbane', 'file' => 'Cliente2.png'],
            ['title' => 'WM', 'file' => 'Cliente3.png'],
            ['title' => 'Florida Lottery', 'file' => 'Cliente4.png'],
            ['title' => 'Verdex Construction', 'file' => 'Cliente5.png'],
        ];

        foreach ($clients as $index => $client) {
            Content::firstOrCreate(
                [
                    'section' => 'clients',
                    'sort_order' => $index + 1,
                ],
                [
                    'title' => $client['title'],
                    'image' => 'content/clients/'.$client['file'],
                    'is_active' => true,
                ],
            );
        }
    }
}
