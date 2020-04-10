<?php

namespace App\Http\Controllers\Control\Board;

use App\Entities\Kanban\Column;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Control\Column\UpdateColumnRequest;

class PositionChanger extends Controller
{
    public function update($id, UpdateColumnRequest $request)
    {
        //Если при обновлении изменяется позиция
        if (array_key_exists('position', $request->all())) {
            //Находим колонку, которую изменяем
            $this_column = Column::find($id);
            //Находим лимит колонок которым нужно изменить значение
            $limit = abs($this_column->position - $request->position);
            $increment = 1;
            $comparison = '<=';
            $direction = 'desc';

            //Если новая позиция меньше старой
            if ($this_column->position > $request->position) {
                $increment = -1;
                $comparison = '>=';
                $direction = 'asc';
            }

            //Тогда изменяем те что выше/ниже
            Column::where('board_id', $this_column->board_id)
                ->where('position', $comparison, $request->position)
                ->orderBy('position', $direction)
                ->limit($limit)
                ->get()
                ->except($this_column->id)
                //Изменяем у каждого значение
                ->each(function ($item) use ($increment) {
                    $item['position'] -= $increment;
                    $item->save();
                });
            Column::find($id)->update($request->all());
        }
        return Column::find($id);
    }
}
