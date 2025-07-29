<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Song;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Utilisateurs
        $users = [];
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail($faker->unique()->email())
                ->setUsername($faker->userName())
                ->setPassword($this->hasher->hashPassword($user, 'password'));
            $manager->persist($user);
            $users[] = $user;
        }

        // Admin user
        // for ($i = 0; $i < 3; $i++) {
        //         $adminUser = new User();
        // $adminUser
        //     ->setEmail('admin@user.com')
        //     ->setRoles(['ROLE_ADMIN'])
        //     ->setPassword('admin'); 

        // $manager->persist($adminUser);
        // $users[] = $adminUser;
        // }


        // Catégories
        $categories = [];
        $categoryNames = ['Pop', 'Rock', 'Rap', 'Jazz', 'Classique'];
        foreach ($categoryNames as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $categories[] = $category;
        }

        // Chansons
        for ($i = 0; $i < 20; $i++) {
            $song = new Song();
            $song->setTitle($faker->sentence(3))
                ->setArtist($faker->name())
                ->setYoutubeLink('https://youtube.com/watch?v=' . $faker->regexify('[A-Za-z0-9_-]{11}'))
                ->setLyrics($faker->optional()->text(300))
                ->setImage($faker->optional()->imageUrl(400, 400, 'music'))
                ->setCreatedAt($faker->dateTimeBetween('-2 years'))
                ->setUploadedBy($users[array_rand($users)])
                ->setCategory($categories[array_rand($categories)]);
            $manager->persist($song);
        }

        $manager->flush();
    }
}