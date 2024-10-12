<?php

namespace App\Tasks;

use App\Enum\RegistrationStatusEnum;
use App\Models\VaccineRegistration;
use Carbon\Carbon;

class DistributeVaccinee
{
    /**
     * Invoke the class instance.
     */
    public function __invoke(): void
    {
        $vaccineCenters = $this->getVaccineCenterAssociatedIdLimit();
        $centersAssociationCenterIdPersonArray = $this->getCentersAssociationCenterIdPersonArray();

        /**
         * First, it will Loop the vaccine center (which are selected on form submission only)
         */
        foreach ($centersAssociationCenterIdPersonArray as $centerID => $personsToBeAssigned) {
            $remainingPersonsToBeAssigned = [...$personsToBeAssigned];
            $assignDate = Carbon::today();
            $flag = true;
            $skipCountQuery = false;
            while ($flag) {
                $assignDate->addDay();
                while ($assignDate->isFriday() || $assignDate->isSaturday()){
                    continue 2; //it will stop the iteration of this loop and continue from the parent loop
                }

                $limit = $vaccineCenters[$centerID];
                $countThisDay = 0;
                if (!$skipCountQuery) {
                    $countThisDay = VaccineRegistration::where('vaccination_date', $assignDate)->count();
                    if (!$countThisDay) {
                        $skipCountQuery = true; //If system found a full empty day, that means the following days are also be empty. We can manage this to skip query execution in each loop
                    }
                }
                $numberOfPersonBeAssigned = ($limit - $countThisDay);
                $actualPersonsToAssignIds = array_splice($remainingPersonsToBeAssigned, 0, $numberOfPersonBeAssigned);

                $this->assignSchedule($actualPersonsToAssignIds, $assignDate);

                if (!$remainingPersonsToBeAssigned) {
                    $flag = false;
                }
            }

        }
    }

    /**
     * Main action to assign vaccination date
     * @param $actualPersonsToAssignIds
     * @param $assignDate
     */
    private function assignSchedule($actualPersonsToAssignIds, $assignDate): void
    {
        VaccineRegistration::whereIn('id', $actualPersonsToAssignIds)->update([
            'vaccination_date' => $assignDate,
            'status' => RegistrationStatusEnum::SCHEDULED
        ]);
    }


    /**
     * Collection will be converted to a custom associative array
     * where keys are vaccine_center_id
     * and values are day limit
     * @return array
     */
    private function getVaccineCenterAssociatedIdLimit(): array
    {
        $vaccineCenters = \App\Models\VaccineCenter::select(['id', 'day_limit'])->get()->toArray();
        $ids = array_column($vaccineCenters, 'id');
        $limits = array_column($vaccineCenters, 'day_limit');
        return array_combine($ids, $limits);
    }

    /**
     * Collection will be converted to a custom associative array
     * where keys are vaccine_center_id
     * and values are personIdArray
     * @return array
     */
    private function getCentersAssociationCenterIdPersonArray(): array
    {
        $persons = VaccineRegistration::whereNull('vaccination_date')->where('status', RegistrationStatusEnum::NOT_SCHEDULED)->orderBy('created_at', 'asc')->get();
        $centersAssociationCenterIdPersonArray = [];
        foreach ($persons as $person) {
            $centersAssociationCenterIdPersonArray[$person->vaccine_center_id][] = $person->id;
        }
        return $centersAssociationCenterIdPersonArray;
    }
}
