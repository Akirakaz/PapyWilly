<?php

namespace App\DataFixtures;

use App\Entity\Settings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SettingsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $settings = new Settings();
        $settings->setSettingKey('settings');
        $settings->setChannelCountry('France');
        $settings->setChannelPlatforms('PC');

        $manager->persist($settings);
        $manager->flush();
    }
}
