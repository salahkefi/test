<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../src/Entity/Destination.php';
require_once __DIR__ . '/../src/Entity/Quote.php';
require_once __DIR__ . '/../src/Entity/Site.php';
require_once __DIR__ . '/../src/Entity/Template.php';
require_once __DIR__ . '/../src/Entity/User.php';
require_once __DIR__ . '/../src/Helper/SingletonTrait.php';
require_once __DIR__ . '/../src/Context/ApplicationContext.php';
require_once __DIR__ . '/../src/Repository/Repository.php';
require_once __DIR__ . '/../src/Repository/DestinationRepository.php';
require_once __DIR__ . '/../src/Repository/QuoteRepository.php';
require_once __DIR__ . '/../src/Repository/SiteRepository.php';
require_once __DIR__ . '/../src/TemplateManager.php';
require_once __DIR__ . '/../src/UserProcess.php';
require_once __DIR__ . '/../src/QuoteProcess.php';

$faker = \Faker\Factory::create();

$template = new Template(
    1,
    'Votre voyage avec une agence locale [quote:destination_name]',
    "
Bonjour [user:first_name],<br><br>

Merci d'avoir contacté un agent local pour votre voyage [quote:destination_name].<br><br>

Bien cordialement,<br><br>

L'équipe Evaneos.com<br>
www.evaneos.com<br>
");
$templateManager = new TemplateManager();

$message = $templateManager->getTemplateComputed(
    $template,
    [
        'quote' => new Quote($faker->randomNumber(), $faker->randomNumber(), $faker->randomNumber(), $faker->date())
    ]
);

echo $message->subject . "\n<br>" . $message->content;
