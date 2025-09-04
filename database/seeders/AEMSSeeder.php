<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Event;
use App\Models\Media;
use Illuminate\Support\Facades\Hash;

class AEMSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Administrateur AEMS',
            'email' => 'admin@aems.sn',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+221 77 123 45 67',
            'address' => 'Dakar, Sénégal',
            'status' => 'active',
            'bio' => 'Administrateur principal de la plateforme AEMS',
            'email_verified_at' => now(),
        ]);

        // Create Member Users
        $member1 = User::create([
            'name' => 'Mariama Diallo',
            'email' => 'mariama@aems.sn',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '+221 77 234 56 78',
            'address' => 'Thiès, Sénégal',
            'status' => 'active',
            'bio' => 'Membre actif de l\'AEMS, étudiante en informatique',
            'email_verified_at' => now(),
        ]);

        $member2 = User::create([
            'name' => 'Amadou Ba',
            'email' => 'amadou@aems.sn',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '+221 77 345 67 89',
            'address' => 'Saint-Louis, Sénégal',
            'status' => 'active',
            'bio' => 'Membre de l\'AEMS, étudiant en médecine',
            'email_verified_at' => now(),
        ]);

        // Create Sample Posts
        $posts = [
            [
                'title' => 'Bienvenue sur la plateforme AEMS',
                'content' => 'Nous sommes ravis de vous accueillir sur notre nouvelle plateforme web. Cette plateforme vous permettra de découvrir l\'histoire de notre association, de consulter nos archives photos et vidéos, et de rester informé de nos activités.',
                'excerpt' => 'Découvrez notre nouvelle plateforme web dédiée à l\'Association des Étudiants de Mitsoudjé au Sénégal.',
                'category' => 'actualites',
                'tags' => ['bienvenue', 'plateforme', 'aems'],
                'status' => 'published',
                'published_at' => now(),
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Assemblée Générale 2024',
                'content' => 'L\'assemblée générale annuelle de l\'AEMS s\'est tenue le 15 janvier 2024. De nombreuses décisions importantes ont été prises pour l\'année à venir, notamment l\'organisation de nouvelles activités culturelles et académiques.',
                'excerpt' => 'Retour sur l\'assemblée générale annuelle de l\'AEMS qui s\'est tenue en janvier 2024.',
                'category' => 'actualites',
                'tags' => ['assemblée', 'générale', '2024'],
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'user_id' => $member1->id,
            ],
            [
                'title' => 'Programme d\'aide aux étudiants',
                'content' => 'L\'AEMS lance un nouveau programme d\'aide aux étudiants en difficulté. Ce programme comprend un soutien financier, des cours de rattrapage et un accompagnement personnalisé.',
                'excerpt' => 'Découvrez le nouveau programme d\'aide aux étudiants mis en place par l\'AEMS.',
                'category' => 'social',
                'tags' => ['aide', 'étudiants', 'soutien'],
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'user_id' => $member2->id,
            ],
        ];

        foreach ($posts as $postData) {
            Post::create($postData);
        }

        // Create Sample Events
        $events = [
            [
                'title' => 'Journée Culturelle AEMS 2024',
                'description' => 'Une journée dédiée à la culture de Mitsoudjé avec des danses traditionnelles, des chants, des expositions et des dégustations de plats locaux.',
                'start_date' => now()->addDays(30),
                'end_date' => now()->addDays(30)->addHours(8),
                'location' => 'Centre Culturel de Dakar',
                'event_type' => 'culturelle',
                'status' => 'upcoming',
                'user_id' => $admin->id,
                'max_participants' => 200,
                'registration_required' => true,
                'registration_deadline' => now()->addDays(25),
            ],
            [
                'title' => 'Conférence sur l\'entrepreneuriat',
                'description' => 'Conférence animée par des entrepreneurs sénégalais sur les opportunités d\'affaires et l\'entrepreneuriat au Sénégal.',
                'start_date' => now()->addDays(45),
                'end_date' => now()->addDays(45)->addHours(3),
                'location' => 'Université Cheikh Anta Diop',
                'event_type' => 'academique',
                'status' => 'upcoming',
                'user_id' => $member1->id,
                'max_participants' => 100,
                'registration_required' => true,
                'registration_deadline' => now()->addDays(40),
            ],
            [
                'title' => 'Action de solidarité - Distribution de kits scolaires',
                'description' => 'Distribution de kits scolaires aux enfants de Mitsoudjé dans le cadre de nos actions de solidarité.',
                'start_date' => now()->addDays(60),
                'end_date' => now()->addDays(60)->addHours(6),
                'location' => 'Mitsoudjé, Sénégal',
                'event_type' => 'sociale',
                'status' => 'upcoming',
                'user_id' => $member2->id,
                'max_participants' => 50,
                'registration_required' => true,
                'registration_deadline' => now()->addDays(55),
            ],
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }

        // Create Past Events
        $pastEvents = [
            [
                'title' => 'Assemblée Générale 2023',
                'description' => 'Assemblée générale annuelle de l\'AEMS pour l\'année 2023.',
                'start_date' => now()->subDays(365),
                'end_date' => now()->subDays(365)->addHours(4),
                'location' => 'Dakar, Sénégal',
                'event_type' => 'sociale',
                'status' => 'completed',
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Festival Culturel 2023',
                'description' => 'Festival culturel annuel de l\'AEMS avec des performances artistiques et culturelles.',
                'start_date' => now()->subDays(300),
                'end_date' => now()->subDays(300)->addHours(8),
                'location' => 'Thiès, Sénégal',
                'event_type' => 'culturelle',
                'status' => 'completed',
                'user_id' => $member1->id,
            ],
        ];

        foreach ($pastEvents as $eventData) {
            Event::create($eventData);
        }

        $this->command->info('AEMS seeder completed successfully!');
        $this->command->info('Admin user: admin@aems.sn / password');
        $this->command->info('Member users: mariama@aems.sn / password, amadou@aems.sn / password');
    }
}
