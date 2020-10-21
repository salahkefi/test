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
            $text = $this->patternsFirstName($text, '[user:first_name]', $user->firstname);
        }
        return $text;
    }

    /**
     * @param string $text
     * @param string $pattern
     * @param string $firstName
     * @return string|string[] $text
     */
    private function patternsFirstName($text,$pattern,$firstName)
    {
        (strpos($text, $pattern) !== false) and $text = str_replace($pattern, ucfirst(mb_strtolower($firstName)), $text);
        return $text;
    }
}