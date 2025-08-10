<?php

namespace App\Http\Repositories;

use App\Models\CreditTypeModel;

class CreditTypeRepository {
    public static function getCreditTypes() {
        return CreditTypeModel::select('id', 'entity_type_id', 'name') -> get();
    }
}
