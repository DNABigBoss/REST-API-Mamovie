<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Movie extends RESTController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Movies_model', 'movies');
    }

    public function index_get()
    {
        $id = $this->get('id');
        $s = $this->get('s');

        if ($id === null && $s === null) {
            $movies = $this->movies->getMovie();
        } elseif ($id !== null && $s !== null) {
            $this->response([
                'status' => false,
                'message' => 'Bad Request data'
            ], 400);
        } else {
            if($s != null) {
                $movies = $this->movies->getMovie($id = null, $s);
            } else {
                $movies = $this->movies->getMovie($id);
            }
        }

        if ($movies) {
            // Set the response and exit
            $this->response($movies, 200);
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
            'name' => $this->post('name'),
            'status' => $this->post('status'),
            'rate' => $this->post('rate'),
        ];

        if ($this->movies->createMovie($data) > 0) {
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
        $id = $this->put('id');
        $data = [
            'name' => $this->put('name'),
            'status' => $this->put('status'),
            'rate' => $this->put('rate'),
        ];

        if ($this->movies->updateMovie($data, $id) > 0) {
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
        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'Provide an id'
            ], 400);
        } else {
            if ($this->movies->deleteMovie($id) > 0) {
                // Success
                $this->response([
                    'status' => true,
                    'id' => $id,
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
