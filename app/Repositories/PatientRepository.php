<?php


namespace App\Repositories;


use App\Nutritionist;
use App\Patient;

class PatientRepository
{
    protected $nutritionist;

    /**
     * PatientRepository constructor.
     * @param Nutritionist $nutritionist
     */
    public function __construct(Nutritionist $nutritionist)
    {
        $this->nutritionist = $nutritionist;
    }

    /**
     * Method to get all the patients from database
     *
     * @return mixed
     */
    public function getAllPatients()
    {
        return $this->nutritionist->patients()->paginate();
    }

    /**
     * method to get only  one patient
     *
     * @param $id
     * @return mixed
     */
    public function getPatient($id)
    {
        return $this->nutritionist->patients()->find($id);
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
        return $this->nutritionist->patients()->save($patient);
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
        $patient = $this->nutritionist->patients()->findOrFail($id);
        return $patient->delete();
    }

}
