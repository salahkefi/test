<?php


class UserProcess
{
    use SingletonTrait;
    /**
     * Methode pour gérer tout les placeholders de type user
     * @param string $text
     * @param User $user
     * @return string $text
     */
    public function computeText($text, $user)
    {

        if($user) {
            (strpos($text, '[user:first_name]') !== false) and $text = str_replace('[user:first_name]', ucfirst(mb_strtolower($user->firstname)), $text);
        }
        return $text;

    }
}