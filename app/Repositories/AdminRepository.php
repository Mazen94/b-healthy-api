<?php


namespace App\Repositories;

use App\Admin;
use App\Nutritionist;
use Illuminate\Database\Eloquent\Model;

class AdminRepository
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * show Patients related to nutritionist
     * @param int $page
     * @param int $perPage
     * @param string $orderBy
     * @param string $orderDirection
     *
     * @return LengthAwarePaginator
     */
    public static function paginateNutritionists($page, $perPage, $orderBy, $orderDirection)
    {
        $nutritionistsGroups = new Nutritionist();
        if (isset($orderBy) && isset($orderDirection)) {
            $nutritionistsGroups =  Nutritionist::orderBy($orderBy, $orderDirection);
        }
        return $nutritionistsGroups->paginate($perPage, ['*'], 'page', $page);
    }

}
