<?php
namespace frontend\modules\api\v1\models;

use frontend\libraries\GithubLib;
use frontend\libraries\OpenweathermapLib;
use yii\base\Model;
use yii\httpclient\Client;

/**
 * Description of SendMessageModel
 *
 * @author Sergiy Filonyuk
 */
class SendMessageModel extends Model
{

    public $users;
    public $message;

    public function rules()
    {
        return [
            [['message', 'users'], 'required'],
            ['message', 'string'],
            ['users', 'each', 'rule' => ['string', 'max' => 50]]
        ];
    }

    public function sendLetters()
    {
        $client = new Client();
        $gitHubApi = new GithubLib($client);
        $weatherLib = new OpenweathermapLib($client);
        foreach ($this->users as $key => $one) {
            $gitHubInfo = $gitHubApi->getUserInfo($one);
            if (!$gitHubInfo || empty($gitHubInfo->email)) {
                $this->addError("users", "User `{$one}` not found :( OR doesn`t has public email'");
                continue;
            }
            $weatherInfo = $weatherLib->getWeather($gitHubInfo->location);

            $email = $this->getEmailText($weatherInfo);
            $headers = $this->getHeaders();
            mail($gitHubInfo->email, 'This message has been sended via GitHubSender APP', $email, $headers);
        }
    }

    private function getEmailText($weatherInfo)
    {
        if ($weatherInfo) {
            $weather = $this->getWetherString($weatherInfo);
        }
        $email = '<html><head><meta http-equiv="Content-Type"  content="text/html charset=UTF-8" /></head><body>';
        $email .= $this->message;
        if (!empty($weather)) {
            $email .= '<br>-----------------<br>' . $weather;
        }
        $email .= '</body></html>';
        return $email;
    }

    private function getWetherString($weather)
    {
        $tempC = $weather->main->temp - 273.15;
        $result = <<<TEXT
            Weather in the {$weather->name}: <br>
            Temp(c): {$tempC} <br>
            Pressure: {$weather->main->pressure} <br>
            Humidity: {$weather->main->humidity}
TEXT;
        return $result;
    }

    private function getHeaders()
    {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        return $headers;
    }
}
