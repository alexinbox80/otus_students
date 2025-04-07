<?php

namespace App\Controller\Web\Sales\Customer\v1;

use alexinbox80\StudentsSalesBundle\Presentation\Contract\SalesInterface;
use App\Controller\Web\Sales\Customer\v1\Input\CustomerDTO;
use App\Controller\Web\Sales\Customer\v1\Output\IsCustomerDTO;

class Manager
{
    public function __construct(
        private SalesInterface $sales,
    ) {
    }

    public function customer(CustomerDTO $customerDTO): IsCustomerDTO
    {
//        try {
            $customerId = $this->sales->customer(
                $customerDTO->studentId,
                $customerDTO->firstName,
                $customerDTO->lastName,
                $customerDTO->email
            );
//        } catch (\Exception $e) {
//            // TODO Handle
//            throw new $e;
//        }

        return new IsCustomerDTO(
            true,
            $customerId
        );
    }
}
