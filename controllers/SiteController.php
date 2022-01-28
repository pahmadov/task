<?php

namespace app\controllers;

use app\dto\AirSegment;
use app\forms\XmlForm;
use app\services\AirService;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Request;
use yii\web\Response;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex(Request $request)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new XmlForm();
        $model->file = UploadedFile::getInstance($model, 'file');

        if ($model->validate()) {
            $xml = $model->upload();

            $parsedXml = new \SimpleXMLElement($xml);

            $airSegments = $parsedXml->AirSegments->AirSegment;

            $airService = new AirService();

            foreach ($airSegments as $value) {
                $airSegment = new AirSegment();
                $airSegment->setDepartureTime($value->Departure['Date'] . ' ' . $value->Departure['Time']);
                $airSegment->setArrivalTime($value->Arrival['Date'] . ' ' . $value->Arrival['Time']);
                $airSegment->setBoard($value->Board['Point']);
                $airSegment->setOff($value->Off['Point']);

                $airService->setAirSegment($airSegment);
            }

            $airRoad = $airService->getAirRoad();

            return [
                'success' => true,
                'data' => [
                    'airRoad' => $airRoad
                ]
            ];
        }

        return [
            'success' => false
        ];
    }
}
