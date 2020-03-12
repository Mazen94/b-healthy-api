<?php


namespace App\Repositories;


use App\Patient;
use Illuminate\Database\Eloquent\Model;


class PatientRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Method to create a new patient related to patient
     *
     *
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $password
     * @param string $gender
     * @param string $numberPhone
     * @param string $profession
     * @return false|Model
     */
    public function createPatient(
        $email,
        $firstName,
        $lastName,
        $password,
        $gender,
        $numberPhone,
        $profession
    ) {
        $patient = new Patient();
        $patient->email = $email;
        $patient->firstName = $firstName;
        $patient->lastName = $lastName;
        $patient->gender = $gender;
        $patient->numberPhone = $numberPhone;
        $patient->profession = $profession;
        $patient->password = bcrypt($password);
        return $this->model->patients()->save($patient);
    }

    /**
     * Method to delete patient related to nutritionist
     *
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deletePatient()
    {
        return $this->model->delete();
    }

    /**
     * Method for patient to update patient connected
     *
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $gender
     * @param string $numberPhone
     * @param string $profession
     * @return bool|mixed|null
     */
    public function updatePatient(
        $email,
        $firstName,
        $lastName,
        $gender,
        $numberPhone,
        $profession
    ) {
        $this->model->email = $email;
        $this->model->firstName = $firstName;
        $this->model->lastName = $lastName;
        //$this->model->password = bcrypt($password);
        $this->model->gender = $gender;
        $this->model->profession = $numberPhone;
        $this->model->numberPhone = $profession;
        $this->model->save();
        return $this->model;
    }

}
