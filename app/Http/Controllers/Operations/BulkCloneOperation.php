<?php

namespace App\Http\Controllers\Operations;

use App\Exceptions\BackpackProRequiredException;

if (! backpack_pro()) {
    trait BulkCloneOperation
    {
        public function setupBulkCloneOperationDefaults()
        {
            throw new BackpackProRequiredException('BulkCloneOperation');
        }
    }
} else {
    trait BulkCloneOperation
    {
        use \Backpack\Pro\Http\Controllers\Operations\BulkCloneOperation;
    }
}
