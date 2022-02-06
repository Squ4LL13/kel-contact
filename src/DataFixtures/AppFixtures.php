<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Contact;
use App\Entity\LetterCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\LetterCategoryRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;
    private $letterCategoryRepository;

    public function __construct(UserPasswordHasherInterface $hasher, LetterCategoryRepository $letterCategoryRepository)
    {
        $this->hasher = $hasher;
        $this->letterCategoryRepository = $letterCategoryRepository;
    }

    private function createContact(ObjectManager $manager, $faker)
    {
        $contact = new Contact($this->letterCategoryRepository);
        $contact->setName($faker->userName())
            ->setFirstname($faker->firstname())
            ->setLastname($faker->lastname())
            ->setService($faker->word())
            ->setCompany($faker->company())
            ->setEmail($faker->email())
            ->setPhone($faker->phoneNumber())
            ->setMobile($faker->mobileNumber())
            ->setAddress($faker->address())
            ->setNote($faker->paragraph(rand(1, 3)))
            ->setStoragePlace($faker->sentence())
            ->setLink($faker->url());
        $manager->persist($contact);
        return $contact;
    }

    private function createLetterCategories(ObjectManager $manager, $letter)
    {
        $letterCategory = new LetterCategory();
        $letterCategory->setLetter($letter);
        $manager->persist($letterCategory);
    }

    public function load(ObjectManager $manager): void
    {
        $lettersArr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $letterCategoriesArr = [];
        $contactArr = [];
        
        $manager->flush();

        $user = new User();
        $password = $this->hasher->hashPassword($user, 'user');
        $user->setUsername('manon')
            ->setEmail('manon@example.com')
            ->setPassword($password);
        $manager->persist($user);

        for ($i = 0; $i < count($lettersArr); $i++) {
            $letterCategoriesArr[] = $this->createLetterCategories($manager, $lettersArr[$i]);
        }
        
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i <= 500; $i++) {
            $contactArr[] = $this->createContact($manager, $faker);
        }

        

        $manager->flush();
    }
}
