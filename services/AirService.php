<?php

namespace app\services;

use app\dto\AirSegment;

class AirService
{
    private $airSegments = [];
    private $breakPoint = null;

    public function setAirSegment(AirSegment $airSegment)
    {
        $this->airSegments[] = $airSegment;
    }

    public function getAirSegments()
    {
        return $this->airSegments;
    }
    public function getAirRoad()
    {
        $this->setBreakPoint();

        $result = '';

        foreach ($this->getAirSegments() as $key => $airSegment) {
            if ($key === $this->breakPoint) {
                $result .= 'obratno ' . $airSegment->getBoard() . ', ';
            }

            $result .= $airSegment->getBoard() . ', ';
        }

        $result = substr($result, 0, -2);

        return $result;
    }

    protected function setBreakPoint()
    {
        $maxBreakTime = 0;
        $lastArrivalTime = null;

        foreach ($this->airSegments as $key => $airSegment) {
            if (is_null($lastArrivalTime)) {
                $lastArrivalTime = $airSegment->getArrivalTime();
                continue;
            }

            $breakTime = $airSegment->getDepartureTime() - $lastArrivalTime;

            if ($maxBreakTime < $breakTime) {
                $maxBreakTime = $breakTime;
                $this->breakPoint = $key;
            }
        }

        return $this->breakPoint;
    }
}