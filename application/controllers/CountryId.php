<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class CountryId extends RESTController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('CountryId_model', 'countryid');
    }

    public function index_get()
    {
        $id = $this->get('code');
        $s = $this->get('name');

        if ($id === null && $s === null) {
            $countryid = $this->countryid->getCountryId();
        } elseif ($id !== null && $s !== null) {
            $this->response([
                'status' => false,
                'message' => 'Bad Request data'
            ], 400);
        } else {
            if($s != null) {
                $countryid = $this->countryid->getCountryId($id = null, $s);
            } else {
                $countryid = $this->countryid->getCountryId($id);
            }
        }

        if ($countryid) {
            // Set the response and exit
            $this->response($countryid, 200);
        } else {
            // Set the response and exit
            $this->response([
                'status' => false,
                'message' => 'No Movie were found'
            ], 404);
        }
    }

    public function index_post()
    {
        $data = [
            'code' => $this->post('code'),
            'name' => $this->post('name'),
        ];

        if ($this->countryid->createCountryId($data) > 0) {
            // Success
            $this->response([
                'status' => true,
                'message' => 'Successfully Created'
            ], 201);
        } else {
            // id not found
            $this->response([
                'status' => false,
                'message' => 'Fail created new data'
            ], 400);
        }
    }

    public function index_put()
    {
        $id = $this->put('code');
        $data = [
            'name' => $this->put('name'),
        ];

        if ($this->countryid->updateCountryId($data, $id) > 0) {
            // Success
            $this->response([
                'status' => true,
                'message' => 'Successfully Updated'
            ], 202);
        } else {
            // id not found
            $this->response([
                'status' => false,
                'message' => 'Fail updated data'
            ], 400);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('code');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide an id'
            ], 400);
        } else {
            if ($this->countryid->deleteCountryId($id) > 0) {
                // Success
                $this->response([
                    'status' => true,
                    'code' => $id,
                    'message' => 'Successfully deleted'
                ], 204);
            } else {
                // id not found
                $this->response([
                    'status' => false,
                    'message' => 'Id not found'
                ], 400);
            }
        }
    }
}
