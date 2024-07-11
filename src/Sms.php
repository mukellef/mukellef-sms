<?php

namespace Mukellef\Sms;

use Mukellef\Sms\Exceptions\DriverConfigurationException;
use Mukellef\Sms\Exceptions\DriverNotFoundException;

class Sms
{

    private $driver;


    public function __construct($driver = null, array $config = [])
    {

        $this->configureDriver($driver, $config);
    }


    public function driver($driver = null, array $config = [])
    {

        $this->configureDriver($driver, $config);
    }


    private function configureDriver(?string $driver, array $config)
    {

        $smsConfig = $config === [] && function_exists('config') ? config('sms') : [];

        if ($driver === null && !empty($smsConfig)) {
            $driver = $smsConfig['default_driver'];
        }

        if ($config === [] && function_exists('config')) {
            $config = config('sms.' . $driver);
        }

        try {
            $driverClass  = "\\Mukellef\\Sms\\Drivers\\{$driver}";
            $this->driver = new $driverClass($driver, $config);
        } catch (DriverConfigurationException $e) {
            throw new DriverConfigurationException($e);
        } catch (DriverNotFoundException $e) {
            throw new DriverConfigurationException($e);
        }
    }


    /**
     * @param $message string
     * @param $numbers array
     * @param $header string  SMS HEADER
     */
    public function send(string $message, array $numbers, string $header, ?string $valid_for = '24:00'): void
    {

        $this->driver->send($message, $numbers, $header, $valid_for);
    }
}
