<?php


namespace App\Repositories;


use App\Patient;
use Illuminate\Database\Eloquent\Model;


class PatientRepository
{
    protected $patient;

    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }


    /**
     * Method to delete patient related to nutritionist
     *
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function deletePatient()
    {
        return $this->patient->delete();
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
        $this->patient->email = $email;
        $this->patient->firstName = $firstName;
        $this->patient->lastName = $lastName;
        //$this->patient->password = bcrypt($password);
        $this->patient->gender = $gender;
        $this->patient->profession = $numberPhone;
        $this->patient->numberPhone = $profession;
        $this->patient->save();
        return $this->patient;
    }

}
