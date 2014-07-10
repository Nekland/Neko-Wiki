<?php

namespace App\Provider;


class WikiParameterProvider
{
    /**
     * @var array
     */
    private $parameters;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @param  string $name
     * @return string
     * @throws \InvalidArgumentException
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->parameters)) {
            return $this->parameters[$name];
        }

        throw new \InvalidArgumentException(sprintf('The parameter "%" doesn\'t exists in the wiki configuration.', $name));
    }

    function __isset($name)
    {
        return array_key_exists($name, $this->parameters);
    }
}
