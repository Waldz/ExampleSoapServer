<?php

namespace ZendExtensions\Form;

use Zend\Form\Exception;
use Zend\Form\Form as ZendForm;

class Form
    extends ZendForm
{

    /**
     * Binds POST data to hydrator object, and validator can use that object in validation
     */
    const BIND_BEFORE_VALIDATE = 'before-validate';

    /**
     * {@inheritdoc}
     */
    public function setBindOnValidate($bindOnValidateFlag)
    {
        $possibleValues = array(
            self::BIND_ON_VALIDATE,
            self::BIND_MANUAL,
            self::BIND_BEFORE_VALIDATE,
        );
        if (!in_array($bindOnValidateFlag, $possibleValues)) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects the flag to be one of %s::%s or %s::%s or %s::%s',
                __METHOD__,
                get_class($this),
                'BIND_ON_VALIDATE',
                get_class($this),
                'BIND_MANUAL',
                get_class($this),
                'BIND_BEFORE_VALIDATE'
            ));
        }
        $this->bindOnValidate = $bindOnValidateFlag;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data)
    {
        parent::setData($data);

        if(self::BIND_BEFORE_VALIDATE === $this->bindOnValidate) {
            $hydrator = $this->getHydrator();
            $hydrator->hydrate($this->data, $this->object);
        }

        return $this;
    }


}
