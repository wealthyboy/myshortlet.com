<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PeakPeriod extends Model
{
    use HasFactory;

    protected $dates = ['start_date', 'end_date'];

    public $appends = [
        'is_peak_period_active',
        'peak_period_days_Left',
        'from_date',
        'to_date',
        'days_within_peak_period'
    ];



    public function getPeakPeriodDaysLeftAttribute()
    {
       return $this->daysLeftInRange($this->start_date, $this->end_date);
    }


    public function getIsPeakPeriodActiveAttribute()
    {
       return $this->days_limit <= $this->daysLeftInRange($this->start_date, $this->end_date);
    } 

    function increasePriceByPercentage($price)
   {

        $increase = ($price * $this->discount) / 100;
        return $price + $increase;
   }

    public function getFromDateAttribute()
        {
        return $this->start_date->format('l') . ' ' .  $this->start_date->format('d') . ' ' .  $this->start_date->format('F') . ' ' . $this->start_date->isoFormat('Y');

        } 

        public function getToDateAttribute()
        {
            return $this->end_date->format('l') . ' ' .  $this->end_date->format('d') . ' ' .  $this->end_date->format('F') . ' ' .  $this->end_date->isoFormat('Y');
        } 


        public function getDaysWithinPeakPeriodAttribute()
        {
            return $this->end_date->format('l') . ' ' .  $this->end_date->format('d') . ' ' .  $this->end_date->format('F') . ' ' .  $this->end_date->isoFormat('Y');
        } 


        function daysLeftInRange($startDate, $endDate)
        {
            $start = $startDate;
            $end = $endDate;
            $today = Carbon::today();
            if ($today->lessThan($start)) {
                return 0;
            } elseif ($today->greaterThan($end)) {
                return 0;
            } else {
                return $today->diffInDays($end);
            }
        }


        function calculateDaysWithinPeak($userStartDate, $userEndDate)
        {
            // Parse only user input dates into Carbon instances
            $userStart = $userStartDate;
            $userEnd = $userEndDate;

            // Find the overlapping period
            $overlapStart = $userStart->greaterThan($this->start_date) ? $userStart : $this->start_date;
            $overlapEnd = $userEnd->lessThan($this->end_date) ? $userEnd : $this->end_date;


            // If there is no overlap, return 0
            if ($overlapStart->greaterThan($overlapEnd)) {
                return 0;
            }

            // Calculate the number of days, including both start and end days
            return $overlapStart->diffInDays($overlapEnd);
        }


        function calculateOverlappingDays($requestStart, $requestEnd)
    {
        // Parse the dates using Carbon
 

        // Find the actual overlap period
        $overlapStart = $requestStart->max($this->start_date);
        $overlapEnd = $requestEnd->min($this->end_date);


        // Calculate the number of overlapping days
        if ($overlapStart <= $overlapEnd) {
            return $overlapStart->diffInDays($overlapEnd) + 1; // +1 to include both start and end days
        }

        // No overlap
        return 0;
    }



    function calculateDaysOutsidePeak($userStartDate, $userEndDate)
    {
        // Parse only user input dates into Carbon instances
        $userStart = Carbon::parse($userStartDate);
        $userEnd = Carbon::parse($userEndDate);
        // Total days in the user range
        $totalUserDays = $userStart->diffInDays($userEnd) + 1;

        // Find overlapping period    
        $overlapStart = $userStart->greaterThan($this->start_date) ? $userStart : $this->start_date;
        $overlapEnd = $userEnd->lessThan($this->end_date) ? $userEnd : $this->end_date;

        // Calculate overlapping days
        $overlappingDays = $overlapStart->greaterThan($overlapEnd) ? 0 : $overlapStart->diffInDays($overlapEnd) + 1;

        // Days outside the peak period
        return ($totalUserDays - $overlappingDays) -1;
    }

}
