<?php


namespace App\Repositories;


use App\Patient;
use Illuminate\Database\Eloquent\Model;

class PatientRepository
{
   protected $model;

    /**
     * PatientRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Method to get all the patients from database
     *
     * @return mixed
     */
    public function getAllPatients()
    {
        return $this->model->patients()->paginate();
    }

    /**
     * method to get only  one patient
     *
     * @param $id
     * @return mixed
     */
    public function getPatient($id)
    {
        return $this->model->patients()->find($id);
    }

    /**
     * Method to create a new patient
     *
     * @param $request
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function createPatient($data)
    {
        $patient = new Patient();
        $patient->email = $data->email;
        $patient->firstName = $data->firstName;
        $patient->lastName = $data->lastName;
        $patient->gender = $data->gender;
        $patient->numberPhone = $data->numberPhone;
        $patient->profession = $data->profession;
        $patient->password = bcrypt($data->password);
        return $this->model->patients()->save($patient);
    }

    /**
     * Method to delete patient
     *
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deletePatient($id)
    {
        $patient = $this->model->patients()->findOrFail($id);
        return $patient->delete();
    }

    /**
     * Method to update patient connected
     *
     * @param $request
     * @param $patient
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function updatePatient($request)
    {
        $this->model->email = $request['email'];
        $this->model->firstName = $request['firstName'];
        $this->model->lastName = $request['lastName'];
        //$patient->password = bcrypt($request['password']);
        $this->model->gender = $request['gender'];
        $this->model->profession = $request['profession'];
        $this->model->numberPhone = $request['numberPhone'];
        $this->model->save();
        return $this->model;
    }

}
