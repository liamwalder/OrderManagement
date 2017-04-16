<?php
namespace App\Http\Repositories;
use App\Address;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

/**
 * Class AddressRepository
 */
class AddressRepository
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        $qb = Address::whereNotNull('created_at');
        $qb = $this->applyFilters($qb);
        $addresss = $qb->get();
        return $addresss;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function findOne($id)
    {
        $address = Address::findOrFail($id);
        return $address;
    }

    /**
     * @param array $data
     * @return \App\Address
     * @throws \Exception
     */
    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            $address = new \App\Address();
            $address->fill($data);
            $address->save();
        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        return $address;
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
            $address = $this->findOne($id);
            $address->fill($data);
            $address->save();
        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        return $address;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        \DB::beginTransaction();
        try {
            $address = $this->findOne($id);
            $address->delete();
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
    public function applyFilters($queryBuilder)
    {
        $filters = Input::all();

        if (!empty($filters)) {
            foreach ($filters as $key => $value) {

                if ($key == 'between') {
                    $value = explode('/', $value);
                    $queryBuilder->whereBetween(
                        'created_at',
                        [
                            date('Y-m-d 00:00:00', strtotime($value[0])),
                            date('Y-m-d 23:23:59', strtotime($value[1]))
                        ]
                    );

                } elseif ($key == 'addresses') {

                } else {
                    $queryBuilder->where($key, $value);
                }
                
            }
        }

        return $queryBuilder;
    }

}
