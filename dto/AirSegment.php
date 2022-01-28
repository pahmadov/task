<?php

namespace app\dto;

class AirSegment
{
    private $departureTime;
    private $arrivalTime;
    private $board;
    private $off;

    public function setDepartureTime(string $departureTime)
    {
        $this->departureTime = strtotime($departureTime);
    }

    public function setArrivalTime(string $arrivalTime)
    {
        $this->arrivalTime = strtotime($arrivalTime);
    }

    public function setBoard(string $board)
    {
        $this->board = $board;
    }

    public function setOff(string $off)
    {
        $this->off = $off;
    }

    public function getDepartureTime()
    {
        return $this->departureTime;
    }

    public function getArrivalTime()
    {
        return $this->arrivalTime;
    }

    public function getBoard()
    {
        return $this->board;
    }

    public function getOff()
    {
        return $this->off;
    }
}