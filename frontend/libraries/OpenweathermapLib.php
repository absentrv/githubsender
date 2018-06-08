<?php
namespace frontend\libraries;

/**
 * Description of OpenweathermapApi
 *
 * @author Serhii Filoniuk
 */
class OpenweathermapLib
{

    private $apiKey = '55696ac03e882c5c6e424a32a6777fc3';
    private $apiUrl = 'http://api.openweathermap.org/data/2.5/weather?q=';
    private $client;

    public function __construct(\yii\base\Component $client)
    {
        $this->client = $client;
    }

    public function getWeather($location)
    {
        $response = $this->client->createRequest()
            ->setMethod('get')
            ->setHeaders([
                'User-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36',
            ])
            ->setUrl($this->apiUrl . $location . '&appid=' . $this->apiKey)
            ->send(); 
  
        if ($response->isOk) {
            return json_decode($response->content);
        }
        return false;
    }
}
