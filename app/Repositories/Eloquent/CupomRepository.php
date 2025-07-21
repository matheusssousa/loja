<?php

namespace App\Repositories\Eloquent;

use App\Models\Cupom;

class CupomRepository extends BaseRepository
{
    public function __construct(Cupom $model)
    {
        parent::__construct($model);
    }
}
