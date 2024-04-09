<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Library\Widget;
use App\Http\Controllers\CrudController;
use App\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \App\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \App\Http\Controllers\Operations\ListOperation;
    use \App\Http\Controllers\Operations\CreateOperation;
    // use \App\Http\Controllers\Operations\UpdateOperation;
    // use \App\Http\Controllers\Operations\DeleteOperation;
    use \App\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'first_name',
            'label' => 'First Name',
        ]); 
        CRUD::addColumn([
            'name' => 'last_name',
            'label' => 'Last Name',
        ]); 
        CRUD::addColumn([
            'name' => 'contact_number',
            'label' => 'Contact Number',
        ]); 
        CRUD::addColumn([
            'name' => 'roles',
            'label' => 'Roles',
        ]); 
        CRUD::addColumn([
            'name' => 'cost_center_id',
            'label' => 'Cost Center',
            'type' => 'select',
            'entity' => 'costCenter',
            'attribute' => 'name',
        ]);
        

        CRUD::setFromDb(); // set columns from db columns.
        
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
        CRUD::setValidation(UserRequest::class);
        CRUD::addField([
            'name' => 'first_name',
            'label' => 'First Name',
            'type' => 'text',
        ]); 
        CRUD::addField([
            'name' => 'last_name',
            'label' => 'Last Name',
            'type' => 'text',
        ]); 
        CRUD::addField([
            'name' => 'contact_number',
            'label' => 'Contact Number',
            'type' => 'text',
        ]); 
        CRUD::addField([
            'name' => 'email',
            'label' => 'Email',
            'type' => 'email',
        ]); 
        CRUD::addField([
            'name' => 'password',
            'label' => 'Password',
            'type' => 'password',
        ]); 
        CRUD::addField([
            'name' => 'password_confirmation',
            'label' => 'Password Confirmation',
            'type' => 'password',
        ]); 
        CRUD::addField([
            'name' => 'cost_center_id',
            'label' => 'Cost Center',
            'type' => 'select',
            'entity' => 'costCenter',
            'attribute' => 'name', 
        ]);
        
        CRUD::addField([
            'label' => 'Roles',
            'name' => 'roles',
            'type' => 'text',
            'attributes' => [
                'readonly' => 'readonly',
                'style' => 'display: none;', // Initially hidden
            ],
        ]);
        $capabilities = [
            'Admin',
            'Manager (Approved Service Request)',
            'Manager (Assign Personel)',
            'Requester (Secretary | Chairman)',
            'Personnel',
        ];

        $checkboxesHTML = '';

        foreach ($capabilities as $capability) {
            $checkboxesHTML .= '<div class="form-check form-check-inline d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" name="checkbox[]" id="capability_' . $capability . '" value="' . $capability . '" onclick="updateHiddenField()">
                                    <label class="form-check-label" for="capability_' . $capability . '">' . $capability . '</label>
                                </div>';
        }

        CRUD::addField([
            'label' => 'Capabilities',
            'type' => 'custom_html',
            'name' => 'checkbox',
            'value' => $checkboxesHTML,
            'attributes' => [
                'class' => 'capability'
            ]

        ]);

    
        Widget::add()->type('script')->content(asset('assets/js/user.js'));
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
