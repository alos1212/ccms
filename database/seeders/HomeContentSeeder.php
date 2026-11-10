<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class HomeContentSeeder extends Seeder
{
    public function run(): void
    {
        $contents = [
            [
                'section' => 'hero',
                'sort_order' => 1,
                'title' => 'Custom Cleaning Solutions',
                'subtitle' => 'Cleaner spaces · stronger communities',
                'introduction' => 'With exceptional service, compliance, and attention to detail.',
            ],
            [
                'section' => 'about',
                'sort_order' => 1,
                'title' => 'We are a custom cleaning and management service contractor.',
                'subtitle' => 'About CCMS',
                'introduction' => 'We serve each and every client with specially designed solutions to meet their unique needs.',
            ],
            [
                'section' => 'certifications',
                'sort_order' => 1,
                'title' => 'Quality you can see. Standards you can trust.',
                'subtitle' => 'Certifications & designations',
                'introduction' => 'Our certifications and designations reflect the quality, discipline and responsibility we bring to every space we serve.',
            ],
            [
                'section' => 'services',
                'sort_order' => 1,
                'title' => 'Forward-thinking solutions designed for your unique needs.',
                'subtitle' => 'Our Services',
            ],
            [
                'section' => 'sustainability',
                'sort_order' => 1,
                'title' => 'Cleaner facilities. Healthier people. A stronger tomorrow.',
                'subtitle' => 'Sustainability in Action',
                'image' => 'content/sustainability-office.jpg',
                'url' => '#contact',
                'link_label' => 'Our Approach',
            ],
            [
                'section' => 'sustainability',
                'sort_order' => 2,
                'title' => 'People well-being',
                'icon' => 'fa-people-group',
            ],
            [
                'section' => 'sustainability',
                'sort_order' => 3,
                'title' => 'Environmental Responsibility',
                'icon' => 'fa-leaf',
            ],
            [
                'section' => 'sustainability',
                'sort_order' => 4,
                'title' => 'Operational Excellence',
                'icon' => 'fa-gears',
            ],
            [
                'section' => 'partnership',
                'sort_order' => 1,
                'title' => 'Ready for a reliable partner?',
                'subtitle' => "Let's build cleaner, healthier spaces together",
                'introduction' => 'From commercial facilities to complex projects, CCMS delivers quality, compliance and exceptional service.',
                'image' => 'content/partnership-city.png',
                'url' => '#contact',
                'link_label' => 'Request a Quote',
            ],
            [
                'section' => 'impact',
                'sort_order' => 1,
                'title' => 'Getting the job done — no matter the challenge.',
                'subtitle' => 'Our Impact',
            ],
            [
                'section' => 'impact',
                'sort_order' => 2,
                'title' => '550+',
                'subtitle' => 'millions sq. ft. cleaned',
            ],
            [
                'section' => 'impact',
                'sort_order' => 3,
                'title' => '2,200+',
                'subtitle' => 'clients served',
            ],
            [
                'section' => 'impact',
                'sort_order' => 4,
                'title' => '20+',
                'subtitle' => 'years of service',
            ],
        ];

        foreach ($contents as $content) {
            Content::firstOrCreate(
                [
                    'section' => $content['section'],
                    'sort_order' => $content['sort_order'],
                ],
                array_merge($content, ['is_active' => true]),
            );
        }
    }
}
