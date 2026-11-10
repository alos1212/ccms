<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Commercial Facility Services',
                'subtitle' => 'Spaces that work better.',
                'slug' => 'commercial-facility-services',
                'icon' => 'fa-building',
                'introduction' => 'Reliable cleaning programs for offices, campuses and commercial facilities.',
                'description' => '<p>We create consistent cleaning programs that protect your facilities, support your teams and keep every space ready for the people who use it.</p>',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Construction Cleaning',
                'subtitle' => 'Ready for what comes next.',
                'slug' => 'construction-cleaning',
                'icon' => 'fa-helmet-safety',
                'introduction' => 'Detailed post-construction cleaning that helps teams move into a finished space with confidence.',
                'description' => '<p>From rough cleans to final detailing, our crews prepare newly built and renovated spaces for their next chapter.</p>',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Remediation and Specialty',
                'subtitle' => 'Expert care for complex spaces.',
                'slug' => 'remediation-and-specialty',
                'icon' => 'fa-droplet',
                'introduction' => 'Specialized cleaning and remediation support for demanding environments and sensitive situations.',
                'description' => '<p>Our trained teams use careful processes, the right equipment and documented standards to restore spaces safely.</p>',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Government Facilities',
                'subtitle' => 'Compliance you can count on.',
                'slug' => 'government-facilities',
                'icon' => 'fa-landmark',
                'introduction' => 'Dependable facility services designed for public-sector standards, security and accountability.',
                'description' => '<p>We help government facilities maintain clean, safe and professional environments through reliable service and reporting.</p>',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
