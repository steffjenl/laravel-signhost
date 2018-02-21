<?php
namespace Signhost;

/**
 * Class Facade
 *
 * @category  DevOps
 * @package   laravel-signhost
 * @author    Stephan Eizinga <stephan.eizinga@gmail.com>
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'signhost';
    }
}
