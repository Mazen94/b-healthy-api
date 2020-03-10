<?php


namespace App\Repositories;


use App\Nutritionist;
use App\Patient;


class PatientRepository
{
    /**
     * Method to create a new patient related to patient
     *
     * @param Nutritionist $nutritionist
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $password
     * @param string $gender
     * @param string $numberPhone
     * @param string $profession
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public static function createPatient(
        $nutritionist,
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
        return $nutritionist->patients()->save($patient);
    }

    /**
     * Method to delete patient related to nutritionist
     *
     * @param Patient $patient
     * @return bool|mixed|null
     * @throws \Exception
     */
    public static function deletePatient($patient)
    {
        return $patient->delete();
    }

    /**
     * Method to update patient connected
     *
     * @param Patient $patient
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $gender
     * @param string $numberPhone
     * @param string $profession
     * @return bool|mixed|null
     */
    public static function updatePatient(
        $patient,
        $email,
        $firstName,
        $lastName,
        $gender,
        $numberPhone,
        $profession
    ) {
        $patient->email = $email;
        $patient->firstName = $firstName;
        $patient->lastName = $lastName;
        //$patient->password = bcrypt($password);
        $patient->gender = $gender;
        $patient->profession = $numberPhone;
        $patient->numberPhone = $profession;
        $patient->save();
        return $patient;
    }

}
