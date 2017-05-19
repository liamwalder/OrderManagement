<?php
namespace App\Http\Repositories;
use App\User;

/**
 * Class UserRepository
 */
class UserRepository
{

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        $users = User::all();
        return $users;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function findWhere($key, $value)
    {
        $user = User::where($key, $value)->get();
        return $user;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOne($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    /**
     * @param array $data
     * @return \App\User
     * @throws \Exception
     */
    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            $user = new \App\User();
            $user->fill($data);
            $user->save();
        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        return $user;
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
            $user = $this->findOne($id);
            $user->fill($data);
            $user->save();
        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        return $user;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        \DB::beginTransaction();
        try {
            $user = $this->findOne($id);
            $user->delete();
        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();
    }



}
