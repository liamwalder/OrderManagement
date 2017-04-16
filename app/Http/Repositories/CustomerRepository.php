<?php
namespace App\Http\Repositories;

use App\Customer;
use Illuminate\Support\Facades\Input;

/**
 * Class CustomerRepository
 */
class CustomerRepository extends Repository
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        $qb = Customer::whereNotNull('customers.created_at')
                ->with('addresses');
        $qb = $this->order($qb);
        $qb = $this->applyFilters($qb);
        $qb = $this->search($qb);
        $customers = $qb->get();
        return $customers;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOne($id)
    {
        $customer = Customer::findOrFail($id);
        return $customer;
    }

    /**
     * @param array $data
     * @return \App\Customer
     * @throws \Exception
     */
    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            $customer = new \App\Customer();
            $customer->fill($data);
            $customer->save();
        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        return $customer;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function update($id, $data)
    {

        \DB::beginTransaction();
        try {
            $customer = $this->findOne($id);
            $customer->fill($data);
            $customer->save();
        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        return $customer;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        \DB::beginTransaction();
        try {
            $customer = $this->findOne($id);
            $customer->delete();
        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }

    /**
     * @param $queryBuilder
     * @return mixed
     */
    public function search($queryBuilder)
    {
        if (Input::has('search')) {
            $value = Input::get('search');
            $queryBuilder->where('customers.firstname', 'like', '%'.$value.'%');
            $queryBuilder->orWhere('customers.surname', 'like', '%'.$value.'%');
            $queryBuilder->orWhere('customers.email', 'like', '%'.$value.'%');

            $queryBuilder->leftJoin('addresses', 'customers.id', '=', 'addresses.customer_id');
            $queryBuilder->orWhere('addresses.address_1', 'like', '%'.$value.'%');
            $queryBuilder->orWhere('addresses.address_2', 'like', '%'.$value.'%');
            $queryBuilder->orWhere('addresses.town', 'like', '%'.$value.'%');
            $queryBuilder->orWhere('addresses.county', 'like', '%'.$value.'%');
            $queryBuilder->orWhere('addresses.postcode', 'like', '%'.$value.'%');

            $queryBuilder->groupBy('customers.id');
        }
        return $queryBuilder;
    }

    /**
     * @param $queryBuilder
     * @return mixed
     */
    public function order($queryBuilder)
    {
        $orderBy = Input::get('order_by');
        if ($orderBy) {
            $orderDirection = Input::get('direction');
            switch ($orderBy) {
                case 'addresses':
                    $queryBuilder
                        ->leftJoin('addresses', 'customers.id', '=', 'addresses.customer_id')
                        ->groupBy('customers.id')
                        ->orderBy('address_1', $orderDirection);
                    break;

                default:
                    $queryBuilder->orderBy($orderBy, $orderDirection);
                    break;
            }
        }
        return $queryBuilder;
    }

}
