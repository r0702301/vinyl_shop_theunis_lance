<?php


namespace App\Helpers;

use Illuminate\Support\HtmlString;
class Mask
{
    /**
     *  Obfuscate mail address
     *
     * @param string $email
     * @param string $name
     * @return HtmlString
     */
    public function email($email, $name = null)
    {
        $name = $this->obfuscate($name ?: $email);
        $email = $this->obfuscate('mailto:' . $email);
        return new HtmlString('<a href="' . $email . '">' . $name . '</a>');
    }
    public function tel($tel, $name = null)
    {
        $name = $this->obfuscate($name ?: $tel);
        $tel = $this->obfuscate('telto:' . $tel);
        return new HtmlString('<a href="' . $tel . '">' . $name . '</a>');
    }
    public function sms($sms, $name = null)
    {
        $name = $this->obfuscate($name ?: $sms);
        $sms = $this->obfuscate('smsto:' . $sms);
        return new HtmlString('<a href="' . $sms . '">' . $name . '</a>');
    }

    private function obfuscate($str)
    {
        $safe = '';
        foreach (str_split($str) as $char) {
            if (ord($char) > 128) {
                return $char;
            }
            switch (rand(1, 3)) {
                case 1:    // decimal
                    $safe .= '&#' . ord($char) . ';';
                    break;
                case 2:    // hexadecimal
                    $safe .= '&#x' . dechex(ord($char)) . ';';
                    break;
                case 3:
                    $safe .= $char;
            }
        }
        return $safe;
    }
}
