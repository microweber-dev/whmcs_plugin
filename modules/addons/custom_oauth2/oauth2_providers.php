<?php

require_once 'exceptions.php';

const PROVIDER_MICROWEBER = 'Microweber oAuth';

function get_oauth_providers()
{
	return join(',', array(PROVIDER_MICROWEBER));
}

/**
 * @param $provider string oauth provider
 * @return OAuthProvider
 * @throws BusinessException
 */
function get_oauth_provider($provider)
{
    switch ($provider) {
    	case PROVIDER_MICROWEBER:
            return new MicroweberProvider();
        default:
            throw new BusinessException('Unknown provider: ' . $provider);
    }
}

/**
 * This class will be used to parse the identity of the user, so data like email, address, phone can be prefilled when first logging in with an OAuth service.
 */
abstract class OAuthProvider
{
    /**
     * @var array identity is an object containing user information for a specific OAuth provider
     */
    protected $identity;


    function __construct()
    {
    }

    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    abstract public function isAuthorized($requested_scope, $token);

    abstract public function getEmail();

    abstract public function getPhone();

    abstract public function getAddress();

    abstract public function getCountry();

    abstract public function getCity();

    abstract public function getState();

    abstract public function getPostcode();

    abstract public function getFirstName();

    abstract public function getLastName();

}


class MicroweberProvider extends OAuthProvider
{
    protected function getFirstSetting($property)
    {
        if (isset($this->identity[$property])) {
            return $this->identity[$property][0];
        }
        return false;
    }

    protected function getNestedSetting($property, $sub_property)
    {
        $address_info = $this->getFirstSetting($property);
        if ($address_info && isset($address_info[$sub_property])) {
            return $address_info[$sub_property];
        }
        return null;
    }

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Checks if $token['scope'] has the nessecary scopes to login
     * @param $requested_scope string scope configured by the settings
     * @param $token array
     * @return bool
     */
    public function isAuthorized($requested_scope, $token)
    {
        // Check if $token['scope'] contains user:memberof:organization:{organization} if $scope contains user:memberof:{organization}
        $token_scope = $token['scope'];
        if (strpos($requested_scope, 'user:memberof:') === false) {
            return true;
        }
        $scopes = explode(",", $token_scope);
        foreach ($scopes as $scope) {
            if (strpos($scope, 'user:memberof:') !== false && strpos($requested_scope, $scope) !== false) {
                return true;
            }
        }

        return false;
    }

    public function getEmail()
    {
        $email = $this->getNestedSetting('emailaddresses', 'emailaddress', 'email');
        if (!$email || $email == '' || $email == null) {
            $email = $this->identity['email'];
        }

        if (!$email || $email == '' || $email == null) {
            $email = 'members+' . $this->identity['id'] . '@microweber.com';
        }

        return $email;
    }

    public function getPhone()
    {
        return preg_replace('/[^0-9]/', '', str_replace('+', '00', $this->getFirstSetting('phone')));
    }

    public function getAddress()
    {
        $street = $this->getNestedSetting('addresses', 'street');
        $number = $this->getNestedSetting('addresses', 'nr');
        
        return sprintf('%s %s', $street, $number);
    }

    public function getCountry()
    {
        // We need a 2 letter code, and the full country name is returned
        return null;
    }

    public function getCity()
    {
        return $this->getNestedSetting('addresses', 'city');
    }

    public function getState()
    {
        return null;
    }

    public function getPostcode()
    {
        return $this->getNestedSetting('addresses', 'postalcode');
    }

    public function getFirstName()
    {
        $firstname = $this->identity['firstname'];
        if ($firstname == '') {
            if (isset($this->identity['name'])) {
                $explode = explode(' ', $this->identity['name']);
                if ($explode[0]) {
                    $firstname = $explode[0];
                }
            }
        }

        if ($firstname == '') {
            $firstname = $this->identity['username'];
        }

		return $firstname;
	}

    public function getLastName()
    {
        $firstname = $this->identity['lastname'];
        if ($firstname == '') {
            if (isset($this->identity['name'])) {
                $explode = explode(' ', $this->identity['name']);
                if ($explode[1]) {
                    $firstname = $explode[1];
                }
            }
        }

        return $firstname;
    }
}
