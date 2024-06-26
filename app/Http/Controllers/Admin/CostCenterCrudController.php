<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CostCenterRequest;
use App\Http\Controllers\CrudController;
use App\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CostCenterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \App\Library\CrudPanel\CrudPanel $crud
 */
class CostCenterCrudController extends CrudController
{
    use \App\Http\Controllers\Operations\ListOperation;
    use \App\Http\Controllers\Operations\CreateOperation;
    use \App\Http\Controllers\Operations\UpdateOperation;
    use \App\Http\Controllers\Operations\DeleteOperation;
    use \App\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\CostCenter::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cost-center');
        CRUD::setEntityNameStrings('cost center', 'cost centers');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.
        CRUD::addColumn([
            'name' => 'code',
            'label' => 'Code',
        ]);
        CRUD::addColumn([
            'name' => 'name',
            'label' => 'Cost Center Name',
        ]);
        CRUD::addColumn([
            'name' => 'created_at',
            'label' => 'Date Created',
        ]);

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CostCenterRequest::class);
        CRUD::addField([
            'name' => 'name',
            'label' => 'Cost Center Name',
        ]);

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
