<?php
namespace AppBundle\Handler;

use AppBundle\Exception\InvalidFormException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;


class ParcelOrderFormHandler
{
    private $entityClass;
    private $repository;
    private $formFactory;
    private $formType;

    function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory, $formType)
    {
        $this->entityClass = $entityClass;
        $this->repository = $om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
        $this->formType = $formType;
    }

    function post(array $parameters)
    {
        $entity = $this->createEntity();
        return $this->processForm($entity, $parameters, 'POST');
    }
	
	public function put($parcel, array $parameters)
	{
		return $this->processForm($parcel, $parameters, 'PUT');
	}


    private function processForm($entity, $parameters, $method)
    {
        $form = $this->formFactory->create($this->formType, $entity, array('method' => $method));

        $form->submit($parameters, 'PATCH' !== $method);

        if (!$form->isValid())
        {
            throw new InvalidFormException('Invalid submitted data', $form);
        }

        $note = $form->getData();
        $this->repository->save($entity);
        return $entity;
    }

    private function createEntity()
    {
        return new $this->entityClass();
    }
}
