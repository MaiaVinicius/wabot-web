<?php
/**
 * Created by PhpStorm.
 * User: maiavinicius
 * Date: 27/01/19
 * Time: 15:07
 */

namespace App\Support\Model;


use Illuminate\Support\Facades\DB;

class BaseModel
{


    protected function get($table, $where = [], $columns = [], $row = false)
    {
        if (is_numeric($where)) {
            $where = [
                "id" => $where
            ];
        }

        $res = DB::table(DB::raw($table))->where($where)->get();

        if (count($res) > 0) {
            return $this->rawAsArray($res, $row);
        } else {
            return false;
        }
    }


    /**
     * @param array $rawResult
     * @param bool $row
     * @param bool $column
     *
     * @return array|bool
     */
    protected function rawAsArray($rawResult, $row = false, $column = false, $std = false)
    {

        if ($std) {
            return $rawResult;
        }
        $res = json_decode(json_encode($rawResult), true);

        if ($row && $rawResult) {
            $res = $res[0];

            if ($column !== false && is_string($column)) {
                $res = $res[$column];
            }
        }

        return $res;
    }

    protected function raw($sql, $params = [], $realRaw = false)
    {
        if ($realRaw) {
            return DB::select(DB::raw($sql), $params);
        } else {
            return DB::select($sql, $params);
        }
    }

}