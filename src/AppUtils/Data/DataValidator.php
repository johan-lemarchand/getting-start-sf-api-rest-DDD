<?php


namespace App\AppUtils\Data;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class DataValidator
{

    /**
     * @var Request 
     */
    private Request $_request;

    /**
     * @var ValidatorInterface 
     */
    private ValidatorInterface $_validator;

    /**
     * @var array 
     */
    private array $_violations;

    public function __construct(Request $request, ValidatorInterface $validator)
    {
        $this->_validator = $validator;
        $this->_request = $request;
        $this->_violations = array();
    }

    public function isValid(array $data): bool
    {
        $dataRequest = json_decode($this->_request->getContent(), true);
        foreach ($data as $key => $value) {
            $requestValue = $dataRequest[$key];

            $errorsRequest= $this->_validator->validate($requestValue, $value);

            foreach ($errorsRequest as $errorRequest) {
                $this->_violations[] = array(
                    $key => $errorRequest->getMessage()
                );
            }
        }

        if (\Count($this->_violations) >0) {
            return false;
        }

        return true;
    }

    public function getViolations(): array
    {
        return $this->_violations;
    }
}