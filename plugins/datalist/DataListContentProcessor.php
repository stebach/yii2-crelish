<?php
namespace giantbits\crelish\plugins\datalist;

use giantbits\crelish\components\CrelishJsonDataProvider;
use yii\base\Component;

class DataListContentProcessor extends Component
{
  public $data;

  public static function processData($caller, $key, $data, &$processedData)
  {

    if (empty($processedData[$key])) {
      $processedData[$key] = [];
    }

    if ($data) {
      $filters = null;
      $sort = null;

      if(!empty($data['filter'])) {
        foreach($data['filter'] as $filter) {
          if(is_array($filter)) {
            $filters[key($filter)] = $filter[key($filter)];
          } elseif(!empty($_GET[$filter]) ) {
            $filters[$filter] = $_GET[$filter];
          }
        }
      }

      if(!empty($data['sort'])) {
        $sort['by'] = (!empty($data['sort']['by'])) ? $data['sort']['by'] : null;
        $sort['dir'] = (!empty($data['sort']['dir'])) ? $data['sort']['dir'] : null;
      }

      $sourceData = new CrelishJsonDataProvider($data['source'], ['filter'=>$filters, 'sort'=>$sort]);

      $processedData[$key] = $sourceData->raw();

    }
  }
}