<?php


class QuoteProcess
{
    use SingletonTrait;
    /**
     * Methode pour gérer tout les placeholders de type quote
     * @param string $text
     * @param Quote $quote
     * @return string $text
     */
    public function computeText($text, $quote)
    {
        if ($quote)
        {
            $_quoteFromRepository = QuoteRepository::getInstance()->getById($quote->id);
            $usefulObject = SiteRepository::getInstance()->getById($quote->siteId);
            $destinationOfQuote = DestinationRepository::getInstance()->getById($quote->destinationId);

            $text = $this->patternsSummaryHtml($text,'[quote:summary_html]', $_quoteFromRepository);
            $text = $this->patternsSummary($text,'[quote:summary]', $_quoteFromRepository);
            $text = $this->patternsDestinationName($text,'[quote:destination_name]', $destinationOfQuote->countryName);
            $text = $this->patternsDestinationLink($text,'[quote:destination_link]', $destinationOfQuote->countryName,$usefulObject->url,$_quoteFromRepository->id);
        }
        return $text;
    }

    /**
     * Méthode pour gérer les placeholders de type [quote:summary_html]
     * @param string $text
     * @param string $pattern
     * @param Quote $quote
     * @return string $text
     */
    private function patternsSummaryHtml($text,$pattern,$quote)
    {
        $containsSummary = strpos($text, $pattern);
        if ($containsSummary !== false) {
            $text = str_replace(
                '[quote:summary_html]',
                Quote::renderHtml($quote),
                $text
            );
        }
        return $text;
    }

    /**
     * Méthode pour gérer les placeholders de type [quote:summary]
     * @param string $text
     * @param string $pattern
     * @param Quote $quote
     * @return string $text
     */
    private function patternsSummary($text,$pattern,$quote)
    {
        $containsSummary = strpos($text, $pattern);
        if ($containsSummary !== false) {
            $text = str_replace(
                '[quote:summary]',
                Quote::renderText($quote),
                $text
            );
        }
        return $text;
    }

    /**
     * @param string $text
     * @param string $pattern
     * @param string $countryName
     * @return string $text
     */
    private function patternsDestinationName($text,$pattern,$countryName)
    {
        (strpos($text, $pattern) !== false) and $text = str_replace($pattern,$countryName,$text);
        return $text;
    }


    /**
     * @param string $text
     * @param string $pattern
     * @param string $countryName
     * @param string $url
     * @param integer $id
     * @return string|string[] $text;
     */
    private function patternsDestinationLink($text,$pattern,$countryName,$url,$id)
    {
        if (strpos($text, $pattern) !== false)
            $text = str_replace($pattern, $url . '/' . $countryName . '/quote/' . $id, $text);
        else
            $text = str_replace($pattern, '', $text);
        return $text;
    }
}