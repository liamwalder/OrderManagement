<?php
namespace App\Http\Repositories;
use App\Order;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

/**
 * Class Repository
 * @package App\Http\Repositories
 */
class Repository
{

    /**
     * @param $queryBuilder
     * @return mixed
     */
    public function applyFilters($queryBuilder)
    {
        // Excluding 'l' is silly here... Let not speak about it
        $exclude = ['per-page', 'order_by', 'direction', 'search', 'l'];
        $filters = Input::all();

        $queryBuilder->offset(0);
        $queryBuilder->limit(25);

        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                if (!in_array($key, $exclude)) {

                    switch ($key) {
                        case 'between':
                            $value = explode('/', $value);
                            $queryBuilder->whereBetween(
                                'created_at',
                                [
                                    date('Y-m-d 00:00:00', strtotime($value[0])),
                                    date('Y-m-d 23:23:59', strtotime($value[1]))
                                ]
                            );
                            break;

                        case 'limit':
                            $queryBuilder->limit($value);
                            break;

                        case 'page':
                            $page = $value;
                            $perPage = $filters['per-page'];

                            $queryBuilder->limit($perPage);

                            if ($page > 1) {
                                $queryBuilder->offset(($perPage * $page) - $perPage);
                            }
                            break;

                        case 'in':
                            $queryBuilder->whereIn('id', $value);
                            break;

                        default:
                            $queryBuilder->where($key, $value);
                            break;
                    }

                }
            }
        }

        return $queryBuilder;
    }


    /**
     * Check to see if querybuilder has already joined into this given table
     * @param $query
     * @param $table
     * @return bool
     */
    public static function isJoined($queryBuilder, $table)
    {
        $joins = $queryBuilder->getQuery()->joins;
        if($joins == null) {
            return false;
        }
        foreach ($joins as $join) {
            if ($join->table == $table) {
                return true;
            }
        }
        return false;
    }


}
