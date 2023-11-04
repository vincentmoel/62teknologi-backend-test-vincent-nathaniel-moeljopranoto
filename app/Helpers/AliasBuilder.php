<?php 
namespace App\Helpers;
use Illuminate\Support\Str;
class AliasBuilder{

    public static function create($model, $column, $value, $id = null)
    {
        $counter = "1";

        $code = Str::of($value)->slug('-')->toString();
        do{
            $codeFound = (new self($model, $column, $code, $id))->checkSlugIsExists($model,$column, $code, $id);
            if(!$codeFound)
            {
                return $code;
            }
            $counter++;
            $code = Str::of($value)->slug('-')->toString() . '-' . $counter;
        }while($codeFound);

        return;

    }

    /**
     * Find same model with same string
     * @param  Model $model
     * @param  string $column
     * @param  string $text* @param  string $model
     * @return boolean
     */
    protected function checkSlugIsExists($model, $column, $value, $id)
    {
        $query = $model::where($column, $value);
        
        if($id != null)
        {
            $query->where('id','!=',$id);
        }
        return $query->exists();
    }



}

?>